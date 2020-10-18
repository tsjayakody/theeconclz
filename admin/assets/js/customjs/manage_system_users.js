let $baseurl = document.getElementById('baseurl').value;
$(document).ready(function() {
    $('#locationSelect').selectpicker();
    $('#typeSelect').selectpicker();
    loadMainTable();
    get_user_types();
});

function loadMainTable() {
    $('#year_table').DataTable({
        "destroy": true,
        "ajax": $baseurl+"user_controller/get_user_management_table",
        "columns": [
            {"data": "no"},
            {"data": "name"},
            {"data": "contact"},
            {"data": "email"},
            {"data": "userType"},
            {"data": "createDate"},
            {"data": "action"},
        ]
    });
}

function get_user_types() {
    $.ajax({
        url: $baseurl+'user_controller/get_user_types',
        dataType: 'json',
        type: 'post',
        success: function(params) {
            if(params !== false) {
                let html = '<option disabled selected >User Type</option>';
                Array.from(params.userTypes).map(row => {
                    html = html + '<option value="'+row.typeid+'">'+row.typename+'</option>';
                });
                $("#typeSelect").html(html).selectpicker('refresh');
            } else if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            }
        }
    });
}

$(document).on('submit','#createUser',function(e) {

    e.preventDefault();
    const $funSel = $('#functionSelector').val();
    if ($funSel === 'create') {
        const $fname = $('#firstName').val();
        const $lname = $('#lastName').val();
        const $contact = $('#contactNumber').val();
        const $email = $('#emailAddress').val();
        const $password = $('#password').val();
        const $type = $('#typeSelect').val();

        if ($type === null) {
            PNotify.error({
                title: 'Oh No!',
                text: 'You cannot leave user type empty!'
            });
            return false;
        } else {
			Notiflix.Block.Standard('#loader1');
            $.ajax({
                url: $(this).attr('action'),
                type: 'post',
                dataType: 'json',
                data: {
                    first_name : $fname,
                    last_name : $lname,
                    contact_number : $contact,
                    email_address : $email,
                    password : $password,
                    type : $type
                },
                success: function (response) {
					Notiflix.Block.Remove('#loader1', 600);
                    if (response.err) {
                        PNotify.error({
                            title: 'Oh No!',
                            text: response.err
                        });
                    } else if (response === true) {
                        PNotify.success({
                            title: 'Success!',
                            text: 'System user created.'
                        });
                        $('#resetForm').click();
                    }
                    if (response.form_err) {
                        document.getElementById('firstName-error').innerHTML = "";
                        document.getElementById('firstName-error').innerHTML = response.form_err.first_name;
                        document.getElementById('lastName-error').innerHTML = "";
                        document.getElementById('lastName-error').innerHTML = response.form_err.last_name;
                        document.getElementById('contactNumber-error').innerHTML = "";
                        document.getElementById('contactNumber-error').innerHTML = response.form_err.contact_number;
                        document.getElementById('emailAddress-error').innerHTML = "";
                        document.getElementById('emailAddress-error').innerHTML = response.form_err.email_address;
                        document.getElementById('password-error').innerHTML = "";
                        document.getElementById('password-error').innerHTML = response.form_err.password;
                    }
                },
                error: function(error) {
					Notiflix.Block.Remove('#loader1', 600);
                    PNotify.error({
                        title: 'Oh No!',
                        text: 'Something went wrong!'
                    });
                    console.log(error);
                },
                complete: function () {
                    loadMainTable();
                }
            });
        }
    } else if ($funSel === 'update'){
        const $fname = $('#firstName').val();
        const $lname = $('#lastName').val();
        const $contact = $('#contactNumber').val();
        const $email = $('#emailAddress').val();
        const $password = $('#password').val();
        const $type = $('#typeSelect').val();

        if ($type === null) {
            PNotify.error({
                title: 'Oh No!',
                text: 'You cannot leave user type empty!'
            });
            return false;
        } else {
			Notiflix.Block.Standard('#loader1');
            $.ajax({
                url: $baseurl+'user_controller/update_user',
                type: 'post',
                dataType: 'json',
                data: {
                    first_name : $fname,
                    last_name : $lname,
                    contact_number : $contact,
                    email_address : $email,
                    password : $password,
                    type : $type,
                    id : $(this).attr('data-id')
                },
                success: function (response) {
					Notiflix.Block.Remove('#loader1', 600);
                    if (response.err) {
                        PNotify.error({
                            title: 'Oh No!',
                            text: response.err
                        });
                    } else if (response === true) {
                        PNotify.success({
                            title: 'Success!',
                            text: 'System user updated.'
                        });
                        $('#resetForm').click();
                        location.reload();
                    }
                    if (response.form_err) {
                        document.getElementById('firstName-error').innerHTML = "";
                        document.getElementById('firstName-error').innerHTML = response.form_err.first_name;
                        document.getElementById('lastName-error').innerHTML = "";
                        document.getElementById('lastName-error').innerHTML = response.form_err.last_name;
                        document.getElementById('contactNumber-error').innerHTML = "";
                        document.getElementById('contactNumber-error').innerHTML = response.form_err.contact_number;
                        document.getElementById('emailAddress-error').innerHTML = "";
                        document.getElementById('emailAddress-error').innerHTML = response.form_err.email_address;
                        document.getElementById('password-error').innerHTML = "";
                        document.getElementById('password-error').innerHTML = response.form_err.password;
                    }
                },
                error: function(error) {
					Notiflix.Block.Remove('#loader1', 600);
                    PNotify.error({
                        title: 'Oh No!',
                        text: 'Something went wrong!'
                    });
                    console.log(error);
                },
                complete: function () {
                    loadMainTable();
                }
            });
        }
    }
});

