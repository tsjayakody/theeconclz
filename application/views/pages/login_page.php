<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
	<title>Login | LMS </title>
	<link rel="icon" type="image/x-icon" href="files/assets/img/90x90.jpg"/>
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
	<link href="files/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="files/assets/css/plugins.css" rel="stylesheet" type="text/css"/>
	<link href="files/assets/css/authentication/form-2.css" rel="stylesheet" type="text/css"/>
	<!-- END GLOBAL MANDATORY STYLES -->
	<link rel="stylesheet" type="text/css" href="files/assets/css/forms/theme-checkbox-radio.css">
	<link rel="stylesheet" type="text/css" href="files/assets/css/forms/switches.css">
	 <link rel="stylesheet" type="text/css" href="files/assets/css/loading.css">

	<!-- notiflix notification library css -->
	<link rel="stylesheet" type="text/css" href="files/plugins/Notiflix-2.3.2/dist/notiflix-2.3.2.min.css">

	<!-- development version, includes helpful console warnings -->
	<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

	<!-- axios jdeliver cdn -->
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
	<!-- notiflix notification library -->
	<script src="files/plugins/Notiflix-2.3.2/dist/notiflix-aio-2.3.2.min.js"></script>
</head>

<body class="form">

 <div class="loading" id="loading" style="width: 200px;display: none;" > <!--Loading&#8230; -->
        <h1  style="text-align: center;"><div class="lds-dual-ring"></div></h1>
         <h6  style="position: absolute;z-index: 2000;color: white;text-align: center; " id="loading_msg">Please wait..login your account....</h6>
 </div>

<div class="form-container outer">
	<div class="form-form">
		<div class="form-form-wrap">
			<div class="form-container">
				<div class="form-content">
					 <img src="<?php echo base_url(); ?>files/assets/img/logo.png"  alt="logo"> 
					<h1 class="">Sign In</h1>
					<p class="">Log in to your account to continue.</p>
					<form class="text-left" id="login_app" novalidate>
						<div class="form">
							<div id="username-field" class="field-wrapper input">
								<label for="phone_number">PHONE NUMBER</label>
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
									 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
									 stroke-linejoin="round" class="feather feather-user">
									<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
									<circle cx="12" cy="7" r="4"></circle>
								</svg>
								<input id="phone_number" @click="clearFieldError" name="phone_number" type="text"
									   class="form-control"
									   placeholder="e.g 0791234567">
								<div class="invalid-feedback" style="display: block">{{form_errors.phone_number}}</div>
							</div>
							<div id="password-field" class="field-wrapper input mb-2">
								<div class="d-flex justify-content-between">
									<label for="password">PASSWORD</label>
									<a href="forgot_password" class="forgot-pass-link">Forgot Password?</a>
								</div>
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
									 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
									 stroke-linejoin="round" class="feather feather-lock">
									<rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
									<path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
								</svg>
								<input id="password" @click="clearFieldError" name="password" type="password"
									   class="form-control"
									   placeholder="Password">
								<div class="invalid-feedback" style="display: block">{{form_errors.password}}</div>

								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
									 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
									 stroke-linejoin="round" id="toggle-password" class="feather feather-eye">
									<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
									<circle cx="12" cy="12" r="3"></circle>
								</svg>
							</div>
							<div class="d-sm-flex justify-content-between">
								<div class="field-wrapper">
									<button type="button" @click="submitForm" class="btn btn-primary" value="">Log
										In
									</button>
								</div>
							</div>
							<p class="signup-link">Not registered ? <a href="register">Create an account</a> | How to work <a href="http://theeconclz.com/how%20to%20work%20.html">Click here</a></p>
							
						</div>
					</form>
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
								<h5 class="modal-title">Phone number verification</h5>

								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true" @click="showVerifyModel = false">&times;</span>
								</button>
							</div>
							<div class="modal-body" id="modelBody">
								<p class="info-text">Your phone number is not verified. We sent a verification code to
									your phone number.</p>
								<div class="form-group">
									<label for="verificationCode"></label>
									<input v-on:click="clearFieldError" type="text" class="form-control"
										   id="verificationCode" value="" placeholder="Verification code">
									<div class="invalid-feedback" style="display: block">
										{{form_errors.verificationCode}}
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-success" v-on:click="verifyNumber">Verify</button>
								<button type="button" class="btn btn-secondary" @click="showVerifyModel = false">Close
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</transition>
	</div>
