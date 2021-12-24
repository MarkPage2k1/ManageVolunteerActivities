<?php require_once "./mvc/views/panelUser/include/header.php" ?>
<body>
	
  <?php require_once "./mvc/views/panelUser/include/topnav.php" ?>

  <!-- page content --> 
    <?php require_once "./mvc/views/panelUser/".$data['page'].".php" ?>
  <!-- /page content -->
  
  <?php require_once "./mvc/views/panelUser/include/footer.php" ?>