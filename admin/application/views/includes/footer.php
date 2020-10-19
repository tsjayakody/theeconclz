<footer class="footer">
        <div class="container-fluid">
          <div class="copyright float-right">
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
  
  <!--   Core JS Files   -->

  <script src="<?php echo base_url() ?>assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>

  <!--  Plugin for Sweet Alert -->
  <script src="<?php echo base_url() ?>assets/js/plugins/sweetalert2.js"></script>
  <!-- Forms Validations Plugin -->
  <script src="<?php echo base_url() ?>assets/js/plugins/jquery.validate.min.js"></script>
  <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
  <script src="<?php echo base_url() ?>assets/js/plugins/jquery.bootstrap-wizard.js"></script>

  
  <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
  <script src="<?php echo base_url() ?>assets/js/plugins/jquery.dataTables.min.js"></script>
  <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
  <script src="<?php echo base_url() ?>assets/js/plugins/bootstrap-tagsinput.js"></script>
  <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
  <script src="<?php echo base_url() ?>assets/js/plugins/jasny-bootstrap.min.js"></script>
  <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
  <script src="<?php echo base_url() ?>assets/js/plugins/fullcalendar.min.js"></script>
  <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
  <script src="<?php echo base_url() ?>assets/js/plugins/jquery-jvectormap.js"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="<?php echo base_url() ?>assets/js/plugins/nouislider.min.js"></script>
  <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
  <!-- <script src="<?php echo base_url() ?>cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script> -->
  <!-- Library for adding dinamically elements -->
  <script src="<?php echo base_url() ?>assets/js/plugins/arrive.min.js"></script>
  <!-- Chartist JS -->
  <script src="<?php echo base_url() ?>assets/js/plugins/chartist.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="<?php echo base_url() ?>assets/js/plugins/bootstrap-notify.js"></script>
  <!-- ajax file upload  -->
  <script src="<?php echo base_url() ?>assets/js/plugins/ajaxfileupload.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?php echo base_url() ?>assets/js/material-dashboard.minf066.js?v=2.1.0" type="text/javascript"></script>
  <!-- pnotify js -->
  <script type="text/javascript" src="<?php echo base_url() ?>assets/pnotifyjs/node_modules/pnotify/dist/iife/PNotify.js"></script>
  <script type="text/javascript" src="<?php echo base_url() ?>assets/pnotifyjs/node_modules/pnotify/dist/iife/PNotifyButtons.js"></script>
  <script type="text/javascript" src="<?php echo base_url() ?>assets/pnotifyjs/node_modules/pnotify/dist/iife/PNotifyCallbacks.js"></script>
  <script type="text/javascript" src="<?php echo base_url() ?>assets/pnotifyjs/node_modules/pnotify/dist/iife/PNotifyCompat.js"></script>
  <script type="text/javascript" src="<?php echo base_url() ?>assets/pnotifyjs/node_modules/pnotify/dist/iife/PNotifyConfirm.js"></script>
  <script type="text/javascript" src="<?php echo base_url() ?>assets/pnotifyjs/node_modules/pnotify/dist/iife/PNotifyDesktop.js"></script>
  <!-- select2 -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
  <!-- custom javascript file -->
  <?php 
  if($js != null){
    echo '<script src="'.base_url().'assets/js/customjs/'.$js.'.js" type="text/javascript"></script>';
  }
   ?>
  
  <script>
    $(document).ready(function () {
     // $().ready(function () {
        $sidebar = $(".sidebar");

        $sidebar_img_container = $sidebar.find(".sidebar-background");

        $full_page = $(".full-page");

        $sidebar_responsive = $("body > .navbar-collapse");

        window_width = $(window).width();

        fixed_plugin_open = $(
          ".sidebar .sidebar-wrapper .nav li.active a p"
        ).html();

    //  });
    });
  </script>
</body>
</html>
