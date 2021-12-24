<?php 
// Goi module va view
class controller {
    public function model($model) {
        require_once "./mvc/models/".$model.".php";
        return new $model;
    }

    public function viewAdmin($view, $data=[]) {
        require_once "./mvc/views/panelAdmin/".$view.".php";
    }

    public function viewUser($view, $data=[], $data_user=[]) {
        require_once "./mvc/views/panelUser/".$view.".php";
    }

    public function helper($helper) {
        require_once "./mvc/helper/".$helper.".php";
        return new $helper;
    }
}
?>