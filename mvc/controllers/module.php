<?php
    require_once "./mvc/core/redirect.php";
    require_once "./mvc/controllers/MyController.php";
    class module extends controller 
    {
        public $ModuleModels;
        public $MyController;
        var $template   = 'module';
        var $title      = 'Module';
        public $session = 'session';
        const type      = 1;

        public function __construct() {
            $this->ModuleModels = $this->model('ModuleModels');
            $this->MyController = new MyController();
        }

        public function index () {
            $data_menu = $this->MyController->getIndexAdmin();
            $data_array = $this->ModuleModels->select_array('*', ['parentID' => 0]);
            foreach ($data_array as $key => $val) {
                $children = $this->ModuleModels->select_array('*', ['parentID' => $val['id']]);
                $data_array[$key]['children'] = $children;
            }
            $data = [
                'data_menu'      => $data_menu,
                'page'            => $this->template.'/index',
                'title'           => 'Danh sách '.$this->title,
                'template'        => $this->template,
                'data_array'      => $data_array,
            ];
            $this->viewAdmin('masterlayout', $data);

        }

        public function add () {
            $data_admin = $this->MyController->getIndexAdmin();
            if (isset($_POST['submit'])){
                $sort_max = $this->ModuleModels->select_max_fields('sort', null);
                $data_post = $_POST['data_post'];
                $data_post['publish'] ? $publish = 1 : $publish = 0;
                $data_post['publish'] = $publish;
                $data_post['sort'] = $sort_max['sort'] + 1;
                $data_post['create_at'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
  
                $result = $this->ModuleModels->add($data_post);
                $return = json_decode($result, true);
                if ($return['type'] == "successfully") {
                    $redirect = new redirect($this->template.'/index');
                    $redirect->setFlash('flash', 'Them module thanh cong');
                }
            } else {
                $parent = $this->ModuleModels->select_array('*', ['parentID' => 0]);
                $data = [
                    'data_admin'      => $data_admin,
                    'page'      => $this->template.'/add',
                    'title'     => 'Thêm mới '.$this->title,
                    'template'  => $this->template,
                    'parent'    => $parent,
                ];
                $this->viewAdmin('masterlayout', $data);
            }
        }

        public function edit($id) {
            $data_admin = $this->MyController->getIndexAdmin();
            if (isset($_POST['submit'])){
                $data_post = $_POST['data_post'];
                if ($id == $data_post['parentID']) {
                    $redirect = new redirect($this->template.'/'.'/index');
                    $redirect->setFlash('error', 'ID cua danh muc nay trung voi id hien tai');;
                } else {
                    $data_post['publish'] ? $publish = 1 : $publish = 0;
                    $data_post['publish'] = $publish;
                    $data_post['update_at'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
                    $result = $this->ModuleModels->update($data_post, ['id' => $id]);
                    $return = json_decode($result, true);
                    if ($return['type'] == "successfully") {
                        $redirect = new redirect($this->template.'/index');
                        $redirect->setFlash('flash', 'Cap nhat hoat dong thanh cong');
                    }
                }
                
            } else {
                $datas = $this->ModuleModels->select_row('*', ['id' => $id]);
                $parent = $this->ModuleModels->select_array('*', ['parentID' => 0]);
                $data = [
                    'data_admin'      => $data_admin,
                    'page'      => $this->template.'/edit',
                    'title'     => 'Cập nhật '.$this->title,
                    'template'  => $this->template,
                    'datas'     => $datas,
                    'parent'    => $parent
                ];
                $this->viewAdmin('masterlayout', $data);
            }   
            
        }

        public function delete() {
            $id = $_POST['id'];
            $result = $this->ModuleModels->delete(['id' => $id]);
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
                $this->ModuleModels->delete(['id' => $val]);
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
            $dataUpdate['publish'] = $value;
            $result = $this->ModuleModels->update($dataUpdate, ['id' => $id]);
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