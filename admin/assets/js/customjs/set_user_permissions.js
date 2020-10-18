let $baseurl = document.getElementById('baseurl').value;
$(document).ready(function() {
    $('#userSelect').selectpicker();
    $('#menu_table').dataTable();
    $('#permission_table').dataTable();
    load_user_select();
});

function load_user_select() {
    $.ajax({
        url: $baseurl + 'user_controller/get_user_for_set_permissions',
        dataType: 'json',
        type: 'post',
        success: function(params) {
            if (params !== false) {
                let html = '<option disabled selected >Select User</option>';
                Array.from(params.userData).map(row => {
                    html = html + '<option value="' + row.userid + '">' + row.userName +'</option>';
                });
                $("#userSelect").html(html).selectpicker('refresh');
            } else if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            }
        }
    });
}

function load_menu_table(id) {
    $('#menu_table').DataTable({
        "destroy": true,
        "ajax": {
            "url": $baseurl + "user_controller/get_user_menu_table",
            "type": "POST",
            "data": { userid: id }
        },
        "columns": [
            { "data": "no" },
            { "data": "view" },
            { "data": "action" },
            { "data": "permissions" }
        ]
    });
}

$(document).on('click','.edit',function () {
    $user_id = $(this).attr('data-userId');
    $sub_id = $(this).attr('data-smid');

    load_permission_table($user_id,$sub_id);
});

function load_permission_table(userid,subid) {
    $('#permission_table').DataTable({
        "destroy": true,
        "ajax": {
            "url": $baseurl + "user_controller/get_user_permission_table",
            "type": "POST",
            "data": { user_id : userid,  sub_menu : subid}
        },
        "columns": [
            { "data": "no" },
            { "data": "permission" },
            { "data": "action" }
        ]
    });
}

$('#userSelect').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
    const $userid = $(this).find('option').eq(clickedIndex).val();
    load_menu_table($userid);
});


$(document).on('change', '[name="submenu"]', function() {
    var checkbox = $(this);
    const $user = checkbox.attr('data-userid');
    const $submenu = checkbox.attr('data-smid');

    if (checkbox.is(':checked')) {
        $.ajax({
            url: $baseurl + 'user_controller/insert_menu',
            type: 'post',
            dataType: 'json',
            data: { userid: $user, subid: $submenu },
            success: function(params) {
                if (params === true) {
                    load_menu_table($user);
                } else {
                    PNotify.error({
                        title: 'Oh No!',
                        text: 'Menu is not inserted!'
                    });
                    load_menu_table($user);
                }
            },
            error: function(error) {
                console.log(error);
                PNotify.error({
                    title: 'Oh No!',
                    text: 'Something went wrong!'
                });
                load_menu_table($user);
            }
        });

    } else {
        $.ajax({
            url: $baseurl + 'user_controller/remove_menu',
            type: 'post',
            dataType: 'json',
            data: { userid: $user, subid: $submenu },
            success: function(params) {
                if (params === true) {
                    load_menu_table($user);
                } else {
                    PNotify.error({
                        title: 'Oh No!',
                        text: 'Menu is not removed!'
                    });
                    load_menu_table($user);
                }
            },
            error: function(error) {
                console.log(error);
                PNotify.error({
                    title: 'Oh No!',
                    text: 'Something went wrong!'
                });
                load_menu_table($user);
            }
        });
    }
});


$(document).on('change', '[name="permission"]', function() {
    var checkbox = $(this);
    const $user = checkbox.attr('data-userid');
    const $permission = checkbox.attr('data-permid');
    const $subid = checkbox.attr('data-subid');

    if (checkbox.is(':checked')) {
        $.ajax({
            url: $baseurl + 'user_controller/set_permission',
            type: 'post',
            dataType: 'json',
            data: { userid: $user, permid: $permission },
            success: function(params) {
                if (params === true) {
                    load_permission_table($user,$subid);
                } else {
                    PNotify.error({
                        title: 'Oh No!',
                        text: 'Permission is not created!'
                    });
                    load_permission_table($user,$subid);
                }
            },
            error: function(error) {
                console.log(error);
                PNotify.error({
                    title: 'Oh No!',
                    text: 'Something went wrong!'
                });
                load_permission_table($user,$subid);
            }
        });

    } else {
        $.ajax({
            url: $baseurl + 'user_controller/remove_permission',
            type: 'post',
            dataType: 'json',
            data: { userid: $user, permid: $permission },
            success: function(params) {
                if (params === true) {
                    load_permission_table($user,$subid);
                } else {
                    PNotify.error({
                        title: 'Oh No!',
                        text: 'Permission is not removed!'
                    });
                    load_permission_table($user,$subid);
                }
            },
            error: function(error) {
                console.log(error);
                PNotify.error({
                    title: 'Oh No!',
                    text: 'Something went wrong!'
                });
                load_permission_table($user,$subid);
            }
        });
    }
});