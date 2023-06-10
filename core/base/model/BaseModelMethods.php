<?php


namespace core\base\model;


abstract class BaseModelMethods
{

    protected $sqlFunc = ['RAND()','NOW()']; //массив sql ф-ий

    protected $tableRows;

    protected $union = [];

    protected function createFields($set, $table = false, $join = false){

        if(array_key_exists('fields', $set) && $set['fields'] === null) return '';

        $concat_table = '';

        $alias_table = $table;

        if(!$set['no_concat']){

            $arr = $this->createTableAlias($table);

            $concat_table = $arr['alias'] . '.';

            $alias_table = $arr['alias'];

        }

        $fields = '';

       $join_structure = false;

       if(($join || isset($set['join_structure']) && $set['join_structure']) && $table){

           $join_structure = true;

           $this->showColumns($table);

           if(isset($this->tableRows[$table]['multi_id_row'])) $set['fields'] = [];

       }

       if(!isset($set['fields']) || !is_array($set['fields']) || !$set['fields']){

            if(!$join){

                $fields = $concat_table . '*,';

            }else{

                foreach ($this->tableRows[$alias_table] as $key => $item){

                    if($key !== 'id_row' && $key !== 'multi_id_row'){

                        $fields .= $concat_table . $key . ' as TABLE' . $alias_table . 'TABLE_' . $key . ',';

                    }

                }

            }

       }else{

            $id_field = false;

            foreach ($set['fields'] as $field){

                if($join_structure && !$id_field && $this->tableRows[$alias_table] === $field){

                    $id_field = true;

                }

                if($field || $field === null) {

                    if($field === null){

                        $fields .= "NULL,";

                        continue;

                    }

                    if($join && $join_structure ){

                        if (preg_match('/^(.+)?\s+as\s+(.+)/i', $field , $matches)){

                            $fields .= $concat_table . $matches[1] . ' as TABLE' . $alias_table . 'TABLE_' . $matches[2] . ',';

                        }else{

                            $fields .= $concat_table . $field . ' as TABLE' . $alias_table . 'TABLE_' . $field . ',';

                        }

                    }else{

                        $fields .= (!preg_match('/(\([^()]*\))|(case\s+.+?\s+end)/i',$field) ? $concat_table : '') . $field . ',';

                    }

                }

            }

            if (!$id_field && $join_structure){

                if($join){

                    $fields .= $concat_table . $this->tableRows[$alias_table]['id_row'] . ' as TABLE' . $alias_table . 'TABLE_' . $this->tableRows[$alias_table]['id_row'] . ',';

                }else{

                    $fields .= $concat_table . $this->tableRows[$alias_table]['id_row'] . ',';

                }

            }

       }

       return $fields;

    }

    protected function createOrder ($set, $table = false){

        $table = ($table && (!isset($set['no_concat']) || !$set['no_concat']))
                ? $this->createTableAlias($table)['alias'] . '.' : '';

        $order_by = '';

        if(isset($set['order']) && ($set['order'])){

            $set['order'] = (array)$set['order'];

            $set['order_direction'] = (isset($set['order_direction']) && ($set['order_direction']))
                ? (array)$set ['order_direction'] : ['ASC'];

            $order_by = 'ORDER BY ';
            $direct_count = 0;

            foreach($set['order'] as $order){

                if($set['order_direction'][$direct_count]){
                    $order_direction = strtoupper($set['order_direction'][$direct_count]);//strtoupper() - приводит строку к верхнему регистру
                    $direct_count++;
                }else{
                    $order_direction = strtoupper($set['order_direction'][$direct_count - 1]);
                }

                if(in_array($order, $this->sqlFunc)) $order_by .= $order . ',';
                elseif(is_int($order)) $order_by .= $order . ' ' . $order_direction . ',';
                else $order_by .= $table . $order . ' ' . $order_direction . ',';
            }

            $order_by = rtrim($order_by,',');
        }
        return $order_by;
    }

