<?php 
    require_once "./mvc/core/redirect.php";
    require_once "./mvc/controllers/MyController.php";
    class auth extends controller {
        // loader Model
        public $AccountModels;
        // loader Controller
        public $MyController;
        // loader helper
        public $JWTOKEN;
        public $Authorization;

        const ADMIN = 'admin';
        const ACTION = 'index';
        const CONTROLLER = 'auth';

        function __construct() {
            $this->AccountModels  = $this->model('AccountModels');
            $this->MyController = new MyController();
            $this->JWTOKEN      = $this->helper('JWTOKEN');
            $this->Authorization      = $this->helper('Authorization');
        }

        function index() {
            // Middelware
            if (isset($_SESSION['admin'])) {
                $verify = $this->JWTOKEN->decodeToken($_SESSION['admin'], KEYS);             
                if ($verify != null && $verify != 0) {
                    $auth = $this->Authorization->checkAuthAdmin($verify);
                    if ($auth == true) {
                        $redirect = new redirect(self::ADMIN.'/'.self::ACTION);
                    }
                }
            }
            $datas = [];
            if (isset($_COOKIE['remember'])) {
                $datas = json_decode($_COOKIE['remember'], true);
            }
            $data = [
                'datas'      => $datas
            ];
            $this->viewAdmin('login', $data);

        }

        function login() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $username = $_POST['username'];
                $password = $_POST['password'];

                //Kiem tra user co ton tai
                $checkUni = $this->AccountModels->select_row('*', ['username' => $username, 'role' => 1, 'publish' => 1]);
                if (isset($checkUni) && $checkUni != null) {
                    if (password_verify($password, $checkUni['password'])) {
                        if (isset($_POST['remember']) ) {
                            $array_remember  = [
                                'username'      => $username,
                                'password'      => $password,
                                'remember'      =>  1
                            ];
                            $json_remember = json_encode($array_remember);
                            setcookie('remember', $json_remember, time() + 86400, "/");
                        }
                        $array = [
                            'time'      => time() + 3600*24,
                            'keys'      => KEYS,
                            'info'      => [
                            'id'        => $checkUni['id'],
                            'username'  => $checkUni['username'],
                            ]
                        ];
                        $jwtoken = $this->JWTOKEN->CreateToken($array);
                        $_SESSION['admin'] = $jwtoken;
                        if (isset($_SESSION['urlBack']) && $_SESSION['urlBack'] != null) {
                            $redirect = new redirect($_SESSION['urlBack']);
                            unset($_SESSION['urlBack']);
                        } else {
                            $redirect = new redirect(self::ADMIN.'/'.self::ACTION);
                        }
                    } else {
                        $redirect = new redirect(self::CONTROLLER.'/'.self::ACTION);
                        $redirect->setFlash('error', 'Ten dang nhap hoac mat khau khong chinh xac!');
                    }
                } else {
                    $redirect = new redirect(self::CONTROLLER.'/'.self::ACTION);
                    $redirect->setFlash('error', 'Tai khoan khong ton tai hoac da bi khoa!');
                }
            }
        }

        function logout() {
            if (isset($_SESSION['admin'])) {
                unset($_SESSION['admin']);
                $redirect = new redirect(self::CONTROLLER.'/'.self::ACTION);
            } 
        }
    }
?>