<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url() ?>assets/img/apple-icon.png" />
  <link rel="icon" type="image/png" href="<?php echo base_url() ?>assets/img/favicon.png" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    TheEconClz | LMS
  </title>
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no"
    name="viewport" />

  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css"
    href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" />
  <!-- CSS Files -->
  <link href="<?php echo base_url() ?>assets/css/material-dashboard.minf066.css?v=2.1.0" rel="stylesheet" />
  <!-- pnotify css -->
  <link href="<?php echo base_url() ?>assets/pnotifyjs/node_modules/pnotify/dist/PNotifyBrightTheme.css" rel="stylesheet" type="text/css" />
  <!-- select2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />


  <script src="<?php echo base_url() ?>assets/js/core/jquery.min.js"></script>
  <script src="<?php echo base_url() ?>assets/js/core/popper.min.js"></script>
  <script src="<?php echo base_url() ?>assets/js/core/bootstrap-material-design.min.js"></script>
    <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
      <script src="<?php echo base_url() ?>assets/js/plugins/bootstrap-selectpicker.js"></script>
    <!-- Plugin for the momentJs  -->
    <script src="<?php echo base_url() ?>assets/js/plugins/moment.min.js"></script>
  <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
    <script src="<?php echo base_url() ?>assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
	<!-- development version, includes helpful console warnings -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/Notiflix/dist/notiflix-2.3.3.min.css">
	<script src="<?php echo base_url() ?>assets/js/Notiflix/dist/notiflix-aio-2.3.3.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

</head>


<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="azure" data-background-color="white" data-image="<?php echo base_url() ?>assets/img/sidebar-2.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
      -->
      <div class="sidebar-wrapper">
        <div class="user">
          <div class="photo">
            <img src="<?php echo base_url() ?>assets/img/faces/avatar.jpg" />
          </div>
          <div class="user-info">
            <a data-toggle="collapse" href="#userpane" class="username">
              <span>
                <?php echo $name ?>
                <b class="caret"></b>
              </span>
            </a>
            <div class="collapse" id="userpane">
              <ul class="nav">
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url() ?>logout">
                    <span class="sidebar-mini"> LO </span>
                    <span class="sidebar-normal"> Log Out </span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <!-- start of generating user navidation menu -->
        <?php
        if (isset($menu)) {
          echo '<ul class="nav">';
          echo '<li class="nav-item active ">
                  <a class="nav-link" href="'.base_url().'dashbord">
                    <i class="material-icons">dashboard</i>
                    <p>Dashboard</p>
                  </a>
                </li>';
          foreach ($menu as $key => $value) {
            echo '<li class="nav-item '.$value['main_nav_class'].'">
                    <a class="nav-link" data-toggle="collapse" href="#'.$value['idmain_menu'].'" aria-expanded="'.$value['area_expand'].'">
                      <i class="material-icons">'.$value['main_menu_icon'].'</i>
                      <p>
                        '.$value['main_menu_name'].'
                        <b class="caret"></b>
                      </p>
                    </a>
                    <div class="collapse '.$value['collaps'].'" id="'.$value['idmain_menu'].'">
                      <ul class="nav">';
            
            foreach ($value['sub_menu'] as $keysub => $valuesub) {
              echo '<li class="nav-item '.$valuesub['sub_item'].'">
                      <a class="nav-link" href="'.base_url().$valuesub['view'].'">
                        <span class="sidebar-mini"> '.$valuesub['short_name'].' </span>
                        <span class="sidebar-normal"> '.$valuesub['sub_menu_name'].' </span>
                      </a>
                    </li>';
            }

            echo '    </ul>
                    </div>
                  </li>';
          }
          echo '</ul>';
        }
        ?>
        <!-- end of generating user navidation menu -->
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-minimize">
              <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
                <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
                <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
              </button>
            </div>
            <a class="navbar-brand" href="#"><?php  echo $nav_brand ?></a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
        </div>
      </nav>
      <!-- End Navbar -->
