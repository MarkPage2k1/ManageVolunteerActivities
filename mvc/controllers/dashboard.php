<?php 
    require_once "./mvc/core/redirect.php";
    require_once "./mvc/controllers/MyController.php";
    class dashboard extends controller {
        public $AccountModels;
        public $MyController;
        // loader helper
        public $JWTOKEN;
        public $Authorization;
        var $template = 'dashboard';
        function __construct() {
            $this->AccountModels = $this->model('AccountModels');
            $this->MyController = new MyController();
            // Load helper
            $this->JWTOKEN      = $this->helper('JWTOKEN');
            $this->Authorization     = $this->helper('Authorization');
        }

        function index() {
            if ($_SESSION['admin']) {
                $verify = $this->JWTOKEN->decodeToken($_SESSION['admin'], KEYS);        
                // print_r($verify) ;
                // if ($verify != null && $verify != 0) {
                //     $auth = $this->Authorization->checkAuth($verify);
                //     if ($auth != true) {
                //         $redirect = new redirect('auth/index');
                //     }
                // } else {
                //     $redirect = new redirect('auth/index');
                // }
            } else {
                $redirect = new redirect('auth/index');
            }
            $data_admin = $this->MyController->getIndexAdmin();
            $data = [
                'data_admin'      => $data_admin,
                'page'            => $this->template.'/index',
                'template'        => $this->template,
            ];
            $this->viewAdmin('masterlayout', $data);
        }
    }
?>