</div>
<!-- end of details model-->


<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="files/assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="files/bootstrap/js/popper.min.js"></script>
<script src="files/bootstrap/js/bootstrap.min.js"></script>


<!-- CREATE VUE APP -->
<script>

	var verificationModal = new Vue({
		el: '#verificationModal',
		data: {
			showVerifyModel: false,
			form_errors: {
				verificationCode: ''
			}
		},
		methods: {
			verifyNumber: (event) => {
				// create new formdata object
				let formData = new FormData();

				// set data to form data object
				formData.append('verificationCode', document.getElementById('verificationCode').value);
				document.getElementById("loading").style.display="block";

				// send axios post request
				axios({
					method: 'post',
					url: 'login_controller/phone_verify',
					data: formData,
					headers: {'Content-Type': 'multipart/form-data'}
				}).then((response) => {
					document.getElementById("loading").style.display="none";

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
						} else {
							Notiflix.Notify.Failure('Account is not verified. Please try again.');
						}
					} else {
						Notiflix.Notify.Success('Your account is activated.');
						window.location.replace('dashboard');
					}
				}).catch((error) => {
					Notiflix.Notify.Failure('Something went wrong. Try again.');
					console.log(error);
				});
			},
			clearFieldError: (event) => {
				let element = event.target;
				element.classList.remove('is-invalid');
				verificationModal.form_errors[element.id] = "";
			}
		}
	});


	var loginApp = new Vue({
		el: '#login_app',
		data: {
			form_errors: {
				phone_number: '',
				password: ''
			}
		},
		methods: {
			submitForm: () => {
				document.getElementById("loading").style.display="block";

				let email = document.getElementById('phone_number').value;
				let password = document.getElementById('password').value;

				var input_email = document.getElementById('phone_number');
				var input_password = document.getElementById('password');

				var formData = new FormData();
				formData.append('phone_number', email);
				formData.append('password', password);

				axios({
					method: 'post',
					url: 'login_controller/log_student',
					data: formData,
					headers: {'Content-Type': 'multipart/form-data'}
				}).then(function (response) {
					document.getElementById("loading").style.display="none";

					if (response.data.success === false) {

						if (response.data.form_errors) {
							loginApp.form_errors = response.data.form_errors;
							if (loginApp.form_errors["phone_number"]) {
								input_email.classList.add('is-invalid');
							} else {
								input_email.classList.remove('is-invalid');
							}
							if (loginApp.form_errors["password"]) {
								input_password.classList.add('is-invalid');
							} else {
								input_password.classList.remove('is-invalid');
							}
						} else if (response.data.not_active) {
							console.log('kkk');
							verificationModal.showVerifyModel = true;
						}

					} else {
						loginApp.form_errors = {phone_number: "", password: ""};
						for (let item of document.getElementsByClassName('form-control')) {
							item.classList.remove('is-invalid');
						}
						window.location.replace('dashboard');
					}
				}).catch(function (error) {
					Notiflix.Report.Failure('Oops!', 'It looks like server failure. Please try again.', 'OK');
					console.log(error);
				});
			},
			clearFieldError: (event) => {
				let element = event.target;
				element.classList.remove('is-invalid');
				if (element.id == "phone_number") {
					loginApp.form_errors.email = "";
				}
				if (element.id == "password") {
					loginApp.form_errors.password = "";
				}
			}
		},
		mounted: () => {
			let togglePassword = document.getElementById('toggle-password');
			togglePassword.addEventListener('click', function () {
				let x = document.getElementById("password");
				if (x.type === "password") {
					x.type = "text";
				} else {
					x.type = "password";
				}
			});
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

</body>

</html>
