<?php


namespace core\user\controller;


class IndexTestController extends BaseUser
{

    protected function inputData()
    {
        parent::inputData(); // TODO: Change the autogenerated stub

        echo $this->getController();
        exit();
    }

}