<?php
    require_once "./mvc/core/redirect.php";
    require_once "./mvc/controllers/MyController.php";
    class activity extends controller 
    {
        // loader model
        public $ActivityModels;
        public $ParticipantModels;
        public $TaskModels;
        public $RateModels;
        public $MyController;
        // loader helper
        public $JWTOKEN;
        public $Authorization;

        // Data user login 
        public $data_user;
        // ==============
        var $template = 'activity';
        var $title = 'hoạt động thiện nguyện';

        public function __construct() {
            $this->ActivityModels = $this->model('ActivityModels');
            $this->ParticipantModels = $this->model('ParticipantModels');
            $this->TaskModels = $this->model('TaskModels');
            $this->RateModels = $this->model('RateModels');
            $this->MyController = new MyController();
            // Loader helper
            $this->JWTOKEN      = $this->helper('JWTOKEN');
            $this->Authorization     = $this->helper('Authorization');

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

        // User
        public function index () {
            $_SESSION['urlBack'] = $_GET['url'];
            unset($_SESSION['urlBack']);
            // Middelware
            // if ($_SESSION['admin']) {
            //     $verify = $this->JWTOKEN->decodeToken($_SESSION['admin'], KEYS);             
            //     if ($verify != null && $verify != 0) {
            //         $auth = $this->Authorization->checkAuth($verify);
            //         if ($auth != true) {
            //             $redirect = new redirect('auth/index');
            //         }
            //     } else {
            //         $redirect = new redirect('auth/index');
            //     }
            // } else {
            //     $urlBack = $_GET['url'];
            //     $_SESSION['urlBack'] = $urlBack;
            //     $redirect = new redirect('auth/index');
            // }

            // function
            // $data_admin = $this->MyController->getIndexAdmin();
            $data_array = $this->ActivityModels->select_array_where_not_status('*', ['refuse', 'waiting']);
            $lenData = count($data_array);
            for ($i = 0; $i < $lenData; $i++) {
                $data_array[$i]['time_remaining'] = $this->getTimeRemaining($data_array[$i]['close_reg_date']);
            }
            // $data_array['time_remaining'] = $this->getTimeRemaining($data_array['close_reg_date']);
            $data = [
                // 'data_admin'      => $data_admin,
                'page'            => $this->template.'/index',
                'title'           => 'Danh sách '.$this->title,
                'template'        => $this->template,
                'data_array'      => $data_array,
            ];
            $this->viewUser('masterlayout', $data, $this->data_user);
        }

        public function detail ($id) {  
            $member_status = 'join';
            // Check Login hay chua?       
            if ($this->data_user != null) {
                $username = $this->data_user['username']; 
                $isUserRated = $this->RateModels->select_row('*', ['activity_id' => $id, 'user_ratings' => $username]);             
                // Kiem tra xem user co phai la chu cua hoat dong nay hay khong?
                $resultCheck = $this->ActivityModels->select_row('owner', ['id' => $id]);
                if ($username == $resultCheck['owner']) {
                    $member_status = 'auth';
                } else {
                    // Kiem tra da tham gia hoat dong nay hay chua?
                    $resultCheck = $this->ParticipantModels->select_row('username', ['activity_id' => $id, 'username' => $username]);
                    if  (isset($resultCheck['username'])) {
                        if ($username == $resultCheck['username']) {
                            $member_status = 'joined';
                        }
                    }
                }
            }
            $data_array = $this->ActivityModels->select_row_where_not('*', ['status' => 'refuse', 'id' => $id]);
            $data_array['time_remaining'] = $this->getTimeRemaining($data_array['close_reg_date']);
            $data_array['remaining_amount'] = $this->getRemainingAmount($data_array['min_reg'], $data_array['max_reg'], $data_array['id']);

            // Kiem tra con thoi gian dang ky hay khong
            $today = date("Y-m-d");
            if (strtotime($today) > strtotime($data_array['close_reg_date'])) {
                $data_array['isExpired'] = true;
            } else {
                $data_array['isExpired'] = false;
            }



            if (isset($isUserRated) && $isUserRated != null) {
                $data_array['user_rated'] = true;
            } else {
                $data_array['user_rated'] = false;
            }
            // print_r($data_array);
            $data_task = $this->TaskModels->select_array('*', ['activity_id' => $id]);
            $data = [
                'page'            => $this->template.'/detail',
                'title'           => 'Danh sách '.$this->title,
                'template'        => $this->template,
                'member_status'   => $member_status,
                'data_array'      => $data_array,
                'data_task'       => $data_task
            ];
            $this->viewUser('masterlayout', $data, $this->data_user);
        }

        public function create(){
            if (isset($_SESSION['user'])) {
                if (isset($_POST['submit'])){
                    $data_post = $_POST['data_post'];
                    $data_post['status'] = 'waiting';
                    $data_post['post_date'] = date('Y-m-d');
                    $data_post['owner'] = $this->data_user['username'];
                    $result = $this->ActivityModels->add($data_post);
                    $return = json_decode($result, true);
                    if ($return['type'] == "successfully") {
                        $redirect = new redirect($this->template.'/index');
                        $redirect->setFlash('flash', 'Them hoat dong thanh cong');
                    }
                } else {
                    $data = [
                        'page'      => $this->template.'/create',
                        'title'     => 'Thêm mới '.$this->title,
                        'template'  => $this->template,
                    ];
                    $this->viewUser('masterlayout', $data, $this->data_user);
                }
            } else {
                $redirect = new redirect('account');
            }

        }

        public function update($idActivity){
            if (isset($_SESSION['user'])) {
                if (isset($_POST['submit'])){
                    $data_post = $_POST['data_post'];
                    $data_post['owner'] = $this->data_user['username'];
                    $result = $this->ActivityModels->update($data_post, ['id' => $idActivity]);
                    $return = json_decode($result, true);
                    if ($return['type'] == "successfully") {
                        $redirect = new redirect($this->template.'/detail'.'/'.$idActivity);
                        $redirect->setFlash('flash', 'Cap nhat hoat dong thanh cong');
                    }     
                } else {
                    $datas = $this->ActivityModels->select_row('*', ['id' => $idActivity]);
                    $data = [
                        // 'data_admin'      => $data_admin,
                        'page'      => $this->template.'/update',
                        'title'     => 'Cập nhật '.$this->title,
                        'template'  => $this->template,
                        'datas'     => $datas
                    ];
                    $this->viewUser('masterlayout', $data, $this->data_user);
                }
            } else {
                $redirect = new redirect('error404');
            }

        }

        public function join($idActivity) {
            if ($this->data_user != null) {
                $username = $this->data_user['username'];
                // Check Login hay chua?
                // Kiem tra xem user co phai la chu cua hoat dong nay hay khong?
                $resultCheck = $this->ActivityModels->select_row('owner', ['id' => $idActivity]);
                if ($username == $resultCheck['owner']) {
                    // $this->detail($idActivity);
                    $member_status = 'auth';
                } else {
                    // echo "Khong phai chu post";
                    // Kiem tra da tham gia hoat dong nay hay chua?
                    $resultCheck = $this->ParticipantModels->select_row('username', ['activity_id' => $idActivity, 'username' => $username]);
                    if  (isset($resultCheck['username'])) {
                        if ($username == $resultCheck['username']) {
                            //echo "<pre>Da tham gia";
                            // $this->detail($idActivity);
                            $member_status = 'joined';
                        }
                    } else {
                        //echo "Chua tham gia";
                        $data_post['activity_id'] = $idActivity;
                        $data_post['username'] = $username;
                        $data_post['join_date'] = date('Y-m-d');
                        $data_post['is_volunteer'] = 1;
                        $data_post['is_sponsor'] = 1;
                        $result = $this->ParticipantModels->add($data_post);
                        $return = json_decode($result, true);
                        if ($return['type'] == "successfully") {
                            //echo "Ok!";
                            // $this->detail($idActivity);
                            $member_status = 'joined';
                        } else {
                            // echo "Error!";
                            $member_status = 'join';
                        }
                    }  
                }

                $redirect = new redirect('./activity/detail/'.$idActivity);
            } else {
                $_SESSION['urlBack'] = $_GET['url'];
                $redirect = new redirect('account');
            }

        }

        public function add_task($idActivity) {
            if (isset($_POST['submit'])){
                $data_post = $_POST['data_post'];
                $data_post['create_date'] = date('Y-m-d');
                $data_post['status'] = 'progress';
                $data_post['activity_id'] = $idActivity;


                $result = $this->TaskModels->add($data_post);
                $return = json_decode($result, true);
                if ($return['type'] == "successfully") {
                    $redirect = new redirect($this->template.'/detail'.'/'.$idActivity);
                    // $redirect->setFlash('flash', 'Them hoat dong thanh cong');

                }
            } else {
                $data = [
                    'page'      => $this->template.'/add_task',
                    'title'     => 'Thêm mới '.$this->title,
                    'template'  => $this->template,
                ];
                $this->viewUser('masterlayout', $data, $this->data_user);
            }
        }

        public function edit_task($idActivity, $idTask) {
            if (isset($_POST['submit'])){
                $data_post = $_POST['data_post'];

                $result = $this->TaskModels->update($data_post, ['task_id' => $idTask]);
                $return = json_decode($result, true);
                if ($return['type'] == "successfully") {
                    $redirect = new redirect($this->template.'/detail'.'/'.$idActivity);
                    // $redirect->setFlash('flash', 'Them hoat dong thanh cong');

                }
            } else {
                $data_task = $this->TaskModels->select_row('*', ['task_id' => $idTask]);
                $data = [
                    'page'       => $this->template.'/edit_task',
                    'title'      => 'Thêm mới '.$this->title,
                    'template'   => $this->template,
                    'data_task'  => $data_task
                ];
                $this->viewUser('masterlayout', $data, $this->data_user);
            }
        }
    
        function checkTaskFinish() {
            $id = $_POST['id'];
            $value = $_POST['value'];
                
            if ($value == '1') {
                $result = $this->TaskModels->update(['status' => 'finish', 'completion_date' => date('Y-m-d')], ['task_id' => $id]);
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

        function rateOfUser() {
            $data_arr = $_POST['data_arr'];
            $data_arr = json_decode($data_arr);

            $data_add['activity_id'] = $_POST['id'];
            $data_add['rate_activity'] = $data_arr[0];
            $data_add['rate_lead'] = $data_arr[1];
            $data_add['user_ratings'] = $_POST['user_ratings'];
                
            $result = $this->RateModels->add($data_add);
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


        // Admin
        public function index1 () {
            // Middelware
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

            // function
            $data_admin = $this->MyController->getIndexAdmin();
            $data_array = $this->ActivityModels->select_array();
            $data = [
                'data_admin'      => $data_admin,
                'page'            => $this->template.'/index',
                'title'           => 'Danh sách '.$this->title,
                'template'        => $this->template,
                'data_array'      => $data_array,
            ];
            $this->viewAdmin('masterlayout', $data);

        }


        public function add () {
             // Middelware
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

            // function
            $data_admin = $this->MyController->getIndexAdmin();
            if (isset($_POST['submit'])){
                $data_post = $_POST['data_post'];
                $data_post['status'] = 'Cho xac nhan';
                $data_post['post_date'] = date('Y-m-d');
                $data_post['owner'] = 'admin04';
                $data_post['address_id'] = 1;
                $result = $this->ActivityModels->add($data_post);
                $return = json_decode($result, true);
                if ($return['type'] == "successfully") {
                    $redirect = new redirect($this->template.'/index');
                    $redirect->setFlash('flash', 'Them hoat dong thanh cong');
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
             // Middelware
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

            // function
            $data_admin = $this->MyController->getIndexAdmin();
            if (isset($_POST['submit'])){
                $data_post = $_POST['data_post'];
                $data_post['address_id'] = 1;
                $result = $this->ActivityModels->update($data_post, ['id' => $id]);
                $return = json_decode($result, true);
                if ($return['type'] == "successfully") {
                    $redirect = new redirect($this->template.'/index');
                    $redirect->setFlash('flash', 'Cap nhat hoat dong thanh cong');
                }
            } else {
                $datas = $this->ActivityModels->select_row('*', ['id' => $id]);
                $data = [
                    'data_admin'      => $data_admin,
                    'page'      => $this->template.'/edit',
                    'title'     => 'Cập nhật '.$this->title,
                    'template'  => $this->template,
                    'datas'     => $datas
                ];
                $this->viewAdmin('masterlayout', $data);
            }
            
        }

        public function delete() {
            $id = $_POST['id'];
            $result = $this->ActivityModels->delete(['id' => $id]);
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
                $this->ActivityModels->delete(['id' => $val]);
            }
            echo json_encode(
                [
                    'result'  => 'success',
                    'message' => 'Delete successfully!'
                ]
            );
        }

        public function getTimeRemaining($closeRegDate) {
            $today = date("Y-m-d");
            if (strtotime($today) > strtotime($closeRegDate)) {
                return "Đã hết hạn đăng ký";
            } else {
                $diff = abs(strtotime($closeRegDate) - strtotime($today));
                $years = floor($diff / (365*60*60*24));
                $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)) + 1;

                $mess = "Còn ";
                if ($years > 0) {
                    $mess = $mess.$years.' năm';
                    if ($days > 0) {
                        $mess = $mess.' - '.$months.' tháng - '.$days.' ngày';
                    }                 
                } else {
                    if ($months > 0) {
                        $mess = $mess.$months.' tháng';
                        if ($days > 0) {
                            $mess = $mess.' - '.$days.' ngày';
                        }
                    } else {
                        $mess = $mess.$days.' ngày';
                    }
                }
                $mess = $mess.' đăng ký';
                return $mess;
            }
        }

        public function getRemainingAmount($minReg, $maxReg, $activity_id) {
            $data = $this->ParticipantModels->select_array('*', ['activity_id' => $activity_id]);
            $remainingAmount = 0;
            $number = count($data);    
            if ($number < $minReg) {
                $remainingAmount = $minReg - $number;
            } 
            else if ($number < $maxReg) {
                $remainingAmount = $maxReg - $number;
            }
            return $remainingAmount;
        }
    }
?>