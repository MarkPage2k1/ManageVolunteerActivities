<?php 
    require_once "./mvc/core/redirect.php";
    require_once "./mvc/controllers/MyController.php";
    class account extends controller {
        // loader Model
        public $AccountModels;
        // loader User
        public $UserModels;
        // loader Controller
        public $MyController;
        // loader helper
        public $JWTOKEN;
        public $Authorization;

        const HOME = 'home';
        const ACTION = 'index';
        const CONTROLLER = 'account';

        function __construct() {
            $this->AccountModels  = $this->model('AccountModels');
            $this->UserModels = $this->model('UserModels');
            $this->MyController = new MyController();
            $this->JWTOKEN      = $this->helper('JWTOKEN');
            $this->Authorization      = $this->helper('Authorization');
        }

        function index() {
            // // Middelware
            if (isset($_SESSION['user'])) {
                $verify = $this->JWTOKEN->decodeToken($_SESSION['user'], KEYS);             
                if ($verify != null && $verify != 0) {
                    $auth = $this->Authorization->checkAuthUser($verify);
                    if ($auth == true) {
                        $redirect = new redirect(self::HOME.'/'.self::ACTION);
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
            $this->viewUser('login', $data);

        }

        function login() {
            if (isset($_POST['btn_login'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                echo $username;
                echo '<pre>'.$password;
                //Kiem tra user co ton tai
                $checkUni = $this->AccountModels->select_row('*', ['username' => $username, 'role' => 0, 'publish' => 1]);
                if (isset($checkUni) && $checkUni != null) {
                    if (password_verify($password, $checkUni['password'])) {
                        echo 'Chao mung '.$username;
                //         if (isset($_POST['remember']) ) {
                //             $array_remember  = [
                //                 'username'      => $username,
                //                 'password'      => $password,
                //                 'remember'      =>  1
                //             ];
                //             $json_remember = json_encode($array_remember);
                //             setcookie('remember', $json_remember, time() + 86400, "/");
                //         }
                        $array = [
                            'time'      => time() + 3600*24,
                            'keys'      => KEYS,
                            'info'      => [
                            'id'        => $checkUni['id'],
                            'username'  => $checkUni['username'],
                            ]
                        ];
                        $jwtoken = $this->JWTOKEN->CreateToken($array);
                        $_SESSION['user'] = $jwtoken;
                        if (isset($_SESSION['urlBack']) && $_SESSION['urlBack'] != null) {
                            $redirect = new redirect($_SESSION['urlBack']);
                            unset($_SESSION['urlBack']);
                        } else {
                            $redirect = new redirect(self::HOME.'/'.self::ACTION);
                        }
                    } else {
                        $redirect = new redirect(self::CONTROLLER);
                        $redirect->setFlash('error', 'Tên đăng nhập hoặc mật khẩu không đúng!');
                    }
                } else {
                    $redirect = new redirect(self::CONTROLLER);
                    $redirect->setFlash('error', 'Tài khoản không tồn tại!');
                }
            }
        }

        function logout() {
            if (isset($_SESSION['user'])) {
                unset($_SESSION['user']);
                $redirect = new redirect(self::HOME.'/'.self::ACTION);
            } 
        }

        function register() {
            if (isset($_POST['btn_register'])) {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                $data_account=[];
                $data_account['username'] = $username;
                $data_account['password'] = password_hash($password, PASSWORD_BCRYPT);
                $data_account['role'] = 0;
                $data_account['publish'] = 1;

                $result = $this->AccountModels->add($data_account);
                $return = json_decode($result, true);
                if ($return['type'] == "successfully") {
                    // $redirect = new redirect($this->template.'/index');
                    // $redirect->setFlash('flash', 'Them thanh cong');
                    echo 'Tao thanh cong!';
                    $data_user = [];
                    $data_user['username'] = $username;
                    $data_user['name'] = $name;
                    $data_user['email'] = $email;
                    $kq = $this->UserModels->add($data_user);
                    $check = json_decode($kq, true);
                    if ($check['type'] == "successfully") {
                        $redirect = new redirect(self::HOME.'/'.self::ACTION);
                    } else {
                        echo "Them khong duoc";
                    }
                } else {
                    echo 'Tao that bai!';
                }

            }
        }
    }
?>