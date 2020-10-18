<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Password Recovery | LMS </title>
    <link rel="icon" type="image/x-icon" href="<?php echo base_url() ?>files/assets/img/90x90.jpg" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="<?php echo base_url() ?>files/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>files/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>files/assets/css/authentication/form-2.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>files/assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>files/assets/css/forms/switches.css">
</head>

<body class="form no-image-content">


    <div class="form-container outer" id="reset_password">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">

                        <h1 class="">Password Recovery</h1>
                        <p class="signup-link recovery">Enter your email and instructions will sent to you!</p>
                        <form class="text-left">
                            <div class="form">

                                <div id="email-field" class="field-wrapper input">
                                    <div class="d-flex justify-content-between">
                                        <label for="phone_number">PHONE NUMBER</label>
                                    </div>


									<svg xmlns="http://www.w3.org/2000/svg" style="top: 47px" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                    <input @click="clearFieldError" id="phone_number" name="phone_number" type="text" class="form-control" value=""
                                        placeholder="Phone Number">
                                    <div class="invalid-feedback" style="display: block">{{form_errors.phone_number}}</div>
                                </div>

                                <div class="d-sm-flex justify-content-between">

                                    <div class="field-wrapper">
                                        <button type="button" @click="submitForm" class="btn btn-primary" value="">Reset</button>
                                    </div>
                                </div>
                                <p style="display: block;" class="signup-link">Go to <a href="http://www.theeconclz.com/">Home page</a> or <a href="<?php echo base_url() ?>login">Login page</a></p>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="<?php echo base_url() ?>files/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url() ?>files/bootstrap/js/popper.min.js"></script>
    <script src="<?php echo base_url() ?>files/bootstrap/js/bootstrap.min.js"></script>

    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="<?php echo base_url() ?>files/assets/js/authentication/form-2.js"></script>
    <!-- development version, includes helpful console warnings -->
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

    <!-- axios jdeliver cdn -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- notiflix notification library -->
    <script src="<?php echo base_url() ?>files/plugins/Notiflix-2.3.2/dist/notiflix-aio-2.3.2.min.js"></script>
    <!-- CREATE VUE APP -->
    <script>
        var resetPasswordApp = new Vue({
            el: '#reset_password',
            data: {
                form_errors: {
                    phone_number: ''
                }
            },
            methods: {
                submitForm: () => {
                    // INPUT EMAIL ELEMENT
                    var input_email = document.getElementById('phone_number');

                    // CREATE FORM DATA
                    var formData = new FormData();
                    formData.append('phone_number', input_email.value);

                    // LOADING BLOCK FOR FORM
                    Notiflix.Block.Pulse('.form-content');

                    axios({
                        method: 'post',
                        url: 'login_controller/send_temp_password',
                        data: formData,
                        headers: { 'Content-Type': 'multipart/form-data' }
                    }).then(function (response) {
                        Notiflix.Block.Remove('.form-content');
                        if (response.data.success === false) {
                            resetPasswordApp.form_errors = response.data.form_errors;
                            if (resetPasswordApp.form_errors["phone_number"]) {
                                input_email.classList.add('is-invalid');
                            } else {
                                input_email.classList.remove('is-invalid');
                            }
                            if (response.data.error_alert) {
                                Notiflix.Report.Failure('Oops!', response.data.error_alert, 'OK');
                            }
                        } else {
                            resetPasswordApp.form_errors = { phone_number: "" };
                            for (let item of document.getElementsByClassName('form-control')) {
                                item.classList.remove('is-invalid');
                            }
                            Notiflix.Notify.Success('Temporary password sent to phone.');
                        }
                    }).catch(function (error) {
                        Notiflix.Block.Remove('.form-content');
                        Notiflix.Notify.Failure('Ooops! Something went wrong!');
                        console.log(error);
                    });
                },
                clearFieldError: (event) => {
                    let element = event.target;
                    element.classList.remove('is-invalid');
                    if (element.id == "phone_number") {
                        resetPasswordApp.form_errors.phone_number = "";
                    }
                }
            }
        });
    </script>

</body>
</html>
