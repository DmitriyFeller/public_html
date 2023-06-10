<?php


namespace core\admin\controller;


use core\base\controller\BaseController;
use core\admin\model\Model;
use core\base\settings\Settings;

class IndexController extends BaseController
{
    //вся административная панель CRUD (create read update delete)
    //создаем методы, чтобы они формировали запросы в автоматическом виде
    protected function inputData()
    {

        $redirect = PATH . Settings::get('routes')['admin']['alias'] . '/show';
        $this->redirect($redirect);
    }

}