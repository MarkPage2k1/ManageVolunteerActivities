<?php
    require_once "./mvc/core/redirect.php";
    require_once "./mvc/controllers/MyController.php";
    class home extends controller 
    {
        // loader model
        public $ModuleModels;
        public $MyController;
        // loader helper
        public $JWTOKEN;
        public $Authorization;

        // Data user login 
        public $data_user;
        // ==============
        var $template   = 'home';
        var $title      = 'Module';
        public $session = 'session';
        const type      = 1;

        public function __construct() {
            $this->ModuleModels = $this->model('ModuleModels');
            $this->MyController = new MyController();
            $this->JWTOKEN      = $this->helper('JWTOKEN');
            $this->Authorization      = $this->helper('Authorization');

            // Hien thi thong tin user
            if (isset($_SESSION['user'])) {
                $verify = $this->JWTOKEN->decodeToken($_SESSION['user'], KEYS);        
                if ($verify != null && $verify != 0) {
                    $auth = $this->Authorization->checkAuthUser($verify);
                    if ($auth == true) {
                        $this->data_user = $verify;
                    } else {
                        $this->data_user = null;
                        unset($_SESSION['user']);
                    }
                } else {
                    $this->data_user = null;    
                    unset($_SESSION['user']);
                }
            } else {
                $this->data_user = null;
                unset($_SESSION['user']);
            }    
        }

        public function index1 () {
            if ($_SESSION['admin']) {
                $verify = $this->JWTOKEN->decodeToken($_SESSION['admin'], KEYS);             
                if ($verify != null && $verify != 0) {
                    $auth = $this->Authorization->checkAuth($verify);
                    if ($auth != true) {
                        $redirect = new redirect('auth/index');
                    }
                } else {
                    $redirect = new redirect('auth/index');
                }
            } else {
                $urlBack = $_GET['url'];
                $_SESSION['urlBack'] = $urlBack;
                $redirect = new redirect('auth/index');
            }

            $data_admin = $this->MyController->getIndexAdmin();
            $data_array = $this->ModuleModels->select_array('*', ['parentID' => 0]);
            foreach ($data_array as $key => $val) {
                $children = $this->ModuleModels->select_array('*', ['parentID' => $val['id']]);
                $data_array[$key]['children'] = $children;
            }
            $data = [
                'data_admin'      => $data_admin,
                'page'            => $this->template.'/index',
                'title'           => 'Danh sách '.$this->title,
                'template'        => $this->template,
                'data_array'      => $data_array,
            ];
            $this->viewAdmin('masterlayout', $data);

        }    

        public function index () {

            $data = [
                'page'            => $this->template.'/index',
                'title'           => 'Danh sách '.$this->title,
                'template'        => $this->template,
            ];
            $this->viewUser('masterlayout', $data, $this->data_user);

        } 
    }
?>