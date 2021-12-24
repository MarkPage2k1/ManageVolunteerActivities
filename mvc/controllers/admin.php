<?php
    require_once "./mvc/core/redirect.php";
    require_once "./mvc/controllers/MyController.php";
    class admin extends controller 
    {
        public $AccountModels;
        public $MyController;
        public $ActivityModels;

        // loader helper
        public $JWTOKEN;
        public $Authorization;
        // Data user login 
        public $data_admin;
        public $data_menu;

        const ACTION = 'index';
        const CONTROLLER = 'auth';

        var $template   = 'admin';

        public function __construct() {
            $this->AccountModels = $this->model('AccountModels');
            $this->ActivityModels = $this->model('ActivityModels');
            $this->MyController = new MyController();

            // Loader helper
            $this->JWTOKEN      = $this->helper('JWTOKEN');
            $this->Authorization     = $this->helper('Authorization');

            // Hien thi thong tin admin
            if (isset($_SESSION['admin'])) {
                $verify = $this->JWTOKEN->decodeToken($_SESSION['admin'], KEYS);        
                if ($verify != null && $verify != 0) {
                    $auth = $this->Authorization->checkAuthAdmin($verify);
                    if ($auth == true) {
                        $this->data_admin = $verify;
                        $this->data_menu = $this->MyController->getIndexAdmin();
                    } else {
                        $this->data_admin = null;
                        unset($_SESSION['admin']);
                    }
                } else {
                    $this->data_admin = null;  
                    unset($_SESSION['admin']); 
                }
            } else {
                $this->data_admin = null;
                unset($_SESSION['admin']);
            }   

            if (!isset($_SESSION['admin'])) {
                $redirect = new redirect(self::CONTROLLER.'/'.self::ACTION);        
            }
                     
        }

        public function index () {
            $data = [
                'data_menu'      => $this->data_menu,
                'page'            => $this->template.'/index',
                'template'        => $this->template,
            ];
            $this->viewAdmin('masterlayout', $data);            
        }


        public function activity(){
            // function
            $data_array = $this->ActivityModels->select_array('*', ['status' => 'waiting']);
            $data = [
                'data_menu'      => $this->data_menu,
                'page'            => $this->template.'/activity',
                'title'           => 'Danh sách hoạt động cần phê duyệt',
                'template'        => $this->template,
                'data_array'      => $data_array,
            ];
            $this->viewAdmin('masterlayout', $data);
        }

        public function acceptActivity(){
            $id = $_POST['id'];
            $result = $this->ActivityModels->update(['status' => 'accept'], ['id' => $id]);
            $return = json_decode($result, true);
            if ($return['type'] == "successfully") {
                echo json_encode(
                    [
                        'result'  => 'true',
                        'message' => $return['message']
                    ]
                );
            } 
        }

        public function refuseActivity(){
            $id = $_POST['id'];
            $result = $this->ActivityModels->update(['status' => 'refuse'], ['id' => $id]);
            $return = json_decode($result, true);
            if ($return['type'] == "successfully") {
                echo json_encode(
                    [
                        'result'  => 'true',
                        'message' => $return['message']
                    ]
                );
            } 
        }


        public function add () {
            $data_admin = $this->MyController->getIndexAdmin();
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $data_post = $_POST['data_post'];
                $data_post['role'] ? $role = 1 : $role = 0;
                $data_post['role'] = $role;
                $password = password_hash($data_post['password'], PASSWORD_BCRYPT);
                $data_post['password'] = $password;
                $data_post['publish'] ? $publish = 1 : $publish = 0;
                $data_post['publish'] = $publish;
  
                $result = $this->AdminModels->add($data_post);
                $return = json_decode($result, true);
                if ($return['type'] == "successfully") {
                    $redirect = new redirect($this->template.'/index');
                    $redirect->setFlash('flash', 'Them thanh cong');
                }
            } else {
                $data = [
                    'data_admin'      => $data_admin,
                    'page'      => $this->template.'/add',
                    'title'     => 'Thêm mới '.$this->title,
                    'template'  => $this->template,
                ];
                $this->viewAdmin('masterlayout', $data);
            }
        }

        public function edit($id) {
            $data_admin = $this->MyController->getIndexAdmin();
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $data_post = $_POST['data_post'];
                $data_post['publish'] ? $publish = 1 : $publish = 0;
                $data_post['publish'] = $publish;
                $data_post['role'] ? $role = 1 : $role = 0;
                $data_post['role'] = $role;

                $result = $this->AdminModels->update($data_post, ['id' => $id]);
                $return = json_decode($result, true);
                if ($return['type'] == "successfully") {
                    $redirect = new redirect($this->template.'/index');
                    $redirect->setFlash('flash', 'Cap nhat hoat dong thanh cong');
                }
                
            } else {
                $datas = $this->AdminModels->select_row('*', ['id' => $id]);
                $data = [
                    'data_admin'      => $data_admin,
                    'page'      => $this->template.'/edit',
                    'title'     => 'Cập nhật '.$this->title,
                    'template'  => $this->template,
                    'datas'     => $datas,
                ];
                $this->viewAdmin('masterlayout', $data);
            }   
            
        }

        public function delete() {
            $id = $_POST['id'];
            $result = $this->AdminModels->delete(['id' => $id]);
            $return = json_decode($result, true);
            if ($return['type'] == "successfully") {
                echo json_encode(
                    [
                        'result'  => 'true',
                        'message' => $return['message']
                    ]
                );
            } 
        }

        public function delAll() {
            $listID = $_POST['listID'];
            $arrayID = explode(',', $listID);
            foreach ($arrayID as $key => $val) {
                $this->AdminModels->delete(['id' => $val]);
            }
            echo json_encode(
                [
                    'result'  => 'success',
                    'message' => 'Delete successfully!'
                ]
            );
        }

        function checkPublish() {
            $id = $_POST['id'];
            $value = $_POST['value'];
            $fields = $_POST['fields'];
            $dataUpdate[$fields] = $value;
            $result = $this->AdminModels->update($dataUpdate, ['id' => $id]);
            $return = json_decode($result, true);
            if ($return['type'] == "successfully") {
                echo json_encode(
                    [
                        'type'  => 'successfully',
                        'message' => 'Update data success'
                    ]
                );
            } 
        }
    }
?>