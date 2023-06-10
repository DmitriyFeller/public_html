<?php


namespace core\base\controller;


trait BaseMethods
{


    protected function  clearStr($str){ //метод отчистки строковых данных

        if(is_array($str)){
            foreach ($str as $key => $item) $str[$key] = $this->clearStr($item);
            return $str;
        }else{
            return trim(strip_tags($str));
        }

    }

    protected function clearNum($num){//метод отчистки числовых данных

        return (!empty($num) && preg_match('/\d/', $num)) ?
            preg_replace('/[^\d.]/', '', $num) * 1 : 0;
    }

    protected function isPost(){
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    protected function isAjax(){
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    protected function redirect($http = false, $code = false){
        if($code){
            $codes = ['301' => 'HTTP/1.1 301 Move Permanently'];

            if($codes[$code]) header($codes[$code]);
        }

        if($http) $redirect = $http;
            else $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;

            header("Location: $redirect"); // двойные кавычки помогает искать переменные, если будет переменная, то он просто подставит ее значение в строку

            exit;
    }

    protected function getStyles(){

        if($this->styles){
            foreach ($this->styles as $style) echo '<link rel="stylesheet" href="' . $style . '">';
        }

    }

    protected function getScripts(){
        if($this->scripts){
            foreach ($this->scripts as $script) echo '<script src="' . $script .'"></script>';
        }

    }

    protected function writeLog($message, $file = 'log.txt', $event = 'Fault'){

        $dateTime = new \DateTime();

        $str = $event . ': ' . $dateTime->format('d-m-Y G:i:s') . ' - ' . $message . "\r\n";

        file_put_contents('log/' . $file, $str, FILE_APPEND);

    }

    protected function getController(){

        return $this->controller ?:
            $this->controller = preg_split('/_?controller/',strtolower(preg_replace('/([^A-Z])([A-Z])/', '$1_$2', (new \ReflectionClass($this))->getShortName())), 0, PREG_SPLIT_NO_EMPTY)[0]; //чтобы контроллеры подключались с нижним подчеркиванием (?)

    }
}