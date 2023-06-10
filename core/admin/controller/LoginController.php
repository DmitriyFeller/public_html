<?php

namespace core\admin\controller;

use core\base\model\UserModel;
use core\base\settings\Settings;

class LoginController extends \core\base\controller\BaseController
{

    protected $model;

    protected function inputData(){

        $this->model = UserModel::instance();

        $this->model->setAdmin();

        if(isset($this->parameters['logout'])){

            $this->checkAuth(true);

            $userLog = 'Выход пользователя ' . $this->userID['name'];

            $this->writeLog($userLog, 'user_log.txt', 'Access user');

            $this->model->logout();

            $this->redirect(PATH);

        }

        if($this->isPost()){

            if(empty($_POST['token']) || $_POST['token'] !== $_SESSION['token']){

                exit('Куку охибка');

            }

            //$timeClean = (new \DateTime())->modify('-' . BLOCK_TIME . ' hour')->format('Y-m-d H:i:s');
            $timeClean = (new \DateTime())->modify('-1' . ' seconds')->format('Y-m-d H:i:s');

            $this->model->delete($this->model->getBlockedTable(), [
                'where' => ['time' => $timeClean],
                'operand' => ['<']
            ]);

            $ipUser = filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP) ?:
                (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP) ?:
                    @$_SERVER['REMOTE_ADDR']);

            $trying = $this->model->get($this->model->getBlockedTable(),[
                'fields' => ['trying'],
                'where' => ['ip' => $ipUser]
            ]);

            $trying = !empty($trying) ? $this->clearNum($trying[0]['trying']) : 0;

            $success = 0;

            if(!empty($_POST['login']) && !empty($_POST['password']) && $trying < 3){

                $login = $this->clearStr($_POST['login']);

                $password = md5($this->clearStr($_POST['password']));

                $userData = $this->model->get($this->model->getAdminTable(),[
                    'fields' => ['id', 'name'],
                    'where' => ['login' => $login, 'password' => $password]
                ]);

                if(!$userData){

                    $method = 'add';

                    $where = [];

                    if($trying){

                        $method = 'edit';

                        $where['ip'] = $ipUser;

                    }

                    $this->model->$method($this->model->getBlockedTable(),[
                        'fields' => ['login' => $login, 'ip' => $ipUser, 'time' => 'NOW()', 'trying' => ++$trying],
                        'where' => $where
                    ]);

                    $error = 'Неверные имя пользователя или пароль - ' . $ipUser. ', логин - ' . $login;

                }else{

                    if(!$this->model->checkUser($userData[0]['id'])){

                        $error = $this->model->getLastError();

                    }else{

                        $error = 'Вход пользователя - ' . $login;

                        $success = 1;

                    }

                }

            }elseif($trying >=3){

                $this->model->logout();

                $error = 'Превышено максимальное количество попыток ввода пароля - ' . $ipUser;

            }else{

                $error = 'Заполните обязательные поля';

            }

            $_SESSION['res']['answer'] = $success ? '<div class="success">Добро пожаловать ' . $userData[0]['name'] . '</div>' :
                preg_split('/\s*\-/', $error, 2, PREG_SPLIT_NO_EMPTY)[0];

            $this->writeLog($error, 'user_log.txt', 'Access user');

            $path = null;

            $success && $path = PATH . Settings::get('routes')['admin']['alias'];

            $this->redirect($path);

        }

        return $this->render('',['adminPath' => Settings::get('routes')['admin']['alias']]);

    }

}