$(document).on('click','.remove',function(){
    const $userid = $(this).attr('data-id');
    $.ajax({
        url: $baseurl+'user_controller/delete_user',
        dataType: 'json',
        type: 'post',
        data: {
            user_id:$userid
        },
        success: function(response){
            if (response.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            } else if (response === true) {
                PNotify.success({
                    title: 'Success!',
                    text: 'System user deleted.'
                });
            }
        },
        error: function(error) {
            PNotify.error({
                title: 'Oh No!',
                text: 'You can not delete this because of dependancies.'
            });
            console.log(error);
        },
        complete: function() {
            loadMainTable();
        }
    })
});

$(document).on('click','.edit',function(){
    const $userid = $(this).attr('data-id');
	Notiflix.Block.Standard('#loader1');
    $.ajax({
        url: $baseurl+'user_controller/get_user',
        type: 'post',
        dataType: 'json',
        data: {user_id:$userid},
        success: function(response) {
			Notiflix.Block.Remove('#loader1', 600);
            if (response.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            } else if (response.success === true) {
                const $user = response.user;
                $('#firstName').val($user.first_name).parent().addClass('is-filled');
                $('#lastName').val($user.last_name).parent().addClass('is-filled');
                $('#contactNumber').val($user.contact_number).parent().addClass('is-filled');
                $('#emailAddress').val($user.email_address).parent().addClass('is-filled');
                $('#typeSelect').val($user.user_type);
                $('.selectpicker').selectpicker('refresh');
                $('#functionSelector').val('update');
                $('#createUser').attr('data-id',$userid);
                if (!$('#formButtons button[type="button"]')[0]) {
					$("#formButtons").append('<button type="button" class="btn btn-primary" onclick="location.reload();">Cancel</button>');
				}
                $('button[type="submit"]').text('Update');
            }
        },
        error: function(error) {
			Notiflix.Block.Remove('#loader1', 600);
            PNotify.error({
                title: 'Oh No!',
                text: 'Something went wrong!'
            });
            console.log(error);
        }
    })
});

$(document).on("click", ".form-control", function(event) {
	var element = $(this);
	var errorElem = "#" + $(element).attr("id") + "-error";
	if ($(errorElem).text() !== "") {
		$(errorElem).text('');
	}
});
