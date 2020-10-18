$(document).on('submit','#loginForm',function(e){
    e.preventDefault();
    let password = document.getElementById('inputPassword').value;
    let email = document.getElementById('inputEmail').value;
    let endpoint = document.getElementById('baseUrl').value+'user_controller/user_login';

	Notiflix.Block.Standard('#cardBlock');
    $.ajax({
        url:endpoint,
        type:'post',
        dataType:'json',
        data:{
            email:email,
            password:password
        },
        success:function (response) {
			Notiflix.Block.Remove('#cardBlock', 600);
            if (response.form_err) {
                let form_err = response.form_err;
                if (form_err.email != "") {
                    PNotify.error({
                        title: 'Oh No!',
                        text: form_err.email,
                        delay: 2500
                    });
                }
                if (form_err.password != "") {
                    PNotify.error({
                        title: 'Oh No!',
                        text: form_err.password,
                        delay: 2500
                    });
                }
            } else if (response == true) {
                PNotify.success({
                    title: 'Success!',
                    text: 'Now you will redirected to the admin panel.'
                });
                setTimeout(function(){ document.location.reload(); }, 3000);
            }
        },
        error: function (err) {
			Notiflix.Block.Remove('#cardBlock', 600);
            console.log(err);
            PNotify.error({
                title: 'Oh No!',
                text: 'Something terrible happened.'
            });
        } 
    });
});

