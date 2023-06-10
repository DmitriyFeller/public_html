<?php


namespace core\base\controller;

use core\base\exceptions\RouteException;
use core\base\settings\Settings;

class RouteController extends BaseController
{

    use Singleton;

    protected $routes;


    private function __construct(){
        $address_str = $_SERVER['REQUEST_URI'];

        if($_SERVER['QUERY_STRING']){
            $address_str = substr($address_str, 0, strpos($address_str, $_SERVER['QUERY_STRING']) - 1);
        }

        $path = substr($_SERVER['PHP_SELF'],0, strpos($_SERVER['PHP_SELF'],'index.php'));

        if ($path === PATH){

            if(strrpos($address_str, '/') === strlen($address_str) - 1 &&
                strrpos($address_str,'/') !== strlen(PATH) - 1){
                $this->redirect(rtrim($address_str,'/'),301);
            }

            $this->routes = Settings::get('routes');

            if (!$this->routes) throw new RouteException('Отсутствуют маршруты в базовых настройках', 1);

            $url = explode('/',substr($address_str,strlen(PATH)));

            if($url[0] && $url[0] === $this->routes ['admin'] ['alias']){
                //if (strpos($address_str, $this->routes['admin'] ['alias']) === strlen(PATH)){
                //$url = explode('/', substr($address_str,strlen(PATH . $this->routes['admin']['alias']) +1 ));
                array_shift($url);
                if($url[0] && is_dir($_SERVER['DOCUMENT_ROOT'] . PATH . $this->routes['plugins']['path'] . $url[0])){

                    $plugin = array_shift($url);

                    $pluginSettings = $this->routes['settings']['path'] . ucfirst($plugin . 'Settings');

                    if(file_exists($_SERVER['DOCUMENT_ROOT'] . PATH . $pluginSettings . '.php')){
                        $pluginSettings = str_replace('/','\\',$pluginSettings);
                        $this->routes = $pluginSettings::get('routes');
                    }
                    $dir = $this->routes['plugins'] ['dir'] ? '/' . $this->routes['plugins'] ['dir'] . '/' : '/';
                    $dir = str_replace('//','/', $dir);

                    $this->controller = $this->routes['plugins'] ['path'] . '/' .$plugin . $dir;

                    $hrUrl = $this->routes['plugins'] ['hrUrl'];

                    $route = 'plugins';

                }else{
                    $this->controller = $this->routes['admin']['path'];

                    $hrUrl = $this->routes['admin'] ['hrUrl'];

                    $route = 'admin';
                }
            }else{
                $url = explode('/',substr($address_str, strlen(PATH)));

                $hrUrl = $this->routes['user']['hrUrl'];

                $this->controller = $this->routes['user']['path'];

                $route = 'user';
            }

            $this->createRoute($route, $url);

            if($url[1]){
                $count = count($url);
                $key = '';

                if(!$hrUrl){
                    $i = 1;
                }else{
                    $this->parameters['alias'] = $url[1];
                    $i = 2;
                }

                for( ;$i < $count; $i++){
                    if(!$key){
                        $key = $url[$i];
                        $this->parameters[$key] = '';
                    }else{
                        $this->parameters[$key] = $url[$i];
                        $key = '';
                    }
                }
            }


        }else {
            throw new  RouteException('Не корректная дирректория сайта',1);
        }
    }

    private function createRoute($var,$arr){
        $route = [];

        if(!empty($arr[0])){
            if($this->routes[$var]['routes'][$arr[0]]){
                $route = explode('/',$this->routes[$var]['routes'][$arr[0]]);

                $this->controller .= ucfirst($route[0] . 'Controller');
            }else{
                $this->controller .= ucfirst($arr[0] . 'Controller');
            }
        }else{
            $this->controller .= $this->routes['default']['controller'];
        }

        $this->inputMethod = $route[1] ? $route[1] : $this->routes['default']['inputMethod'];
        $this->outputMethod = $route[2] ? $route[2] : $this->routes['default']['outputMethod'];


    }

}