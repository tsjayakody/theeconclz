<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url() ?>assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?php echo base_url() ?>assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Student Management | Login
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="<?php echo base_url() ?>assets/css/material-dashboard.minf066.css?v=2.1.0" rel="stylesheet" />
  <!-- pnotify css -->
  <link href="<?php echo base_url() ?>assets/pnotifyjs/node_modules/pnotify/dist/PNotifyBrightTheme.css" rel="stylesheet" type="text/css" />
  <!-- material icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Material+Icons" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/Notiflix/dist/notiflix-2.3.3.min.css">
	<script src="<?php echo base_url() ?>assets/js/Notiflix/dist/notiflix-aio-2.3.3.min.js"></script>

</head>

<body class="off-canvas-sidebar">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top text-white">
    <div class="container">
      <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
        <span class="sr-only">Toggle navigation</span>
        <span class="navbar-toggler-icon icon-bar"></span>
        <span class="navbar-toggler-icon icon-bar"></span>
        <span class="navbar-toggler-icon icon-bar"></span>
      </button>
    </div>
  </nav>
  <!-- End Navbar -->
  <div class="wrapper wrapper-full-page">
    <div class="page-header login-page header-filter"   filter-color="white" style="background-image: url('<?php echo base_url() ?>assets/img/login.jpg'); background-size: cover; background-position: top center;">
      <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
            <form class="form" action="<?php echo base_url() ?>user_controller/user_login" id="loginForm">
              <div class="card card-login card-hidden"  >
                <div class="card-header card-header-rose text-center" style="background:blue; ">
                  <h4 class="card-title">LMS Admin Login</h4>
                </div>
                <div class="card-body " id="cardBlock">
                  <span class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">email</i>
                        </span>
                      </div>
                      <input type="email" id="inputEmail" class="form-control" placeholder="Email...">
                      <div id="statusEmail"></div>
                    </div>
                  </span>
                  <span class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">lock_outline</i>
                        </span>
                      </div>
                      <input type="password" id="inputPassword" class="form-control" placeholder="Password...">
                      <div id="statusPassword"></div>
                    </div>
                  </span>
                </div>
                <div class="card-footer justify-content-center">
                  <!-- <a href="" id = "submitButton" class="btn btn-rose btn-link btn-lg">Login</a> -->
                  <button type="submit" class="btn btn-rose btn-link btn-lg">Login</button>
                </div>
                <div class="col-md-12">
                  <a href="<?php echo base_url() ?>forgot_password">Forgot password?</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container">
          <div class="copyright text-center">
            &copy;
            <script>
              document.write(new Date().getFullYear())
            </script>, made with <i class="material-icons">favorite</i> by
            <a href="http://www.prox.lk" target="_blank">Pro-X Technologies</a> in Sri Lanka.
          </div>
        </div>
      </footer>
    </div>
  </div>
  <input type="hidden" value="<?php echo base_url()?>" id="baseUrl">
  <!--   Core JS Files   -->
  <script src="<?php echo base_url() ?>assets/js/core/jquery.min.js"></script>
  <script src="<?php echo base_url() ?>assets/js/core/popper.min.js"></script>
  <script src="<?php echo base_url() ?>assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="<?php echo base_url() ?>assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="<?php echo base_url() ?>assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?php echo base_url() ?>assets/js/material-dashboard.minf066.js?v=2.1.0" type="text/javascript"></script>
  <script>
    $(document).ready(function() {
      md.checkFullPageBackgroundImage();
      setTimeout(function() {
        // after 1000 ms we add the class animated to the login/register card
        $('.card').removeClass('card-hidden');
      }, 700);
    });
  </script>
  <!-- custom javascript ----- login page.js -->
  <script src="<?php echo base_url() ?>assets/js/customjs/login.js" type="text/javascript"></script>
  <!-- pnotify js -->
  <script type="text/javascript" src="<?php echo base_url() ?>assets/pnotifyjs/node_modules/pnotify/dist/iife/PNotify.js"></script>
  <script type="text/javascript" src="<?php echo base_url() ?>assets/pnotifyjs/node_modules/pnotify/dist/iife/PNotifyButtons.js"></script>
</body>
</html>
