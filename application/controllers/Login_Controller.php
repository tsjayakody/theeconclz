<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_controller extends CI_Controller {

    public function index()
    {
        $this->load->view('pages/login_page');
    }

    public function view_register()
    {
        $this->load->view('pages/register');
    }

    public function view_forgot_password()
    {
        $this->load->view('pages/forgot_password');
    }

    // function for register student
    public function register_student()
    {
        $this->load->helper(array('form','url'));
        $this->load->library('form_validation');

        $error_messages = array();

        $this->form_validation->set_rules('first_name','First Name','trim|required');
        $this->form_validation->set_rules('last_name','Last Name','trim|required');
        $this->form_validation->set_rules('email','Email','trim|required|is_unique[students.email]|valid_email');
        $this->form_validation->set_rules('password','Password','trim|required');
        $this->form_validation->set_rules('con_password','Retype Password','trim|required|matches[password]');
        $this->form_validation->set_rules('phone_number','Phone Number','trim|required|is_unique[students.phone_number]');
		$this->form_validation->set_rules('school','School','trim|required');
		$this->form_validation->set_rules('student_city','Student city','trim|required');
		$this->form_validation->set_rules('al_year','AL year','trim|required');
        $this->form_validation->set_error_delimiters('','');

        if($this->form_validation->run() == FALSE)
        {
            $error_messages = array(
                'first_name' => form_error('first_name'),
                'last_name' => form_error('last_name'),
                'email' => form_error('email'),
                'password' => form_error('password'),
                'con_password' => form_error('con_password'),
                'phone_number' => form_error('phone_number'),
				'school' => form_error('school'),
				'student_city' => form_error('student_city'),
				'al_year' => form_error('al_year'),
            );
            echo json_encode(array ('success'=> FALSE, 'form_errors' => $error_messages));
        } else {
            $this->load->model('student_model');
            $post_data = $this->input->post();
            $response = $this->student_model->create_student($post_data);
            if ($response == TRUE) {

				$otp = rand(10000,99999);
				$this->session->set_tempdata('otpdata',array('otp'=>$otp, 'phone'=>$post_data['phone_number']),300);

				$message = 'Your verification code : '.$otp;

				$data[] = array (
					'src' => 'TheEconClz',
					'dst' => $post_data['phone_number'],
					'dr' => '1',
					'msg' => $message
				);

				$tosend = array(
					'action' => 'bulk_put',
					'user' => 'theeconclz',
					'password' => 'Tec86eCZ',
					'ea' => 'theeconclz',
					'campaign' => 'bulk',
					'records' => $data
				);
				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_POST => 1,
					CURLOPT_URL => 'http://sms.textware.lk:5000/bulk/sms.php',
					CURLOPT_HTTPHEADER => array("Content-Type:application/json"),
					CURLOPT_POSTFIELDS => json_encode($tosend),
				));
				$response = curl_exec($curl);
				if (!$response) {
					exit(json_encode(array('success'=>FALSE, 'error'=>'Sending verification sms failed.')));
				}
				curl_close($curl);
				echo json_encode(array('success'=>TRUE));


            } else {
                echo json_encode(array('success' => FALSE));
            }
        }
        
    }

    public function phone_verify () {

    	$vcode = $this->input->post('verificationCode');

		$this->load->helper(array('form','url'));
		$this->load->library('form_validation');

		$error_messages = array();

		$this->form_validation->set_rules('verificationCode','Verification code','trim|required');

		$this->form_validation->set_error_delimiters('','');

		if($this->form_validation->run() == FALSE)
		{
			$error_messages = array(
				'verificationCode' => form_error('verificationCode')
			);
			echo json_encode(array ('success'=> FALSE, 'form_errors' => $error_messages));
		} else {
			$otpdata = $this->session->tempdata('otpdata');

			if ($otpdata === NULL) {
				exit(json_encode(array ('success'=> FALSE, 'error' => 'Your verification code is expired.')));
			}

			$otp = $otpdata['otp'];
			$phone_number = $otpdata['phone'];

			if ($vcode == $otp) {
				$update_array = array('active_status' => 'active');
				if ($this->db->where('phone_number',$phone_number)->update('students',$update_array)) {
					echo json_encode(array ('success'=> TRUE));
				} else {
					echo json_encode(array ('success'=> FALSE, 'error' => 'Activating account is failed. Try again!'));
				}
			} else {
				$error_messages = array(
					'verificationCode' => 'Verification code is wrong!'
				);
				echo json_encode(array ('success'=> FALSE, 'form_errors' => $error_messages));
			}
		}
	}

    private function sendVerificationCode ($phone_number) {

	}

    // function for log as student
    public function log_student()
    {
        $this->load->helper(array('form','url'));
        $this->load->library('form_validation');

        $error_messages = array();
        $this->form_validation->set_rules('phone_number','Phone number','trim|required');
        $this->form_validation->set_rules('password','Password','trim|required');
        $this->form_validation->set_error_delimiters('','');

        if($this->form_validation->run() == FALSE)
        {
            $error_messages = array(
                'phone_number' => form_error('phone_number'),
                'password' => form_error('password')
            );
            echo json_encode(array ('success' => FALSE, 'form_errors' => $error_messages));
        } else {
            $this->load->model('student_model');

            $phone = $this->input->post('phone_number');
            $password = $this->input->post('password');

            $response = $this->student_model->search_student_by_phone($phone);
            if ($response == FALSE) {
                echo json_encode(array('success' => FALSE, 'form_errors' => array('phone_number' => 'Phone number is wrong or does not exist on the system.')));
            } else {
                if (password_verify($password, $response['password'])) {

                	if ($response['active_status'] === 'inactive') {
                		$otp = rand(10000,99999);
                		$this->session->set_tempdata('otpdata', array('otp' => $otp, 'phone'=> $response['phone_number']));

						$message = 'Your verification code : '.$otp;

						$data[] = array (
							'src' => 'TheEconClz',
							'dst' => $response['phone_number'],
							'dr' => '1',
							'msg' => $message
						);

						$tosend = array(
							'action' => 'bulk_put',
							'user' => 'theeconclz',
							'password' => 'Tec86eCZ',
							'ea' => 'theeconclz',
							'campaign' => 'bulk',
							'records' => $data
						);
						$curl = curl_init();
						curl_setopt_array($curl, array(
							CURLOPT_RETURNTRANSFER => 1,
							CURLOPT_POST => 1,
							CURLOPT_URL => 'http://sms.textware.lk:5000/bulk/sms.php',
							CURLOPT_HTTPHEADER => array("Content-Type:application/json"),
							CURLOPT_POSTFIELDS => json_encode($tosend),
						));
						$response = curl_exec($curl);
						if (!$response) {
							exit(json_encode(array('success'=>FALSE, 'error'=>'Sending verification sms failed.')));
						}
						curl_close($curl);

                		exit(json_encode(array('success' => FALSE, 'not_active' => TRUE)));
					} else {
						$st_data = array (
							'profile' => 'student',
							'first_name' => $response['first_name'],
							'last_name' => $response['last_name'],
							'id_student' => $response['idstudents'],
							'email' => $response['email'],
							'student_id' => $response['student_id'],
							'class_student' => $response['class_student']
						);
						//$this->session->sess_destroy();
						$this->session->set_userdata($st_data);
						echo json_encode(array('success' => TRUE));
					}
                } else {
                    echo json_encode(array('success' => FALSE, 'form_errors' => array('password' => 'Password is wrong.')));
                }
            }
        }
    }


    // function for log out student from system
    public function logout_student()
    {
        $this->session->sess_destroy();
        redirect('login');
    }

    // function for send temporary password to the student email
	public function send_temp_password()
	{
		$this->load->helper(array('form','url'));
		$this->load->library('form_validation');

		$this->form_validation->set_rules('phone_number','Phone number','trim|required');
		$this->form_validation->set_error_delimiters('','');
		
		if($this->form_validation->run() == FALSE) {
            $error_messages = array(
                'phone_number' => form_error('phone_number')
            );
			echo json_encode(array('success'=>FALSE, 'form_errors'=>$error_messages));
		} else {
            $this->load->model('student_model');
            $phone_number = $this->input->post('phone_number');
            $student = $this->student_model->search_student_by_phone($phone_number);
            
            if ($student == FALSE) {
                $error_messages = array(
                    'phone_number' => 'Phone number is wrong or does not exist in the system.'
                );
                echo json_encode(array('success'=>FALSE, 'form_errors'=>$error_messages));
            } else {
                $temp_password = substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789'),0,8);

				$message = 'Your temporary password is : '.$temp_password;

				$data[] = array (
					'src' => 'TheEconClz',
					'dst' => $phone_number,
					'dr' => '1',
					'msg' => $message
				);

				$tosend = array(
					'action' => 'bulk_put',
					'user' => 'theeconclz',
					'password' => 'Tec86eCZ',
					'ea' => 'theeconclz',
					'campaign' => 'bulk',
					'records' => $data
				);
				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_POST => 1,
					CURLOPT_URL => 'http://sms.textware.lk:5000/bulk/sms.php',
					CURLOPT_HTTPHEADER => array("Content-Type:application/json"),
					CURLOPT_POSTFIELDS => json_encode($tosend),
				));
				$response = curl_exec($curl);
				if (!$response) {
					exit(json_encode(array('success'=>FALSE, 'error'=>'Sending temporary password sms failed.')));
				}
				curl_close($curl);

				if ($this->student_model->update_student_password(array('password'=>$temp_password),$student['idstudents'])) {
					echo json_encode(array('success'=>TRUE));
				} else {
					echo json_encode(array('success'=>FALSE, 'error_alert'=>'Resetting password is failed.'));
				}
            }
        }
    }
    
    // change password
    public function change_password()
    {
        $this->load->helper(array('form','url'));
        $this->load->library('form_validation');
        $this->load->model('student_model');

		$this->form_validation->set_rules('old_password','Old Password','trim|required');
		$this->form_validation->set_rules('new_password','New Password','trim|required');
        $this->form_validation->set_error_delimiters('','');
        
        if($this->form_validation->run() == FALSE) {
            $error_messages = array(
                'old_password' => form_error('old_password'),
                'new_password' => form_error('new_password')
            );
			echo json_encode(array('success'=>FALSE, 'form_errors'=>$error_messages));
		} else {
            $user_email = $this->session->userdata('email');
            if ($user_email == NULL) {
                echo json_encode(array('success'=>FALSE, 'error_alert'=>'You need to login to the system before change the password'));
            } else {
                $student = $this->student_model->search_student_by_email($user_email);
                if ($student == FALSE) {
                    echo json_encode(array('success'=>FALSE, 'error_alert'=>'Somthing wrong with login. Please login again.'));
                } else {
                    $password_verify = password_verify($this->input->post('old_password'), $student['password']);
                    if ($password_verify) {
                        $response = $this->student_model->update_student_password(array('password'=>$this->input->post('new_password')), $student['idstudents']);
                        if ($response) {
                            echo json_encode(array('success'=>TRUE));
                        } else {
                            echo json_encode(array('success'=>FALSE, 'error_alert'=>'Password is not updated. Please try again later.'));
                        }
                    } else {
                        echo json_encode(array('success'=>FALSE, 'form_errors'=>array('old_password'=>'Old password you entered is wrong.')));
                    }
                }
            }
        }
    }
}
