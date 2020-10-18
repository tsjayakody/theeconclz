<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title> Dashboard | LMS </title>
    <link rel="icon" type="image/x-icon" href="<?php echo base_url() ?>files/assets/img/90x90.jpg"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="<?php echo base_url() ?>files/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>files/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
	<!-- notiflix notification library css -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>files/plugins/Notiflix-2.3.2/dist/notiflix-2.3.2.min.css">

	<!-- development version, includes helpful console warnings -->
	<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

	<!-- axios jdeliver cdn -->
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
	<!-- notiflix notification library -->
	<script src="<?php echo base_url() ?>files/plugins/Notiflix-2.3.2/dist/notiflix-aio-2.3.2.min.js"></script>
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    
</head>
<body class="alt-menu ">
    

    <!--  BEGIN NAVBAR  -->
    <?php echo $this->load->view('includes/navbar','',true); ?>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container sidebar-closed sbar-open" id="container">

        <div class="overlay"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <?php echo $this->load->view('includes/sidebar',array('menu'=>'dashboard'),true); ?>
        <!--  END SIDEBAR  -->
        
        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="page-header">
                    <div class="page-title">
                        <h3></h3>
                    </div>
                </div>


                <!-- CONTENT AREA -->
                
                <div class="row" id="dashApp">

					<?php

					if (!empty($data)) {
						date_default_timezone_set('Asia/Colombo');
						foreach ($data as $key => $value) {

							$date1=date_create($value['subscription_start']);
							$date2=date_create($value['subscription_end']);
							$toDate=date_create();

							$diff=date_diff($date1,$date2);
							$diff1 = date_diff($date1,$toDate);

							$fullDays =  $diff->format("%a");
							$nowDays = $diff1->format("%a");

							$percent = (($fullDays-$nowDays)/$fullDays) * 100;





							echo '
							
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget">
                            <div class="widget-heading d-xl-flex d-lg-flex justify-content-between">
                                <div class="">
                                    <h5 class="font-weight-bold">'.$value['subject_name'].'</h5>
                                </div>

                                <div class="">
                                    <h5 class="">'.$value['course_name'].'</h5>
                                </div>

                                <div class="">
                                    <h5 class="">Valid until: '.$value['subscription_end'].'</h5>
                                </div>
                            </div>

                            <!-- Info -->
                            <div class="progress progress-lg br-30">
                                <div class="progress-bar bg-gradient-info" role="progressbar" style="width: '.$percent.'%" aria-valuenow="'.$percent.'" aria-valuemin="0" aria-valuemax="100">'.($fullDays-$nowDays).' Days left</div>
                            </div>

                            <div class="widget-content">
                                
                                <div class="row">';

									if (isset($value['contents'])) {
										foreach ($value['contents'] as $key1 => $value1) {

											echo '
                                    	<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing">
                                        <div class="card component-card_2">
                                            <div class="card-body">
                                                <h5 class="card-title">'.$value1['title'].'</h5>
                                                <p class="card-text">'.$value1['description'].'</p>
                                                <p class="card-text font-weight-bold">Available at:</p>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-4">
                                                        <thead>
                                                            <tr>
                                                                <th>From</th>
                                                                <th>To</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            ';
											foreach ($value1['time_slots'] as $key2 => $value2) {

												echo '
                                    						
                                    						<tr>
                                                                <td class="text-success">'.$value2['available_from'].'</td>
                                                                <td class="text-danger">'.$value2['available_to'].'</td>
                                                            </tr>
                                    						
                                    						';


											}
											//teacher/'.$value['idteachers']
											echo '
																</tbody>
															</table>
														</div>
														<p class="card-text">By: <a href="#!"><span class="badge outline-badge-warning"> '.$value['teachers_name'].' </span></a></p>
														<a v-on:click="getStatus"  data-id="'.$value1['idcontents'].'" class="btn btn-primary">View Now</a>
													</div>
												</div>
											</div>
                                    	';

										}
									} else {
										echo '	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
													<div class="card component-card_2">
														<div class="card-body text-center">
															<h5 class="card-title text-danger">No contents available.</h5>
															<p class="card-text">Contents for this course are not added yet. It will available soon.</p>
														</div>
													</div>
												</div>';
									}


                               echo '</div>

                            </div>
                        </div>
                    </div>
							
							';


						}


					} else {
						echo '
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
								<div class="widget">
									<div class="widget-heading d-xl-flex d-lg-flex justify-content-between">
										<div class="">
											<h5 class="font-weight-bold">You have no active subscriptions.</h5>
										</div>
									</div>
								</div>
							</div>';
					}

					?>

                </div>




                <!-- CONTENT AREA -->

            </div>
        </div>
        <!--  END CONTENT AREA  -->
    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="<?php echo base_url() ?>files/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url() ?>files/bootstrap/js/popper.min.js"></script>
    <script src="<?php echo base_url() ?>files/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>files/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?php echo base_url() ?>files/assets/js/app.js"></script>
    
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="<?php echo base_url() ?>files/assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

	<script>
		var dashApp = new Vue({
			el: '#dashApp',
			data: {},
			methods: {
				getStatus: (event) => {
					let content_id = event.target.getAttribute('data-id');

					let formData = new FormData();
					formData.append('content_id', content_id);
					// verify there is no active timeslot record
					axios({
						method: 'post',
						url: '<?php echo base_url() ?>'+'course_controller/verify_active_timeslot',
						headers: {'Content-Type': 'multipart/form-data'},
						data: formData
					}).then((response) => {
						if (response.data === false) {
							Notiflix.Notify.Failure('Something went wrong. Please try again.');
						} else if (response.data.row_count === 0){
							Notiflix.Confirm.Show(
									'Before continue..',
									'If you continue, then you will only be able to access the content in this timeslot. Do you continue?',
									'Yes',
									'No',
									function(){
										// Yes button callback
										window.location.href = '<?php echo base_url() ?>'+'content/'+content_id;
									}, function(){

									}
							);
						} else {
							window.location.href = '<?php echo base_url() ?>'+'content/'+content_id;
						}
					})
				}
			}
		});
	</script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->


    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
</body>
</html>
