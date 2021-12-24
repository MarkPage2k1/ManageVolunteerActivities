 <!-- Preloader -->
<div class="loader">
  <div class="loader-inner">
    <div class="k-line k-line11-1"></div>
    <div class="k-line k-line11-2"></div>
    <div class="k-line k-line11-3"></div>
    <div class="k-line k-line11-4"></div>
    <div class="k-line k-line11-5"></div>
  </div>
</div>
<!-- End Preloader -->

<!-- Mp Color -->
<div class="mp-color">
  <div class="icon inOut"><i class="fa fa-cog fa-spin"></i></div>
  <h4>Choose Color</h4>
  <span class="color1"></span>
  <span class="color2"></span>
  <span class="color3"></span>
  <span class="color4"></span>
  <span class="color5"></span>
  <span class="color6"></span>
  <span class="color7"></span>
  <span class="color8"></span>
  <span class="color9"></span>
  <span class="color10"></span>
</div>
<!--/ End Mp Color -->


<!-- Start Header -->
<header id="header">
  <div class="container">
    <div class="row">
      <div class="col-md-2 col-sm-12 col-xs-12">
        <!-- Logo -->
        <div class="logo">
          <a href="home.html">Charity</a>
        </div>
        <!--/ End Logo -->
        <div class="mobile-nav"></div>
      </div>
      <div class="col-md-10 col-sm-12 col-xs-12">
        <div class="nav-area">
          <!-- Main Menu -->
          <nav class="mainmenu">
            <div class="collapse navbar-collapse">
              <ul class="nav navbar-nav menu">
                <li><a class="active" href="home/"><i class="fa fa-home"></i>Trang chủ</a></li>
                <li><a href="activity"><i class="fa fa-rocket"></i>Các hoạt động</a></li>
                <li><a href="#portfolio"><i class="fa fa-briefcase"></i>Sự kiện</a></li>
                <li><a href="#my-timeline"><i class="fa fa-history"></i>Blog</a></li>	
                <li><a href="./activity/create/"><i class="fa fa-address-book"></i>Thêm mới</a></li>		
              </ul>
              <ul class="social-icon">
                <li><a href="javascript:void(0)"><i class="fa fa-plus"></i></a></li>
              </ul>
              <ul class="social">
                  <?php if (isset($_SESSION['user']))
                    {
                      if (isset($data_user) && $data_user != null) {
                        echo 'Xin chao, '.$data_user['username'];
                        echo '</br>';
                        echo '<a href="account/logout"><li>Logout</li></a>';
                      } else {
                        echo 'Chua co thong tin user';
                      }
                    } else {
                      echo '
                        <a href="account"><li>Sign in</li></a>
                        <a href="account"><li>Sign up</li></a>
                      ';
                    }
                   ?>
                  
                <!-- <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-behance"></i></a></li>
                <li><a href="#"><i class="fa fa-dribbble"></i></a></li> -->
              </ul>
            </div>
          </nav>
          <!--/ End Main Menu -->
        </div>
      </div>
    </div>
  </div>
</header>
<div id="directTop"></div>
  <!--/ End Header -->