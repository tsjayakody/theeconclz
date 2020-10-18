<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Myaccount_controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('profile') == null) {
			exit(json_encode(array('error' => 'You are not logged in')));
		}
	}

    public function index(){

        $this->load->view('pages/my_account');
    }

    public function my_subscriptions () {
		$this->load->view('pages/my_subscriptions');
	}

	public function my_special_requests () {
		$this->load->view('pages/my_special_requests');
	}

    public function get_userdata () {
        $student = $this->db->select('school, student_city, first_name, idstudents, last_name, phone_number')->from('students')->where('idstudents', $this->session->userdata('id_student'))->get()->row_array();
        echo json_encode(array('student' => $student));
    }

    public function get_all_requests () {
		$student_id = $this->session->userdata('id_student');
		$data = $this->db->select('*')->from('allocation_requests')->join('contents', 'contents_idcontents = idcontents')->where('students_idstudents', $student_id)->get();
		echo json_encode($data->result_array());
	}

	public function get_timeslot_allocation () {
		$student_id = $this->session->userdata('id_student');
		$request_id = $this->input->post('request_id');
		$data = $this->db->select('*')->from('requested_allocations')->join('contents', 'contents_idcontents = idcontents')->where('allocation_requests_idallocation_requests', $request_id)->where('students_idstudents', $student_id)->get();
		echo json_encode($data->result_array());
	}

    public function get_my_subs () {

		$user_id = $this->session->userdata('id_student');
		$data = $this->db->select('*')
						->from('subscriptions')
						->join('courses', 'courses_idcourses = idcourses')
						->where('students_idstudents', $user_id)
						->get();

		if ($data->num_rows() > 0) {
			echo json_encode($data->result_array());
		} else {
			echo json_encode(array());
		}
	}

    public function updateGeneralData () {

    	$student_id = $this->input->post('student_id');
		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$phone_number = $this->input->post('phone_number');
		$school = $this->input->post('school');
		$student_city = $this->input->post('student_city');

		$error_messages = array();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('phone_number','Phone number','trim|required');
		$this->form_validation->set_rules('first_name','First name','trim|required');
		$this->form_validation->set_rules('last_name','Last name','trim|required');
		$this->form_validation->set_rules('school','School','trim|required');
		$this->form_validation->set_rules('student_city','City','trim|required');
		$this->form_validation->set_error_delimiters('','');

		if($this->form_validation->run() == FALSE)
		{
			$error_messages = array(
				'phone_number' => form_error('phone_number'),
				'first_name' => form_error('first_name'),
				'last_name' => form_error('last_name'),
				'school' => form_error('school'),
				'student_city' => form_error('student_city'),
			);

			echo json_encode(array('form_errors' => $error_messages));
		} else {
			$data = array(
				'phone_number' => $phone_number,
				'last_name' => $last_name,
				'first_name' => $first_name,
				'school' => $school,
				'student_city' => $student_city
			);

			if ($this->db->where('idstudents', $student_id)->update('students', $data)) {
				echo json_encode(array('success' => true));
			} else {
				echo json_encode(array('success' => false));
			}
		}
	}

	public function updatepass () {

    	$oldpass = $this->input->post('oldpass');
    	$newpass = $this->input->post('newpass');
    	$renewpass = $this->input->post('renewpass');
    	$studentid = $this->session->userdata('id_student');


    	$this->load->library('form_validation');

		$this->form_validation->set_rules('oldpass','Old Password','trim|required');
		$this->form_validation->set_rules('newpass','New Password','trim|required|min_length[5]');
		$this->form_validation->set_rules('renewpass','Retype New Password','trim|required|min_length[5]|matches[newpass]');
		$this->form_validation->set_error_delimiters('','');

		if($this->form_validation->run() == FALSE)
		{
			$error_messages = array(
				'oldpass' => form_error('oldpass'),
				'newpass' => form_error('newpass'),
				'renewpass' => form_error('renewpass')
			);

			echo json_encode(array('form_errors' => $error_messages));
		} else {

			$currentpass = $this->db->select('*')->from('students')->where('idstudents', $studentid)->get()->row_array();

			if (password_verify($oldpass, $currentpass['password'])) {
				if ($this->db->where('idstudents', $studentid)->update('students', array('password' => password_hash($newpass, PASSWORD_DEFAULT)))) {
					echo json_encode(array('success' => true));
				} else {
					echo json_encode(array('success' => false));
				}
			} else {
				$error_messages = array(
					'oldpass' => 'Password is wrong.'
				);
				echo json_encode(array('form_errors' => $error_messages));
			}
		}
	}


}
