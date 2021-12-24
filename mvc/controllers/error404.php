<?php 
    class error404 extends controller {

        function __construct() {
        }

        function index() {
            $this->viewUser('error/404');
        }

    }
?>