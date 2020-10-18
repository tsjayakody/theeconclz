<?php

class User_controller extends CI_Controller {

    public function user_login(){
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE) {
            echo (json_encode(array('form_err'=>array('email'=>form_error('email'),'password'=>form_error('password')))));
        } else {
            $stat = $this->user_model->log_user($_POST['email'], $_POST['password']);
            if($stat) {
                echo json_encode($stat);
            } else {
                echo json_encode($stat);
            }
        }
    }

    public function get_user_management_table() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vmsu');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $user_data = $this->user_model->get_user_data('all');
        $data['data'] = array();
        if($user_data->num_rows() > 0) {
            foreach ($user_data->result_array() as $key => $value) {
                $data['data'][] = array(
                    'no'=>$key,
                    'name'=>$value['first_name'].' '.$value['last_name'],
                    'contact'=>$value['contact_no'],
                    'email'=>$value['email'],
                    'userType'=>$value['l_types'],
                    'createDate'=>$value['date'],
                    'action'=>' <a data-id="'.$value['iduser'].'" class="btn pull-right btn-link btn-warning btn-just-icon edit"><i class="material-icons">edit</i></a>
                                <a data-id="'.$value['iduser'].'" class="btn pull-right btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a>'
                );
            }
        }
        echo json_encode($data);
    }

    // function for get class locations
    public function get_user_types() {
        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vmsu');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }
        
        $user_types = $this->user_model->get_user_types();
        if ($user_types->num_rows() > 0) {
            foreach ($user_types->result_array() as $key => $value) {
                $usertypes['userTypes'][] = array(
                    'typeid' => $value['idlogin_type'],
                    'typename' => $value['l_types']
                );
            }
            echo json_encode($usertypes);
        } else {
            echo json_encode(false);
        }
    }

    // function for create user
    public function create_user() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('csu');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'required|exact_length[10]');
        $this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
        if ($this->form_validation->run() == FALSE) {
            echo (json_encode(array('form_err'=>array(
                'first_name'=>form_error('first_name'),
                'last_name'=>form_error('last_name'),
                'contact_number'=>form_error('contact_number'),
                'email_address'=>form_error('email_address'),
                'password'=>form_error('password')
            ))));
        } else {
            $user_data = array(
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'contact_no' => $_POST['contact_number'],
                'email' => $_POST['email_address'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'login_type_idlogin_type' => $_POST['type']
            );
            $stat = $this->user_model->create_user($user_data);
            if($stat) {
                echo json_encode(true);
            } else {
                echo json_encode(array('err'=>'User not created due to server error!'));
            }
        }

    }

    // function for update user
    public function update_user() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('dusu');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'required|exact_length[10]');
        $this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|greater_than_equal_to[8]');
        if ($this->form_validation->run() == FALSE) {
            echo (json_encode(array('form_err'=>array(
                'first_name'=>form_error('first_name'),
                'last_name'=>form_error('last_name'),
                'contact_number'=>form_error('contact_number'),
                'email_address'=>form_error('email_address'),
                'password'=>form_error('password')
            ))));
        } else {
            $user_data = array(
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'contact_no' => $_POST['contact_number'],
                'email' => $_POST['email_address'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'login_type_idlogin_type' => $_POST['type']
            );
            $stat = $this->user_model->update_user($user_data,$_POST['id']);
            if($stat) {
                echo json_encode(true);
            } else {
                echo json_encode(array('err'=>'User not updated due to server error!'));
            }
        }
    }

    //function for delete user
    public function delete_user(){

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('dusu');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $user_id = $_POST['user_id'];
        $stat = $this->user_model->delete_user($user_id);
        if($stat) {
            echo json_encode(true);
        } else {
            echo json_encode(array('err'=>'User not deleted due to server error!'));
        }
    }

    //function for get user data to update user
    public function get_user(){

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('dusu');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $user_id = $_POST['user_id'];
        $stat = $this->user_model->get_user_data($user_id);
        if($stat->num_rows() > 0) {
            $user = $stat->row();
            $data = array(
                'success' => true,
                'user' => array(
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'contact_number' => $user->contact_no,
                    'email_address' => $user->email,
                    'user_type' => $user->login_type_idlogin_type
                )
            );
            echo json_encode($data);
        } else {
            echo json_encode(array('err'=>'User not found!'));
        }
    }


    // function for get user for set permisions user select
    public function get_user_for_set_permissions() {
        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vsup');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $users = $this->user_model->get_user_data('all');
        if ($users->num_rows() > 0) {
            foreach ($users->result_array() as $key => $value) {
                if ($value['l_types'] !== 'admin') {
                    $data['userData'][] = array(
                        'userid' => $value['iduser'],
                        'userName' => $value['first_name'].' '.$value['last_name']
                    );
                }
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }
    }



    // function for get user menu for set user permissions
    public function get_user_menu_table() {
        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vsup');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $data['data'] = array();
        $user_id = $_POST['userid'];

        $this->load->model('system_model');
        $sub_menus = $this->system_model->get_sub_menus();

        if ($sub_menus->num_rows() > 0) {
            foreach ($sub_menus->result_array() as $key => $value) {
                $user_menu_record = $this->user_model->get_user_allowed_view_by_id($user_id,$value['idsub_menu']);
                if ($user_menu_record->num_rows() > 0) {
                    $data['data'][] = array(
                        'no' => $key,
                        'view' => $value['sub_menu_title'],
                        'action' => '<div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" name="submenu" type="checkbox" value="" data-userid="'.$user_id.'" data-smid="'.$value['idsub_menu'].'" checked>
                                            <span class="form-check-sign">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>',
                        'permissions' => '<a data-userId="'.$user_id.'" data-smid="'.$value['idsub_menu'].'" class="btn pull-right btn-link btn-warning btn-just-icon edit"><i class="material-icons">edit</i></a>'
                    );
                } else {
                    $data['data'][] = array(
                        'no' => $key,
                        'view' => $value['sub_menu_title'],
                        'action' => '<div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" name="submenu" type="checkbox" data-userid="'.$user_id.'" data-smid="'.$value['idsub_menu'].'" value="">
                                            <span class="form-check-sign">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>',
                        'permissions' => '<a data-userId="'.$user_id.'" data-smid="'.$value['idsub_menu'].'" class="btn pull-right btn-link btn-warning btn-just-icon edit"><i class="material-icons">edit</i></a>'
                    );
                }
            }
            echo json_encode($data);
        } else {
            echo json_encode($data);
        }
    }


    // function for get user permissions for set user permissions
    public function get_user_permission_table() {
        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vsup');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $data['data'] = array();
        $user_id = $_POST['user_id'];
        $sub_menu_id = $_POST['sub_menu'];

        $this->load->model('system_model');
        $system_permissions = $this->system_model->get_system_permissions_by_id($sub_menu_id);

        if ($system_permissions->num_rows() > 0) {
            foreach ($system_permissions->result_array() as $key => $value) {
                $user_permission_record = $this->user_model->get_user_allowed_permission_by_id($user_id,$value['idaccess_permissions']);
                if ($user_permission_record->num_rows() > 0) {
                    $data['data'][] = array(
                        'no' => $key,
                        'permission' => $value['title'],
                        'action' => '<div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" name="permission" type="checkbox" value="" data-userid="'.$user_id.'" data-permid="'.$value['idaccess_permissions'].'" data-subid="'.$value['sub_menu_idsub_menu'].'" checked>
                                            <span class="form-check-sign">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>'
                    );
                } else {
                    $data['data'][] = array(
                        'no' => $key,
                        'permission' => $value['title'],
                        'action' => '<div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" name="permission" type="checkbox" data-userid="'.$user_id.'" data-permid="'.$value['idaccess_permissions'].'" data-subid="'.$value['sub_menu_idsub_menu'].'" value="">
                                            <span class="form-check-sign">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>'
                    );
                }
            }
            echo json_encode($data);
        } else {
            echo json_encode($data);
        }
    }


    // insert menu for user
    public function insert_menu() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('cup');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $user_id = $_POST['userid'];
        $sub_menu = $_POST['subid'];

        $res = $this->user_model->insert_user_menu($user_id,$sub_menu);
        if($res) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    // remove menu from user
    public function remove_menu() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('cup');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $user_id = $_POST['userid'];
        $sub_menu = $_POST['subid'];

        $res = $this->user_model->remove_user_menu($user_id,$sub_menu);
        if($res) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

    }

    // set permission for user
    public function set_permission() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('cup');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $user_id = $_POST['userid'];
        $permission = $_POST['permid'];

        $res = $this->user_model->set_permission($user_id,$permission);
        if($res) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

    }

    // set permission for user
    public function remove_permission() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('cup');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $user_id = $_POST['userid'];
        $permission = $_POST['permid'];

        $res = $this->user_model->remove_permission($user_id,$permission);
        if($res) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

    }

    // user logout
    public function logout () {
        $this->session->sess_destroy();
        redirect('/login');
    }
    


    // view for forgot password
    public function forgot_password () {
        $this->load->view('forgot_password');
    }


    // function for get values from password reset form and validate
	public function new_pass_get() {
    	$email = $_POST['inputEmail'];
    	$newpass = $_POST['inputPassword'];

        $user = $this->db->select('*')->from('user')->where('email',$email)->get();
        if ($user->num_rows() <= 0) {
            exit(json_encode(array('success'=>false, 'err'=>'Email is not exist in system!')));
        }

        $otp = mt_rand(10000,99999);

        $username = 'theeconclz';
        $password = 'Tec86eCZ';
        $phone_number = $user->row()->contact_no;

        $curl = curl_init();
    	curl_setopt_array(
    		$curl,
			array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => 'https://sms.textware.lk:5001/sms/send_sms.php?username='.$username.'&password='.$password.'&src=TheEconClz&dst='.$phone_number.'&msg=Econ%20LMS%20System%20OTP:%20'.$otp.'&dr=1',
				CURLOPT_HTTPHEADER => array("Content-Type:application/x-www-form-urlencoded")
			)
		);
		$response = curl_exec($curl);
		if (!$response) {
            exit(json_encode(array('success'=>false, 'err'=>'Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl))));
		}
		curl_close($curl);
        echo json_encode(array('success'=>true));

        
        $_SESSION['prec']['otp'] = password_hash($otp, PASSWORD_DEFAULT);
        $_SESSION['prec']['user_id'] = $user->row()->iduser;
        $_SESSION['prec']['new_pass'] = password_hash($newpass, PASSWORD_DEFAULT);
    }
    
    // verify the otp and set new password
    public function otp_verify () {

        $entered_otp = $_POST['otp'];
        $hash = $_SESSION['prec']['otp'];
        $userid = $_SESSION['prec']['user_id'];

        if (password_verify($entered_otp, $hash)) {
            $user = array(
                'password'=>$_SESSION['prec']['new_pass']
            );
            if($this->user_model->update_user($user,$userid)) {
                echo json_encode(array('stat'=>true));
            } else {
                echo json_encode(array('success'=>false, 'err'=>'Password not updated.'));
            }
        } else {
            echo json_encode(array('stat'=>false, 'form_error'=>'Invalid OTP'));
        }
    }
}
