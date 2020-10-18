$(document).on('submit', '#loginForm', function(event) {
    event.preventDefault();
	Notiflix.Block.Standard('#loaderBlock');
    if ($('#inputEmail').val() === "") {
        PNotify.error({
            title: 'Oh No!',
            text: 'Email is required.'
        });
    } else if ($('#inputPassword').val() === "") {
        PNotify.error({
            title: 'Oh No!',
            text: 'Password is required.'
        });
    } else {

        $.ajax({
            url: window.location.origin + '/user_controller/new_pass_get',
            type: 'POST',
            dataType: 'JSON',
            data: { inputEmail: $('#inputEmail').val(), inputPassword: $('#inputPassword').val() },
            success: function(params) {
				Notiflix.Block.Remove('#loaderBlock', 600);
                if (params.success === true) {

                    var notice = PNotify.notice({
                        title: 'Enter OTP',
                        icon: 'fas fa-question-circle',
                        hide: false,
                        textTrusted: true,
                        stack: {
                            'dir1': 'down',
                            'firstpos1': 25
                        },
                        modules: {
                            Confirm: {
                                prompt: true
                            },
                            Buttons: {
                                closer: false,
                                sticker: false
                            },
                            History: {
                                history: false
                            }
                        }
                    });

                    notice.on('pnotify.confirm', function(e) {
                        notice.cancelClose();

                        $.ajax({
                            url: window.location.origin + '/user_controller/otp_verify',
                            type: 'post',
                            dataType: 'json',
                            data: { otp: e.value },
                            success: function(res) {
                                if (res.success === false) {
                                    notice.close();
                                    PNotify.error({
                                        title: 'Oh No!',
                                        text: params.err
                                    });
                                    return false;
                                }
                                if (res.stat === false) {
                                    notice.update({
                                        text: '<span style="color:red">' + res.form_error + '</span>'
                                    })
                                } else if (res.stat === true) {
                                    notice.close();
                                    PNotify.success({
                                        title: 'Success',
                                        text: 'Password updated',
                                        delay: 1000
                                    });
                                    setTimeout(window.location.replace(window.location.origin + '/login'), 1500);
                                }
                            },
                            error: function(error) {
                                console.log(error);
                                PNotify.error({
                                    title: 'Oh No!',
                                    text: 'Something went wrong.'
                                });
                            }
                        });

                    });
                } else if (params.success === false) {
                    PNotify.error({
                        title: 'Oh No!',
                        text: params.err,
                        delay: 2500
                    });
                }
            }
        });
    }
});
