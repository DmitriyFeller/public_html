<?php


namespace core\admin\controller;

use core\base\controller\BaseMethods;
class CreatesitemapController extends BaseAdmin
{
    use BaseMethods;

    protected $all_links = [];
    protected $temp_links = [];
    protected $bad_links = [];

    protected $maxLinks = 5000;


    protected $parsingLogFile = 'parsing_log.txt';
    protected $fileArr = ['jpg', 'png', 'jpeg','gif', 'xls', 'xlsx', 'mp4', 'mpeg', 'mp3'];

    protected $filterArr = [
        'url' => ['order', 'page'],
        'get' => []
    ];

    public function inputData($links_counter = 1, $redirect = true){

        $links_counter = $this->clearNum($links_counter);

        if(!function_exists('curl_init')){//проверяет, существует ли функция

            $this->cancel(0, 'Library CURL as apsent. Creation of sitemap impossible', '', true);


        }

        if(!$this->userID) $this->execBase();

        if(!$this->checkParsingTAble()) {

            $this->cancel(0, 'You have problems with database table parsing_data', '', true);

        }

        set_time_limit(0);//не ограничили время выполнения скрипта

        $reserve = $this->model->get('parsing_data')[0];

        $table_rows = [];

        foreach ($reserve as $name => $item){

            $table_rows[$name] = '';

            if ($item) $this->$name = json_decode($item);
                elseif ($name === 'all_links' || $name === 'temp_links') $this->$name = [SITE_URL];

        }

        $this->maxLinks = (int) $links_counter > 1 ? ceil($this->maxLinks / $links_counter) : $this->maxLinks; //ceil округляет значение заданное значение до заданного целого, если 2 пар-р не передан

        while ($this->temp_links){

            $temp_links_count = count($this->temp_links);

            $links  = $this->temp_links;

            $this->temp_links = [];

            if($temp_links_count > $this->maxLinks){

                $links = array_chunk($links,ceil($temp_links_count / $this->maxLinks)); //делить массив на равное кол-во частей

                $count_chunks = count($links);

                for($i = 0; $i < $count_chunks; $i++){

                    $this->parsing($links[$i]);

                    unset($links[$i]);

                    if($links){

                        foreach ($table_rows as $name => $item){

                            if($name === 'temp_links') $table_rows[$name] = json_encode(array_merge(...$links));
                                else $table_rows[$name] = json_encode($this->$name);

                        }

                        $this->model->edit('parsing_data',[
                            'fields' => [
                                'temp_links' => json_encode(array_merge(...$links)), //это деструктивное присваивание (последовательность массивов), которую ф-ия array_merge не съест
                                'all_links' => json_encode($this->all_links)
                            ],
                        ]);

                    }

                }

            }else{

                $this->parsing($links);

            }

            foreach ($table_rows as $name => $item){

                $table_rows[$name] = json_encode($this->$name);

            }

            $this->model->edit('parsing_data',[
                'fields' => $table_rows
            ]);

        }

        foreach ($table_rows as $name => $item){

            $table_rows[$name] = '';

        }

        $this->model->edit('parsing_data',[
            'fields' => $table_rows
        ]);
        if($this->all_links){

            foreach ($this->all_links as $key => $link){

                if(!$this->filter($link) || in_array($link, $this->bad_links)) unset($this->all_links[$key]);


            }

        }

        $this->createSitemap();

        if($redirect){

            !$_SESSION['res']['answer'] && $_SESSION['res']['answer'] = '<div class="success">Sitemap is created</div>>';

            $this->redirect();

        }else{

            $this->cancel(1,'Sitemap is created! ' . count($this->all_links) . ' links', '', true);

        }
    }

    protected function parsing($urls){

        if(!$urls) return;

        $curlMulti = curl_multi_init();

        $curl = [];

        foreach ($urls as $i => $url){

            $curl[$i] = curl_init(); //инициализация curl
            curl_setopt($curl[$i], CURLOPT_URL, $url);
            curl_setopt($curl[$i], CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl[$i], CURLOPT_HEADER, true);
            curl_setopt($curl[$i], CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl[$i], CURLOPT_TIMEOUT, 120);
            curl_setopt($curl[$i], CURLOPT_ENCODING, 'gzip,deflate'); //разбирает страницу, сжатую в jzip

            curl_multi_add_handle($curlMulti, $curl[$i]);
        }

        do{

            $status = curl_multi_exec($curlMulti, $active);
            $info = curl_multi_info_read($curlMulti);

            if(false !== $info){

                if($info['result'] !== 0){

                    $i = array_search($info['handle'], $curl);

                    $error = curl_errno($curl[$i]);
                    $message = curl_error($curl[$i]);
                    $header = curl_getinfo($curl[$i]);

                    if($error !== 0){

                        $this->cancel(0, 'Error loading ' . $header['$url'] .
                                                        ' http code: ' . $header['http_code'] .
                                                        ' error: ' . $error . ' message' . $message
                                    );

                    }

                }

            }

            if($status > 0){

                $this->cancel(0,curl_multi_strerror($status));

            }

        }while($status === CURLM_CALL_MULTI_PERFORM || $active);

        $result = [];
        foreach ($urls as $i => $url){

            $result[$i] = curl_multi_getcontent($curl[$i]);
            curl_multi_remove_handle($curlMulti, $curl[$i]); //удалили curl из мульти потока
            curl_close($curl[$i]);

            if(!preg_match('/Content-Type:\s+text\/html/ui', $result[$i])) {

                $this->bad_links[] = $url;

                $this->cancel(0,'Incorrect content type ' . $url);

                continue;

            }

            if(!preg_match('/HTTP\/\d\.?\d?\s+20\d/ui',$result[$i])){

                $this->bad_links[] = $url;

                $this->cancel(0,'Incorrect server code ' . $url);

                continue;

            }

            $this->createLinks($result[$i]);

        }

        curl_multi_close($curlMulti);

    }

