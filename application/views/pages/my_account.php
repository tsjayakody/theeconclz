<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
	<title>My Account | LMS </title>
	<link rel="icon" type="image/x-icon" href="<?php echo base_url() ?>files/assets/img/90x90.jpg"/>
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
	<link href="<?php echo base_url() ?>files/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url() ?>files/assets/css/plugins.css" rel="stylesheet" type="text/css"/>
	<!-- END GLOBAL MANDATORY STYLES -->

	<!--  BEGIN CUSTOM STYLE FILE  -->
	<link href="<?php echo base_url() ?>files/assets/css/users/user-profile.css" rel="stylesheet" type="text/css"/>
	<!--  END CUSTOM STYLE FILE  -->
	<!-- notiflix notification library -->
	<!-- notiflix notification library css -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>files/plugins/Notiflix-2.3.2/dist/notiflix-2.3.2.min.css">
	<script src="<?php echo base_url() ?>files/plugins/Notiflix-2.3.2/dist/notiflix-aio-2.3.2.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
	<!-- development version, includes helpful console warnings -->
	<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
</head>
<body class="alt-menu sidebar-noneoverflow">

<!--  BEGIN NAVBAR  -->
<?php echo $this->load->view('includes/navbar', '', true); ?>
<!--  END NAVBAR  -->

<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container sidebar-closed sbar-open" id="container">

	<div class="overlay"></div>
	<div class="cs-overlay"></div>
	<div class="search-overlay"></div>

	<!--  BEGIN SIDEBAR  -->
	<?php echo $this->load->view('includes/sidebar', array('menu' => 'myaccount'), true); ?>
	<!--  END SIDEBAR  -->

	<!--  BEGIN CONTENT AREA  -->
	<div id="content" class="main-content">
		<div class="layout-px-spacing" id="account_app">

			<div class="row layout-spacing">


				<div class="col-xl-12 col-lg-12 col-md-12 layout-spacing layout-top-spacing">
					<div id="general-info" class="section general-info">
						<div class="info">
							<h6 class="">General Information</h6>
							<div class="row">
								<div class="col-lg-12 mx-auto">
									<div class="row">
										<div class="col-xl-12 col-lg-12 col-md-12 mt-md-0 mt-4">
											<div class="form">
												<div class="row">
													<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
														<div class="form-group mb-4">
															<label for="firstname">First Name</label>
															<input v-model="student.first_name" type="text"
																   class="form-control" placeholder="First Name"
																   value="" @click="gen_form_errors.first_name = ''">
															<div class="invalid-feedback" style="display: block;">{{gen_form_errors.first_name}}</div>
														</div>
													</div>
													<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
														<div class="form-group mb-4">
															<label for="lastname">Last Name</label>
															<input v-model="student.last_name" type="text"
																   class="form-control" placeholder="Last Name"
																   value="" @click="gen_form_errors.last_name = ''">
															<div class="invalid-feedback" style="display: block;">{{gen_form_errors.last_name}}</div>
														</div>
													</div>
													<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
														<div class="form-group mb-4">
															<label for="phonenumber">Phone number</label>
															<input v-model="student.phone_number" type="text"
																   class="form-control" placeholder="Phone number"
																   value="" @click="gen_form_errors.phone_number = ''">
															<div class="invalid-feedback" style="display: block;">{{gen_form_errors.phone_number}}</div>
														</div>
													</div>
													<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
														<div class="form-group mb-4">
															<label for="school">School</label>
															<input v-model="student.school" type="text"
																   class="form-control" placeholder="School"
																   value="" @click="gen_form_errors.school = ''">
															<div class="invalid-feedback" style="display: block;">{{gen_form_errors.school}}</div>
														</div>
													</div>
													<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
														<div class="form-group mb-4">
															<label for="studentcity">City</label>
															<input v-model="student.student_city" type="text"
																   class="form-control" placeholder="City"
																   value="" @click="gen_form_errors.student_city = ''">
															<div class="invalid-feedback" style="display: block;">{{gen_form_errors.student_city}}</div>
														</div>
													</div>
												</div>
												<button @click="generalDataUpdate" class="btn btn-primary">Update</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>


				<div class="col-xl-12 col-lg-12 col-md-12 layout-spacing layout-top-spacing">
					<div id="general-info" class="section general-info">
						<div class="info">
							<h6 class="">Change password</h6>
							<div class="row">
								<div class="col-lg-12 mx-auto">
									<div class="row">
										<div class="col-xl-12 col-lg-12 col-md-12 mt-md-0 mt-4">
											<div class="form">
												<div class="row">
													<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
														<div class="form-group mb-4">
															<label for="oldpass">Old password</label>
															<input id="oldpass" type="password" class="form-control"
																   placeholder="Enter old password" value="" @click="pass.oldpass = ''">
															<div class="invalid-feedback" style="display: block;">{{pass.oldpass}}</div>
														</div>
													</div>
													<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
														<div class="form-group mb-4">
															<label for="newpassword">New password</label>
															<input id="newpass" type="password" class="form-control"
																   placeholder="Enter new password" value="" @click="pass.newpass = ''">
															<div class="invalid-feedback" style="display: block;">{{pass.newpass}}</div>
														</div>
													</div>
													<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
														<div class="form-group mb-4">
															<label for="reenternew">Re-Enter new password</label>
															<input id="renewpass" type="password" class="form-control"
																   placeholder="Re-Enter new password" value="" @click="pass.renewpass = ''">
															<div class="invalid-feedback" style="display: block;">{{pass.renewpass}}</div>
														</div>
													</div>
												</div>
												<button @click="updatePass" class="btn btn-primary">Change password</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
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
	$(document).ready(function () {
		App.init();
	});