    protected function  createWhere($set, $table = false, $instruction = 'WHERE'){

        $table = ($table && (!isset($set['no_concat']) || !$set['no_concat']))
            ? $this->createTableAlias($table)['alias'] . '.' : '';

        $where = '';

        if(is_string($set['where'])){
            return $instruction . ' ' .  trim($set['where']);
        }

        if(is_array($set['where']) && !empty($set['where'])){

            $set['operand'] = (is_array($set['operand']) && !empty($set['operand'])) ? $set['operand'] : ['='];
            $set['condition'] = (is_array($set['condition']) && !empty($set['condition'])) ? $set['condition'] : ['AND'];

            $where = $instruction;

            $o_count = 0;
            $c_count = 0;

            foreach ($set['where'] as $key => $item){

                $where .= ' ';

                if($set['operand'][$o_count]){ //в массисе set операнд и его ячейка o_count, если в ней что-либо есть
                    $operand = $set['operand'] [$o_count];
                    $o_count++;
                }else{
                    $operand = $set['operand'] [$o_count - 1]; //записываем предыдущее значение
                }

                if($set['condition'][$c_count]){ //в массисе set condition и его ячейка c_count, если в ней что-либо есть
                    $condition = $set['condition'] [$c_count];
                    $c_count++;
                }else{
                    $condition = $set['condition'] [$c_count - 1]; //записываем предыдущее значение
                }

                if($operand === 'IN' || $operand === 'NOT IN'){

                    if(is_string($item) && strrpos($item, 'SELECT') === 0){
                        $in_str = $item;
                    }else{
                        if(is_array($item)) $temp_item = $item;
                        else $temp_item = explode(',',$item);

                        $in_str = '';

                        foreach ($temp_item as $v){
                            $in_str .= "'" . addslashes(trim($v)) . "',";
                        }
                    }
                    $where .= $table .$key . ' ' .$operand . ' (' . trim($in_str, ',') . ') ' . $condition;

                }elseif (strpos($operand, 'LIKE') !== false){

                    $like_template = explode('%', $operand);

                    foreach ($like_template as $lt_key => $lt){
                        if(!$lt){
                            if(!$lt_key){
                                $item = '%' . $item;
                            }else{
                                $item .= '%';
                            }
                        }
                    }

                    $where .= $table . $key . ' LIKE ' . "'" . addslashes($item) . "' $condition";


                }else{

                    if(strpos($item, 'SELECT') === 0) {
                        $where .= $table . $key . $operand . ' (' . $item . ") $condition";
                    }elseif ($item === null || $item === 'NULL'){
                        if($operand === '=') $where .= $table . $key . ' IS NULL ' . $condition;
                        else $where .= $table . $key . ' IS NOT NULL ' . $condition;
                    }else{
                        $where .= $table . $key . $operand .  "'" . addslashes($item) . "' $condition";
                    }

                }

            }

            $where = substr($where, 0, strrpos($where, $condition));

        }

        return $where;

    }

    protected function createJoin($set, $table, $new_where = false){

        $fields = '';
        $join = '';
        $where = '';

        if($set['join']){

            $join_table = $table;

            foreach ($set['join'] as $key => $item){

                if(is_int($key)){
                    if(!$item['table']) continue;
                        else $key = $item['table'];
                }

                $concatTable = $this->createTableAlias($key)['alias'];

                if($join) $join .= ' ';

                if(isset($item['on']) && $item['on']){

                    if(isset($item['on']['fields']) && is_array($item['on']['fields']) && count($item['on']['fields']) === 2){

                        $join_fields = $item['on']['fields'];

                    }elseif(count($item['on']) === 2){

                        $join_fields = $item['on'];

                    }else{

                        continue;

                    }

                    if(!$item['type']) $join .= 'LEFT JOIN ';
                        else $join .= trim(strtoupper($item['type'])). ' JOIN ';

                    $join .= $key . ' ON ';

                    if($item['on']['table']) $join_temp_table = $item['on']['table'];
                    else $join_temp_table = $join_table;

                    $join .=$this->createTableAlias($join_temp_table)['alias'];

                    $join .= '.' . $join_fields[0] . '=' . $concatTable . '.' . $join_fields[1];

                    $join_table = $key;

                    if($new_where){

                        if($item['where']){
                            $new_where = false;
                        }

                        $group_condition = 'WHERE';

                    }else{
                        $group_condition = $item['group_condition'] ? strtoupper($item['group_condition']) : 'AND';
                    }

                    $fields .= $this->createFields($item,$key, $set['join_structure']);
                    $where .= $this->createWhere($item, $key, $group_condition);

                }

            }


        }

        return compact('fields','join', 'where');

    }

