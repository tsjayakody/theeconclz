<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title> <?php if (isset($content)) echo $content['title']; ?> | LMS </title>
    <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/img/90x90.jpg" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="<?php echo base_url(); ?>files/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>files/assets/css/plugins.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>files/assets/css/tables/table-basic.css" rel="stylesheet" type="text/css" />
	<?php if (isset($error) || isset($watchAllowed)) echo '<link href="'.base_url().'files/assets/css/elements/infobox.css" rel="stylesheet" type="text/css" />' ?>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
	<!-- development version, includes helpful console warnings -->
	<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

	<!-- axios jdeliver cdn -->
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
	<!-- notiflix notification library -->
	<script src="<?php echo base_url(); ?>files/plugins/Notiflix-2.3.2/dist/notiflix-aio-2.3.2.min.js"></script>
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
        <?php echo $this->load->view('includes/sidebar',array('menu'=>'courses'),true); ?>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="page-header">
                    <div class="page-title">
                        <h3></h3>
                    </div>
                </div>


				<?php


				if (isset($error)) {


					echo '
					<div class="container h-100">
  						<div class="row h-100 justify-content-center align-items-center">
    						<form class="col-12">
      							<div class="infobox-2">
    								<div class="info-icon">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
    								</div>
    								<h5 class="info-heading text-warning">We are sorry!</h5>
    								<p class="info-text">'.$error.'</p>
    								<a class="btn btn-primary" href="'.base_url().'dashboard">Dashboard </a>';
								if (isset($err_status) && $err_status === 'NO_STD_TIMESLOT') {
									echo '<button class="mx-2 btn btn-danger" onclick="javascript:verificationModal.showVerifyModel = true; return false;">Request to watch again </button>';
								}

							echo 	'</div>
    						</form>   
  						</div>  
					</div>
					';

				}


				?>

                <!-- CONTENT AREA -->

                <div class="row" <?php if (isset($error)) echo 'style="display: none !important"' ?>>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget">
                            <div class="widget-heading d-xl-flex d-lg-flex justify-content-between">
                                <div class="">
                                    <h5 class="">Valid until: <?php if (isset($content)) echo $content['subscription_end'] ?></h5>
                                </div>
                            </div>

                            <!-- Info -->
                            <div class="progress progress-lg br-30">
                                <div class="progress-bar bg-gradient-info" role="progressbar" style="width: <?php if (isset($percent)) echo $percent ?>%"
                                    aria-valuenow="<?php if (isset($percent)) echo $percent ?>" aria-valuemin="0" aria-valuemax="100"><?php if (isset($dayCount)) echo $dayCount ?> Days left</div>
                            </div>

                            <div class="widget-content">

                                <div class="row">

                                    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10 layout-spacing">
                                        <div class="card component-card_2">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php if (isset($content)) echo $content['title'] ?></h5>
                                                <p class="card-text"><?php if (isset($content)) echo $content['description'] ?></p>
												<p class="card-text text-danger"><?php if (isset($adt_from) && isset($adt_to)) echo 'This is additionally allocated time slot. Its valid only from '.$adt_from.' to '.$adt_to.'.'; ?></p>

                                                <?php if (isset($content) && isset($watchAllowed))
                                                			{

                                                				if ($watchAllowed) {
																	echo  '<div style="padding:54.05% 0 0 0;position:relative;"><iframe src="'.$content['video_link'].'" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>';
																}

                                                			}  ?>
												<?php if (isset($watchAllowed) && ($watchAllowed === FALSE)) {

													echo '
													
													<div class="infobox-2">
    													<div class="info-icon">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
    													</div>
    													<h5 class="info-heading text-warning">We are sorry!</h5>
    													<p class="info-text">Your watch count is exceeded. If you have fair reason, you can request for watch again.</p>
    													<a class="btn btn-primary" href="'.base_url().'dashboard">Dashboard </a>
								
														<button class="mx-2 btn btn-danger" onclick="javascript:verificationModal.showVerifyModel = true; return false;">Request to watch again </button>
						

													</div>
													
													';


												} ?>
                                            </div>
                                        </div>
                                    </div>

									<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10 layout-spacing">
										<div class="card component-card_2">
											<div class="card-body">
												<h5 class="card-title">Downloadable resources:</h5>


												<div class="table-responsive">
													<table class="table table-bordered table-hover table-condensed mb-4">
														<thead>
														<tr>
															<th>File name</th>
															<th>Description</th>
															<th class="text-center">Download</th>
														</tr>
														</thead>
														<tbody>

														<?php

														if (isset($resources)) {

															foreach ($resources as $key => $value) {

																echo '
															
															<tr>
															<td>'.$value['file_name'].'</td>
															<td>'.$value['description'].'</td>
															<td class="text-center">
																<ul class="table-controls">
																	<li><a target="_blank" rel="noopener noreferrer" href="'.base_url().'download/'.$value['idresources'].'" data-toggle="tooltip" data-placement="top" title="Delete">
																			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg></a></li>
																</ul>
															</td>
														</tr>
															
															';


															}


														}

														?>
														</tbody>
														<tfoot>
														<tr>
															<th>File name</th>
															<th>Description</th>
															<th class="text-center">Download</th>
														</tr>
														</tfoot>
													</table>
												</div>

											</div>
										</div>
									</div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>


				<!-- details model -->
				<div id="verificationModal">
					<div v-if="showVerifyModel">
						<transition name="modal">
							<div class="modal-mask">
								<div class="modal-wrapper">
									<div class="modal-dialog modal-dialog-scrollable" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title">Request additional timeslot.</h5>

												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true" @click="showVerifyModel = false">&times;</span>
												</button>
											</div>
											<div class="modal-body" id="modelBody">
												<p class="info-text">Here you can request for watch this video again with fair reason. When your request is accepted you will noticed by SMS. </p>
												<div class="form-group">
													<label for="verificationCode"></label>
													<input v-on:click="clearFieldError" type="text" class="form-control" id="message" value="" placeholder="Your message">
													<div class="invalid-feedback" style="display: block">{{form_errors.message}}</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" data-id="<?php if (isset($contentid)){ echo $contentid; }?>" class="btn btn-success" v-on:click="verifyNumber">Send</button>
												<button type="button" class="btn btn-secondary" @click="showVerifyModel = false">Close</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</transition>
					</div>
				</div>
				<!-- end of details model-->

                <!-- CONTENT AREA -->

            </div>
        </div>
        <!--  END CONTENT AREA  -->
    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="<?php echo base_url(); ?>files/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url(); ?>files/bootstrap/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>files/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>files/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?php echo base_url(); ?>files/assets/js/app.js"></script>

    <script>
        $(document).ready(function () {
            App.init();
        });
    </script>
    <script src="<?php echo base_url(); ?>files/assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
	<script>
		var verificationModal = new Vue({
			el: '#verificationModal',
			data: {
				showVerifyModel: false,
				form_errors: {}
			},
			methods: {
				verifyNumber: (event) => {
					// create new formdata object
					let formData = new FormData();

					// set data to form data object
					formData.append('message', document.getElementById('message').value);
					formData.append('content_id', event.target.getAttribute('data-id'));

					// send axios post request
					axios({
						method: 'post',
						url: '<?php echo base_url() ?>course_controller/request_additional_timeslot',
						data: formData,
						headers: {'Content-Type': 'multipart/form-data'}
					}).then((response) => {
						if (response.data.success === false) {
							if (response.data.form_errors) {
								verificationModal.form_errors = response.data.form_errors;
								for (const key in verificationModal.form_errors) {
									if (verificationModal.form_errors.hasOwnProperty(key)) {
										const element = verificationModal.form_errors[key];
										if (element) {
											document.getElementById(key).classList.add('is-invalid');
										} else {
											document.getElementById(key).classList.remove('is-invalid');
										}
									}
								}
							} else if (response.data.error) {
								Notiflix.Notify.Failure(response.data.error);
							}
						} else {
							Notiflix.Notify.Success('Your request is sent.');
							verificationModal.showVerifyModel = false;
						}
					})
				},
				clearFieldError: (event) => {
					let element = event.target;
					element.classList.remove('is-invalid');
					verificationModal.form_errors[element.id] = "";
				}
			}
		});
	</script>
	<style>
		.modal-mask {
			position: fixed;
			z-index: 9998;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(0, 0, 0, .5);
			display: table;
			transition: opacity .3s ease;
		}

		.modal-wrapper {
			display: table-cell;
			vertical-align: middle;
		}
	</style>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
</body>

</html>
