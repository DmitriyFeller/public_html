<?php


namespace core\base\controller;


trait Singleton
{

    static private $_instance;

    private function __construct(){
    }

    private function __clone(){

    }

    static public function instance(){
        if (self::$_instance instanceof self){
            return self::$_instance;
        }
        self::$_instance = new self;
        if(method_exists(self::instance(),'connect')) {
            self::$_instance->connect();
        }
        return self::$_instance;
    }

}
