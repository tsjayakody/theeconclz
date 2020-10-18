<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Register | LMS </title>
    <link rel="icon" type="image/x-icon" href="files/assets/img/90x90.jpg" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="files/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="files/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="files/assets/css/authentication/form-2.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="files/assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="files/assets/css/forms/switches.css">

    <!-- notiflix notification library css -->
    <link rel="stylesheet" type="text/css" href="files/plugins/Notiflix-2.3.2/dist/notiflix-2.3.2.min.css">
    <link rel="stylesheet" type="text/css" href="files/assets/css/loading.css">

    <style type="text/css">

    </style>
</head>

<body class="form" >

    <div class="loading" id="loading" style="width: 300px;display: none;" > <!--Loading&#8230; -->
        <h1  style="text-align: center;"><div class="lds-dual-ring"></div></h1>
         <h6  style="position: absolute;z-index: 2000;color: white;text-align: center; " id="loading_msg"></h6>
    </div>
   


    <div class="form-container outer" >
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content" id="register_app">

                       <!-- <div class="lds-dual-ring"></div>-->

                        <h1 class="">Register</h1>
                        <p class="signup-link register">Already have an account? <a href="login">Log in</a></p>
                        <form class="text-left">
                            <div class="form">

                                <div id="fname-field" class="field-wrapper input">
                                    <label for="first_name">FIRST NAME</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <input @click="clearFieldError" id="first_name" name="first_name" type="text" class="form-control"
                                        placeholder="First name">
                                    <div class="invalid-feedback"
                                        style="display: block">{{form_errors.first_name}}</div>
                                </div>

                                <div id="lname-field" class="field-wrapper input">
                                    <label for="last_name">LAST NAME</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <input @click="clearFieldError" id="last_name" name="last_name" type="text" class="form-control"
                                        placeholder="Last name">
                                    <div class="invalid-feedback"
                                        style="display: block">{{form_errors.last_name}}</div>
                                </div>

                                <div id="contact-field" class="field-wrapper input">
                                    <label for="contact">PHONE NUMBER</label>

									<svg style="top: 53px;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                    <input @click="clearFieldError" id="phone_number" name="phone_number" type="number" class="form-control"
                                        placeholder="Phone number">
                                    <div class="invalid-feedback"
                                        style="display: block">{{form_errors.phone_number}}</div>
                                </div>

                                <div id="email-field" class="field-wrapper input">
                                    <label for="email">EMAIL</label>
									<svg style="top: 53px;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign"><circle cx="12" cy="12" r="4"></circle><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path></svg>
                                    <input @click="clearFieldError" id="email" name="email" type="text" class="form-control" placeholder="Email">
                                    <div class="invalid-feedback"
                                        style="display: block">{{form_errors.email}}</div>
                                </div>

								<div id="school-field" class="field-wrapper input">
									<label for="school">SCHOOL</label>
									<svg style="top: 53px;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
									<input @click="clearFieldError" id="school" name="school" type="text" class="form-control" placeholder="School">
									<div class="invalid-feedback"
										 style="display: block">{{form_errors.school}}</div>
								</div>

                                <div id="school-field2" class="field-wrapper input">
                                    <label for="school">EXAM YEAR</label>
                                   
                                    <select  id="al_year" name="al_year"  class="form-control">
                                        <option selected value="">Please select exam year</option>
                                    <?php
                                        $data = $this->db->get('exam_year');
                                        if ($data->num_rows() > 0) {
                                            foreach ($data->result_array() as $key => $value) {
                                                echo '<option value="'.$value['id_exam_year'].'">'.$value['years'].'</option>';
                                            }
                                        }
                                    ?>
                                    </select>
                                    <div class="invalid-feedback"
                                         style="display: block">{{form_errors.al_year}}</div>
                                </div>

                                <div id="student-city-field2" class="field-wrapper input">
                                    <label for="student_city">BARCODE NUMBER</label>

                                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>

                                    <input @click="clearFieldError" id="card_number" name="card_number" type="text" class="form-control" placeholder="Barcode Number">
                                    <p>If you already student of Mr.Aasel Mallikarathne class,please enter barcode number</p>
                                   <!-- <div class="invalid-feedback"
                                         style="display: block">{{form_errors.student_city}}</div>-->
                                </div>

								<div id="student-city-field" class="field-wrapper input">
									<label for="student_city">CITY</label>
									<svg style="top: 53px;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
									<input @click="clearFieldError" id="student_city" name="student_city" type="text" class="form-control" placeholder="City">
									<div class="invalid-feedback"
										 style="display: block">{{form_errors.student_city}}</div>
								</div>

                                <div id="password-field" class="field-wrapper input mb-2">
                                    <label for="password">PASSWORD</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-lock">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                    <input @click="clearFieldError" id="password" name="password" type="password" class="form-control"
                                        placeholder="Password">
                                    <div class="invalid-feedback"
                                        style="display: block">{{form_errors.password}}</div>
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
										 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
										 stroke-linejoin="round" id="toggle-password" class="feather feather-eye">
										<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
										<circle cx="12" cy="12" r="3"></circle>
									</svg>
                                </div>

                                <div id="password-retype-field" class="field-wrapper input mb-2">
                                    <label for="con_password">RETYPE PASSWORD</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-lock">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                    <input @click="clearFieldError" id="con_password" name="con_password" type="password"
                                        class="form-control" placeholder="Password retype">
                                    <div class="invalid-feedback"
                                        style="display: block">{{form_errors.con_password}}</div>
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
										 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
										 stroke-linejoin="round" id="toggle-password-con" class="feather feather-eye">
										<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
										<circle cx="12" cy="12" r="3"></circle>
									</svg>
                                </div>

                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper">
                                        <button type="button" @click="submitForm" class="btn btn-primary" value="">Get
                                            Started!</button>
                                           
                                    </div>
                                </div>
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
								<div class="form-group">
									<label for="verificationCode"></label>
									<input v-on:click="clearFieldError" type="text" class="form-control" id="verificationCode" value="" placeholder="Verification code">
									<div class="invalid-feedback" style="display: block">{{form_errors.verificationCode}}</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-success" v-on:click="verifyNumber">Verify</button>
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


    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="files/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="files/bootstrap/js/popper.min.js"></script>
    <script src="files/bootstrap/js/bootstrap.min.js"></script>

    <!-- development version, includes helpful console warnings -->
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

    <!-- axios jdeliver cdn -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- notiflix notification library -->
    <script src="files/plugins/Notiflix-2.3.2/dist/notiflix-aio-2.3.2.min.js"></script>

    <!-- Create new vue app -->
    <script>

       
        var registerApp = new Vue({
            el: '#register_app',
            data: {
                form_errors: {
                    first_name: '',
                    last_name: '',
                    email: '',
                    phone_number: '',
                    password: '',
                    con_password: '',
					school: '',
					student_city: '',
                    al_year: '',
                    card_number: ''
                },
				showVerifyModel: false
            },
            methods: {
                submitForm: () => {
                    
                    // create new formdata object
                    let formData = new FormData();

                    // set data to form data object
                    formData.append('first_name', document.getElementById('first_name').value);
                    formData.append('last_name', document.getElementById('last_name').value);
                    formData.append('email', document.getElementById('email').value);
                    formData.append('phone_number', document.getElementById('phone_number').value);
                    formData.append('password', document.getElementById('password').value);
                    formData.append('con_password', document.getElementById('con_password').value);
					formData.append('school', document.getElementById('school').value);
					formData.append('student_city', document.getElementById('student_city').value);
                    formData.append('al_year', document.getElementById('al_year').value);
                    formData.append('card_number', document.getElementById('card_number').value);

                    var stc=document.getElementById('card_number').value;
                    if(stc==""){
                        document.getElementById("loading_msg").innerHTML="Please wait..your personal data verifing....";
                    }else{
                        document.getElementById("loading_msg").innerHTML="Please wait..your personal data and student ID verifing....";
                    }

                    document.getElementById("loading").style.display="block";


                    // send axios post request
                    axios({
                        method: 'post',
                        url: 'login_controller/register_student',
                        data: formData,
                        headers: { 'Content-Type': 'multipart/form-data' }
                    }).then((response) => {
                         document.getElementById("loading").style.display="none";
                        if (response.data.success === false) {
                            if (response.data.form_errors) {
                                registerApp.form_errors = response.data.form_errors;
                                for (const key in registerApp.form_errors) {
                                    if (registerApp.form_errors.hasOwnProperty(key)) {
                                        const element = registerApp.form_errors[key];
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
								Notiflix.Notify.Failure('Account is not created. Please try again.');
							}
                        } else {
                            Notiflix.Notify.Success('Account created. Please verify your account with code which is sent to your phone number.');
                            verificationModal.showVerifyModel = true;
                        }
                    }).catch((error) => {
                        Notiflix.Notify.Failure('Something went wrong. Try again.');
                        console.log(error);
                    });
                },
                clearFieldError: (event) => {
                    let element = event.target;
                    element.classList.remove('is-invalid');
                    registerApp.form_errors[element.id] = "";
                }
            },
			mounted: () => {
				let togglePassword = document.getElementById('toggle-password');
				let togglePasswordCon = document.getElementById('toggle-password-con');
				togglePassword.addEventListener('click', function() {
					let x = document.getElementById("password");
					if (x.type === "password") {
						x.type = "text";
					} else {
						x.type = "password";
					}
				});
				togglePasswordCon.addEventListener('click', function() {
					let x = document.getElementById("con_password");
					if (x.type === "password") {
						x.type = "text";
					} else {
						x.type = "password";
					}
				});
			}
        });


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

					// send axios post request
					axios({
						method: 'post',
						url: 'login_controller/phone_verify',
						data: formData,
						headers: { 'Content-Type': 'multipart/form-data' }
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
							} else {
								Notiflix.Notify.Failure('Account is not verified. Please try again.');
							}
						} else {
							window.location.replace('login');
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