    protected function createLinks($content){

        if($content){

            preg_match_all('/<a\s*?[^>]*?href\s*?=(["\'])(.+?)\1[^>]*?>/ui', $content, $links);

            if($links[2]){

                foreach ($links[2] as $link){

                    if($link === '/' || $link === SITE_URL . '/') continue;

                    foreach ($this->fileArr as $ext){

                        if($ext){

                            $ext = addslashes($ext);
                            $ext = str_replace('.','\.', $ext);

                            if(preg_match('/' . $ext . '(\s*?$|\?[^\/]*$)/ui', $link)){

                                continue 2; //прервет 2 цикл

                            }

                        }

                    }

                    if(strpos($link, '/') === 0){
                        $link = SITE_URL . $link;
                    }

                    $site_url = mb_str_replace('.', '\.', mb_str_replace('/', '\/',SITE_URL));

                    if(!in_array($link, $this->bad_links) &&
                        !preg_match('/^('. $site_url .')?\/?#[^\/]*?$/ui', $link) &&
                        strpos($link, SITE_URL) === 0 &&
                        !in_array($link, $this->all_links)){

                        $this->temp_links[] = $link;
                        $this->all_links[] = $link;

                    }

                }

            }

        }

    }

    protected function filter($link){

        if($this->filterArr){

            foreach ($this->filterArr as $type => $values){

                if($values){

                    foreach ($values as $item){

                        $item = str_replace('/','\/', addslashes($item));

                        if($type === 'url'){
                            if(preg_match('/^[^\?]*' . $item . '/ui', $link)){
                                return false;
                            }
                        }

                        if($type === 'get'){

                            if(preg_match('/(\?|&amp;|=|&)'. $item.'(=|&amp;|&|$)/ui', $link, $matches)){
                                return false;
                            }


                        }

                    }

                }

            }

        }

        return true;

    }

    protected function checkParsingTAble(){

        $tables = $this->model->showTables();

        if(!in_array('parsing_data', $tables)){

            $query = 'CREATE TABLE parsing_data (all_links longtext, temp_links longtext, bad_links longtext)';

            if(!$this->model->query($query, 'c') ||
            !$this->model->add('parsing_data', ['fields' => ['all_links' => '', 'temp_links' => '', 'bad_links' => '']])
            ){ return false;}

        }

        return true;

    }

    protected function cancel($success = 0, $message = '', $log_message = '', $exit = false){

        $exitArr = [];

        $exitArr['success'] = $success;
        $exitArr['message'] = $message ? $message : 'ERROR PARSING';
        $log_message = $log_message ? $log_message : $exitArr['message'];

        $class = 'success';

        if(!$exitArr['success']){

            $class = 'error';

            $this->writeLog($log_message, 'parsing_log.txt');

        }

        if($exit){

            $exitArr['message'] = '<div> class="' . $class. '">' . $exitArr['message'] . '</div>>';
            exit(json_encode($exitArr));

        }

    }

    protected function createSitemap(){

        $dom = new \domDocument('1.0', 'utf-8');
        $dom->formatOutput = true;

        $root = $dom->createElement('urlset');
        $root->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $root->setAttribute('xmlns:xls', 'http://w3.org/2001/XMLSchema-instance');
        $root->setAttribute('xsi:schemaLocation', 'http://www.sitemaps.org/schemas/sitemap/0.9 http://http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd');

        $dom->appendChild($root);

        $sxe = simplexml_import_dom($dom);

        if($this->all_links){

            $date = new \DateTime();
            $lastMod = $date->format('Y-m-d') . 'T' . $date->format('H:i:s+01:00');

            foreach ($this->all_links as $item){

                $elem = trim(mb_substr($item, mb_strlen(SITE_URL)), '/');
                $elem = explode('/', $elem);

                $count = '0.' . (count($elem) - 1);
                $priority = 1 - (float) $count;

                if($priority == 1) $priority = '1.0';

                $urlMain = $sxe->addChild('url');

                $urlMain->addChild('loc', htmlspecialchars($item)); //htmlspecialchars - ф-ия, которая приводит все спец символы к html-сущности

                $urlMain->addChild('lastmod', $lastMod);
                $urlMain->addChild('changefreq', 'weekly');
                $urlMain->addChild('priority', $priority);

            }

        }

        $dom->save($_SERVER['DOCUMENT_ROOT'] . PATH . 'sitemap.xml');

    }

}