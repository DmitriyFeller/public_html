<?php


namespace core\admin\controller;

use core\base\settings\Settings;
use core\base\settings\ShopSettings;

class SearchController extends BaseAdmin
{

    protected function inputData(){

        if(!$this->userID) $this->execBase();

        $text =$this->clearStr($_GET['search']);

        $table = $_GET['search_table'];

        $this->data = $this->model->search($text, $table);

        $this->template = ADMIN_TEMPLATE . 'show';

        return $this->expansion();
    }

}