    protected function createInsert($fields, $files, $except){

        $insert_arr = [];

        $insert_arr['fields'] = '(';

        $array_type = array_keys($fields)[0];

        if(is_int($array_type)){

            $check_fields = false;
            $count_fields = 0;

            foreach ($fields as $i => $item){

                $insert_arr['values'] .= '(';

                if(!$count_fields) $count_fields = count($fields[$i]);

                $j =0;

                foreach ($item as $row => $value){

                    if($except && in_array($row, $except)) continue;

                    if(!$check_fields) $insert_arr['fields'] .= $row . ',';

                    if(in_array($value, $this->sqlFunc)){
                        $insert_arr['values'] .= $value . ',';
                    }elseif ($value == 'NULL' || $value === NULL){
                        $insert_arr['values'] .= "NULL" . ',';
                    }else{
                        $insert_arr['values'] .= "'" . addslashes($value) . "',";
                    }

                    $j++;

                    if($j === $count_fields) break;

                }


                $insert_arr['values'] = rtrim($insert_arr['values'], ',') . '),';

                if(!$check_fields) $check_fields = true;

            }

        }else{

            $insert_arr['values'] = '(';

            if($fields){

                foreach ($fields as $row => $value){

                    if($except && in_array($row, $except)) continue;

                    $insert_arr['fields'] .= $row . ',';

                    if(in_array($value, $this->sqlFunc)){
                        $insert_arr['values'] .= $value . ',';
                    }elseif($value == 'NULL' || $value === NULL){
                        $insert_arr['values'] .= "NULL" . ',';
                    }else{
                        $insert_arr['values'] .= "'" . addslashes($value) . "',";
                    }

                }

            }
            if($files){

                foreach ($files as $row => $file){

                    $insert_arr['fields'] .= $row . ',';

                    if(is_array($file)) $insert_arr['values'] .= "'" . addslashes(json_encode($file)) . "',";
                        else $insert_arr['values'] .= "'" . addslashes($file) . "',";
                }

            }

            $insert_arr['values'] =  rtrim($insert_arr['values'], ',') . ')';

        }

        $insert_arr['fields'] = rtrim($insert_arr['fields'], ',') . ')';
        $insert_arr['values'] =  rtrim($insert_arr['values'], ',');

        return $insert_arr;

    }

    protected function createUpdate($fields, $files, $except){

        $update = '';

        if($fields){
            foreach ($fields as $row => $value){

                if ($except && in_array($row, $except)) continue;

                $update .= $row . '=';

                if(in_array($value, $this->sqlFunc)){
                    $update .= $value . ',';
                }elseif ($value === NULL || $value === 'NULL'){
                    $update .= "NULL" . ',';
                }else{
                    $update .= "'" . addslashes($value) . "',";
                }
            }
        }

        if($files){

            foreach ($files as $row => $file){

                $update .= $row . '=';

                if(is_array($file)) $update .= "'" . addslashes(json_encode($file)) . "',";
                else $update .= "'" . addslashes($file) . "',";

            }

        }

        return rtrim($update,',');

    }

    protected function joinStructure($res, $table){

        $join_arr = [];

        $id_row = $this->tableRows[$this->createTableAlias($table)['alias']]['id_row'];

        foreach ($res as $value){

            if($value){

                if(!isset($join_arr[$value[$id_row]])) $join_arr[$value[$id_row]] = [];

                foreach ($value as $key => $item){

                    if(preg_match('/TABLE(.+)?TABLE/u',$key, $matches)){

                        $table_name_normal = $matches[1];

                        if(!isset($this->tableRows[$table_name_normal]['multi_id_row'])){

                            $join_id_row = $value[$matches[0] . '_' . $this->tableRows[$table_name_normal]['id_row']];

                        }else{

                            $join_id_row = '';

                            foreach ($this->tableRows[$table_name_normal]['multi_id_row'] as $multi){

                                $join_id_row .= $value[$matches[0] . '_' . $multi];

                            }

                        }

                        $row = preg_replace('/TABLE(.+)TABLE_/u', '', $key);

                        if($join_id_row && !isset($join_arr[$value[$id_row]]['join'][$table_name_normal][$join_id_row][$row])){

                            $join_arr[$value[$id_row]]['join'][$table_name_normal][$join_id_row][$row] = $item;

                        }

                        continue;

                    }

                    $join_arr[$value[$id_row]][$key] = $item;

                }

            }

        }

        return $join_arr;

    }

    protected function createTableAlias($table){ //создает алиасы для таблиц

        $arr = [];

        if(preg_match('/\s+/i',$table)){

            $table = preg_replace('/\s{2,}/i', ' ', $table);

            $table_name = explode(' ', $table);

            $arr['table'] = trim($table_name[0]);
            $arr['alias'] = trim($table_name[1]);

        }else{

            $arr['alias'] = $arr['table'] = $table;

        }

        return $arr;

    }


}