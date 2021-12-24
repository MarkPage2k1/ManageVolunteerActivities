<?php
    require_once "./mvc/core/redirect.php";
    require_once "./mvc/controllers/MyController.php";
    class user extends controller 
    {
        // loader model
        public $ModuleModels;
        public $MyController;
        // loader helper
        public $JWTOKEN;
        public $Authorization;
        // ==============
        var $template   = 'user';
        var $title      = 'Module';
        public $session = 'session';
        const type      = 1;

        public function __construct() {
            $this->ModuleModels = $this->model('ModuleModels');
            $this->MyController = new MyController();
            $this->JWTOKEN      = $this->helper('JWTOKEN');
            $this->Authorization      = $this->helper('Authorization');
        }

        public function index () {

            $data = [
                'page'            => $this->template.'/index',
                'title'           => 'Danh sách '.$this->title,
                'template'        => $this->template,
            ];
            $this->viewUser('masterlayout', $data);

        }    
    }
?>