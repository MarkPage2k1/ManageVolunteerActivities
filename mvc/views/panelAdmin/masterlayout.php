<?php require_once "./mvc/views/panelAdmin/include/header.php" ?>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="admin" class="site_title"><i class="fa fa-users"></i> <span>Charity!</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">


              <div class="profile_pic">
                <img src="public/build/images/img.jpg" alt="avatar" class="img-circle profile_img">
              </div>

              <div class="profile_info">
                <span>Welcome,</span>
                <h2>John Doe</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <?php require_once "./mvc/views/panelAdmin/include/sidebar.php" ?>

            <!-- /sidebar menu -->

          </div>
        </div>

        <!-- top navigation -->
        <?php require_once "./mvc/views/panelAdmin/include/topnav.php" ?>

        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <?php require_once "./mvc/views/panelAdmin/".$data['page'].".php" ?>
        </div>
        <!-- /page content -->

        <?php require_once "./mvc/views/panelAdmin/include/footer.php" ?>