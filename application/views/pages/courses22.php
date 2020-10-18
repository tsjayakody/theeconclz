<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title> Courses | LMS </title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="files/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="files/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
	<!-- notiflix notification library css -->
	<link rel="stylesheet" type="text/css" href="files/plugins/Notiflix-2.3.2/dist/notiflix-2.3.2.min.css">

	<!-- development version, includes helpful console warnings -->
	<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

	<!-- axios jdeliver cdn -->
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
	<!-- notiflix notification library -->
	<script src="files/plugins/Notiflix-2.3.2/dist/notiflix-aio-2.3.2.min.js"></script>
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


                <!-- CONTENT AREA -->
                
                <div class="row">

                    <div v-for="course in courses" class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget">
                            <div class="widget-heading d-xl-flex d-lg-flex justify-content-between">
                                <div class="">
                                    <h5 class="font-weight-bold">{{course.subject_name}}</h5>
                                </div>
                            </div>



                            <div class="widget-content">

                                <div class="row">

                                    <div v-for="item in course.courses" class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing">
                                        <div class="card component-card_2">
                                            <div class="card-body">
                                                <h5 class="card-title">{{item.course_name}}</h5>
                                                <p class="card-text">{{item.description}}</p>
                                                <p class="card-text">By: <a v-bind:href="'#teacher/'+course.idteachers"><span class="badge outline-badge-warning"> {{course.teachers_name}} </span></a></p>
                                                <button v-on:click="subscribeCourse" v-bind:data-id="item.idcourses" class="btn btn-primary">Subscribe</button>
												<button v-on:click="courseContent" v-bind:data-id="item.idcourses" class="btn btn-success">View Content</button>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>


				<!-- details model -->
				<div v-if="showDetailsModel">
					<transition name="modal">
						<div class="modal-mask">
							<div class="modal-wrapper">
								<div class="modal-dialog modal-dialog-scrollable" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title">Course Details</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true" @click="showDetailsModel = false">&times;</span>
											</button>
										</div>
										<div class="modal-body" id="modelBody">
											<div class="">
												<div class="">
													<h3 class="">{{courseContentData.course_name}}</h3>
													<p class="card-text">{{courseContentData.course_description}}</p>
													<p class="text-danger">Conduct By: {{courseContentData.teachers_name}}</p>

												</div>

												<div v-for="contentitem in courseContentData.contents" class="table-responsive mt-4">
													<h5 class="text-success">{{contentitem.title}}</h5>
													<table class="table table-sm contextual-table">
														<tr>
															<th>Available form</th>
															<th>Available until</th>
														</tr>
														<tr v-for="timeslot in contentitem.time_slots">
															<td>{{timeslot.available_from}}</td>
															<td>{{timeslot.available_to}}</td>
														</tr>
													</table>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-success">Rs.{{courseContentData.monthly_fee}}.00</button>
											<button type="button" class="btn btn-secondary" @click="showDetailsModel = false">Close</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</transition>
				</div>
				<!-- end of details model-->

                <!-- CONTENT AREA -->

            </div>
        </div>
        <!--  END CONTENT AREA  -->
    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="files/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="files/bootstrap/js/popper.min.js"></script>
    <script src="files/bootstrap/js/bootstrap.min.js"></script>
    <script src="files/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="files/assets/js/app.js"></script>
    
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="files/assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
	<script>
		let allcapp = new Vue({
			el:'#content',
			data: {
				streams: '',
				courses: {
					'' : {"":""}
				},
				showDetailsModel: false,
				showSubscribeModel: false,
				courseContentData: {}
			},
			mounted: () => {
				axios({
					type: 'get',
					url: 'Course_controller/getAllCourses'
				}).then((response) => {
					if (response.data.error) {
						console.log(response.data.error);
						Notiflix.Report.Failure('Error!', response.data.error, 'OK');
					} else {
						allcapp.courses = response.data;
					}
				}).catch((error) => {
					console.log(error);
					Notiflix.Report.Failure('Error!', 'Something went wrong.', 'OK');
				});
			},
			methods: {
				subscribeCourse: (event) => {
					let course_id = event.target.getAttribute('data-id');
					var formData = new FormData();
					formData.append('course_id',course_id);

					// confirm before buy it
					Notiflix.Confirm.Show(
							'Really?',
							'Do you want to subscribe this course?',
							'Yes',
							'No',

							// ok button callback
							function(){
								axios({
									method: 'post',
									url: '<?php echo base_url() ?>Course_controller/subscribeCourse',
									data: formData,
									headers: { 'Content-Type': 'multipart/form-data' }
								}).then((response) => {
									if (response.data.error) {
										console.log(response.data.error);
										Notiflix.Report.Failure('Error!', response.data.error, 'OK');
									} else {
										allcapp.courseContentData = response.data;
										Notiflix.Report.Success(response.data.ref_code, 'This is your reference code. You should mention this code in your bank payment as reference code', 'OK');
									}
								}).catch((error) => {
									console.log(error);
									Notiflix.Report.Failure('Error!', 'Something went wrong.', 'OK');
								})
							},

							// cancel button callback
							function(){
								Notiflix.Report.Failure('Canceled', 'You are not subscribed to the course.', 'OK');
							},
					);
				},
				courseContent: (event) => {
					let course_id = event.target.getAttribute('data-id');
					var formData = new FormData();
					formData.append('course_id',course_id);
					axios({
						method: 'post',
						url: '<?php echo base_url() ?>Course_controller/getCourseDetails',
						data: formData,
						headers: { 'Content-Type': 'multipart/form-data' }
					}).then((response) => {
						if (response.data.error) {
							console.log(response.data.error);
							Notiflix.Report.Failure('Error!', response.data.error, 'OK');
						} else {
							allcapp.courseContentData = response.data;
							allcapp.showDetailsModel = true;
						}
					}).catch((error) => {
						console.log(error);
						Notiflix.Report.Failure('Error!', 'Something went wrong.', 'OK');
					})
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
