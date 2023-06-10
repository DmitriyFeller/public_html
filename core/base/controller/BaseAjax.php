<?php


namespace core\base\controller;


use core\base\settings\Settings;

class BaseAjax extends BaseController
{

    public function route(){

        $route = Settings::get('routes');

        $controller = $route['user']['path'] . 'AjaxController';

        $data = $this->isPost() ? $_POST : $_GET;

        if(!empty($data['ajax']) && $data['ajax'] === 'token'){

            return $this->generateToken();

        }

        $httpRefer = str_replace('/','\/', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . PATH . $route['admin']['alias']);

        if(isset($data['ADMIN_MODE']) || preg_match('/^' . $httpRefer . '(\/?|$)/', $_SERVER['HTTP_REFERER'])){

            unset($data['ADMIN_MODE']);

            $controller = $route['admin']['path'] . 'AjaxController';

        }
        $controller = str_replace('/', '\\', $controller);

        $ajax = new $controller;

        $ajax->ajaxData = $data;

        $res = $ajax->ajax();

        if(is_array($res) || is_object($res)) $res = json_encode($res);
        elseif (is_int($res)) $res = (float) $res;

        return $res;

    }

    protected function generateToken(){

        return $_SESSION['token'] = md5(mt_rand(0, 999999) . microtime());

    }

}