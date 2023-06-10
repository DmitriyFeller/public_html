<?php

namespace core\user\controller;
use core\admin\model\Model;
use core\base\controller\BaseController;
use core\base\settings\Settings;
use http\QueryString;
class IndexController  extends BaseUser { //шаблон подключается объектом класса IndexController

    protected $name;

    protected function inputData(){

       parent::inputData();

      $sales = $this->model->get('sales',[
           'where' => ['visible' => 1],
           'order' => ['menu_position']
       ]);

       $goods = $this->model->getGoods();

       return compact('sales');
    }
}