</script>
<script src="<?php echo base_url() ?>files/assets/js/custom.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->


<script>

	let content = new Vue({
		el: '#content',
		data: {
			student: '',
			gen_form_errors: '',
			pass: ''
		},
		mounted() {
			this.getStudentData();
		},
		methods: {
			getStudentData() {
				axios.get('<?php echo base_url('myaccount_controller/get_userdata') ?>').then(response => {
							if (response.data.student) {
								this.student = response.data.student;
							}
						});
			},
			updatePass () {
				let formData = new FormData()
				formData.append('oldpass', document.getElementById('oldpass').value);
				formData.append('newpass', document.getElementById('newpass').value);
				formData.append('renewpass', document.getElementById('renewpass').value);

				axios({
					method: 'post',
					url: '<?php echo base_url('myaccount_controller/updatepass') ?>',
					data: formData
				}).then(response => {
					if (response.data.form_errors) {
						this.pass = response.data.form_errors;
					} else if (response.data.success === true){
						Notiflix.Notify.Success('Password is updated.');
						document.getElementById('oldpass').value = '';
						document.getElementById('newpass').value = '';
						document.getElementById('renewpass').value = '';
					} else {
						Notiflix.Notify.Failure('Password is not updated.');
					}
				}).catch(error => {
					console.log(error.response);
					Notiflix.Notify.Failure('Password is not updated.');
				});
			},
			generalDataUpdate() {
				let formData = new FormData();
				formData.append('student_id', this.student.idstudents);
				formData.append('first_name', this.student.first_name);
				formData.append('last_name', this.student.last_name);
				formData.append('phone_number', this.student.phone_number);
				formData.append('school', this.student.school);
				formData.append('student_city', this.student.student_city);

				axios({
					method: 'post',
					url: '<?php echo base_url('myaccount_controller/updateGeneralData') ?>',
					data: formData
				}).then(response => {
							if (response.data.form_errors) {
								this.gen_form_errors = response.data.form_errors;
							} else if (response.data.success === true) {
								Notiflix.Notify.Success('Your data updated.');
							} else {
								Notiflix.Notify.Failure('Data is not updated.');
							}
						}).catch(error => {
							Notiflix.Notify.Failure('Data is not updated.');
							console.log(error.response);
						})
			}
		}
	});

</script>

</body>
</html>
