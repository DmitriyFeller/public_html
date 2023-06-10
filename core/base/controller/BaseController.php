<?php

//подключает другие контроллеры(?)
namespace core\base\controller;


use core\base\exceptions\RouteException;
use core\base\model\UserModel;
use core\base\settings\Settings;
abstract class BaseController
{

    use \core\base\controller\BaseMethods;

    protected $header;
    protected $content;
    protected $footer;

    protected $page;

    protected $errors;

    protected $controller;
    protected $inputMethod;
    protected $outputMethod;
    protected $parameters;

    protected $template;
    protected $styles;
    protected $scripts;

    protected $userID;
    protected $data;
    protected $ajaxData;

    public function route(){

        $controller = str_replace('/', '\\', $this->controller);

        try {

            $object = new \ReflectionMethod($controller, 'request');

            $args = [ //параметры адресной строки
                'parameters' => $this->parameters,
                'inputMethod' => $this->inputMethod,
                'outputMethod' => $this->outputMethod

            ];

            $object->invoke(new $controller, $args);

        } catch (\ReflectionException $e) {
            throw  new RouteException($e->getMessage());
        }
    }
    public function request ($args){
        $this->parameters = $args['parameters'];

        $inputData = $args['inputMethod'];
        $outputData = $args['outputMethod'];

        $data = $this->$inputData();

        if(method_exists($this, $outputData)) {
            $page = $this->$outputData($data); //провер существ ли метод у объекта переданн  1 пар-ром и методв  кач-ве строки передается 2 пар-ром
            // если существ в IndexController метод outputData, то в переменную this page вернем outputData
            if($page) $this->page = $page;
        } elseif ($data){
              $this->page = $data;     //в page приходит вся страница со всеми подключенными контроллерами
        }
        
        if ($this->errors){
            $this->writeLog($this->errors);
        }
        $this->getPage();
    }

    protected function render($path = '', $parameters = []){

        extract($parameters);

        if(!$path){

            $class = new \ReflectionClass($this); // для полученяи прсстранства имен из файла Settings

            $space = str_replace('\\','/',$class->getNamespaceName() . '\\'); //метод возвращает пространство имен класса
            $routes = Settings::get('routes');

            if($space === $routes['user']['path']) $template = TEMPLATE;
                else $template = ADMIN_TEMPLATE;

            $path = $template . $this->getController();
        }

        ob_start();//открывает буфер обмена

        if(!@include_once $path . '.php') throw new RouteException('Отсутствует шаблон - ' .$path);

        return ob_get_clean(); //вернет в $template то, что находится в буфере обмена, потом закроет буфер
    }

    protected function getPage(){

        if(is_array($this->page)) {
            foreach ($this->page as  $block) echo $block;
        }else {
            echo $this->page;
        }
        exit();
    }


    protected function init($admin = false){ //инициализир стили и скрипты из файла internal settings в кач-ве констант

        if(!$admin){
            if(USER_CSS_JS['styles']){
                foreach (USER_CSS_JS['styles'] as $item)
                    $this->styles[] = (!preg_match('/^\s*https?:\/\//i', $item) ?  PATH . TEMPLATE : '') . trim($item, '/'); //если символы в директории стилей будет с /, то его обрежут и в начале и в конце строки
            }
            if(USER_CSS_JS['scripts']){
                foreach (USER_CSS_JS['scripts'] as $item)
                    $this->scripts[] = (!preg_match('/^\s*https?:\/\//i', $item) ?  PATH . TEMPLATE : '') . trim($item, '/'); //если символы в директории стилей будет с /, то его обрежут и в начале и в конце строки
            }
        }else{
            if(ADMIN_CSS_JS['styles']){
                foreach (ADMIN_CSS_JS['styles'] as $item)
                    $this->styles[] = (!preg_match('/^\s*https?:\/\//i', $item) ?  PATH . ADMIN_TEMPLATE : '') . trim($item, '/');//если символы в директории стилей будет с /, то его обрежут и в начале и в конце строки
            }
            if(ADMIN_CSS_JS['scripts']){
                foreach (ADMIN_CSS_JS['scripts'] as $item)
                    $this->scripts[] = (!preg_match('/^\s*https?:\/\//i', $item) ?  PATH . ADMIN_TEMPLATE : '') . trim($item, '/'); //если символы в директории стилей будет с /, то его обрежут и в начале и в конце строки
            }
        }

    }

    protected function checkAuth($type = false){

        if(!($this->userID = UserModel::instance()->checkUser(false, $type))){

            $type && $this->redirect(PATH);

        }

        if(property_exists($this, 'userModel'))
            $this->userModel = UserModel::instance();

    }

}