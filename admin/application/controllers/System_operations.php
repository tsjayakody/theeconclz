<?php
class System_operations extends CI_Controller {

    public function __construct(){
        parent::__construct();
        
        date_default_timezone_set('Asia/Colombo');
    }

    // get all the teachers form add course
	public function get_t_for_add_c () {

		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('vac');
		if ($res === false) {
			exit(json_encode(array('err'=>'You have no permission to perform this action')));
		}

		$this->db->select('*');
		$this->db->from('teachers');
		$this->db->join('subjects', 'idsubjects = subjects_idsubjects');
		$teachersObject = $this->db->get();

		if ($teachersObject->num_rows() > 0) {
			$array = array();
			foreach ($teachersObject->result_array() as $key => $value) {
				$array[$value['idteachers']] = $value;
			}

			echo json_encode(array('teachers' => $array));
		} else {
			echo json_encode(array('error' => 'No teachers found in the system'));
		}
	}

	// get all the teachers form add course
	public function get_t_for_add_cu () {

		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('udc');
		if ($res === false) {
			exit(json_encode(array('err'=>'You have no permission to perform this action')));
		}

		$this->db->select('*');
		$this->db->from('teachers');
		$this->db->join('subjects', 'idsubjects = subjects_idsubjects');
		$teachersObject = $this->db->get();

		if ($teachersObject->num_rows() > 0) {
			$array = array();
			foreach ($teachersObject->result_array() as $key => $value) {
				$array[$value['idteachers']] = $value;
			}

			echo json_encode(array('teachers' => $array));
		} else {
			echo json_encode(array('error' => 'No teachers found in the system'));
		}
	}

	// get all the teachers form add course
	public function get_c_for_update_c () {

		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('udc');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}

		$this->db->select('category_name, idcourse_category, idcourses, monthly_fee, idteachers, idsubjects, course_name, courses.description, teachers_name, subject_name');
		$this->db->from('courses');
		$this->db->join('subjects', 'idsubjects = subjects_idsubjects');
		$this->db->join('teachers', 'idteachers = teachers_idteachers');
		$this->db->join('course_category', 'idcourse_category = course_category_idcourse_category');
		$coursesObject = $this->db->get();

		if ($coursesObject->num_rows() > 0) {
			$array = array();
			foreach ($coursesObject->result_array() as $key => $value) {
				$array[$value['idcourses']] = $value;
			}

			echo json_encode(array('courses' => $array));
		} else {
			echo json_encode(array('error' => 'No teachers found in the system'));
		}
	}

	// get all the teachers form add course
	public function get_c_for_add_ts () {

		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('adc');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}

		$category_id = $this->input->post('category_id');

		$this->db->select('idcourses, course_name, description,');
		$this->db->from('courses');
		if ($category_id !== "" && $category_id !== null) {
			$this->db->where('course_category_idcourse_category', $category_id);
		}
		$coursesObject = $this->db->get();

		if ($coursesObject->num_rows() > 0) {
			$array = array();
			foreach ($coursesObject->result_array() as $key => $value) {
				$array[$value['idcourses']] = $value;
			}

			echo json_encode(array('courses' => $array));
		} else {
			echo json_encode(array('error' => 'No teachers found in the system'));
		}
	}

	// delete the student
	public function delete_student () {
		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('usd');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		} else {

			$id = $this->input->post('student_id');

			if ($this->db->where('idstudents', $id)->delete('students') == FALSE) {
				echo json_encode(array('success' => FALSE));
			} else {
				echo json_encode(array('success' => TRUE));
			}

		}
	}


	// delete the course
	public function delete_course () {
		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('udc');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		} else {

			$id = $this->input->post('course_id');

			if ($this->db->where('idcourses', $id)->delete('courses') == FALSE) {
				echo json_encode(array('success' => FALSE));
			} else {
				echo json_encode(array('success' => TRUE));
			}

		}
	}

	// edit course
	public function update_course () {

		$res = $this->user_model->validate_user_access('udc');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules('course_name', 'Course name', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('monthly_fee', 'Monthly fee', 'required');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() == FALSE)
		{
			$formErr = array(
				'course_name' => form_error('course_name'),
				'description' => form_error('description'),
				'monthly_fee' => form_error('monthly_fee')
			);
			echo json_encode(array('form_errors'=> $formErr));
		}
		else
		{
			$insertData = array(
				'course_name' => $this->input->post('course_name'),
				'description' => $this->input->post('description'),
				'teachers_idteachers' => $this->input->post('teacher_id'),
				'subjects_idsubjects' => $this->input->post('subject_id'),
				'monthly_fee' => $this->input->post('monthly_fee'),
				'course_category_idcourse_category' => $this->input->post('category_id')
			);
			if ($this->db->where('idcourses', $this->input->post('course_id'))->update('courses', $insertData)) {
				echo json_encode(array('success' => TRUE));
			} else {
				echo json_encode(array('success' => FALSE, 'error' => 'Course is not saved. Try again'));
			}
		}

	}

	// save the customer
	public function save_course () {
		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('vac');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules('course_name', 'Course name', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('monthly_fee', 'Monthly fee', 'required');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() == FALSE)
		{
			$formErr = array(
				'course_name' => form_error('course_name'),
				'description' => form_error('description'),
				'monthly_fee' => form_error('monthly_fee')
			);
			echo json_encode(array('form_errors'=> $formErr));
		}
		else
		{
			$insertData = array(
				'course_name' => $this->input->post('course_name'),
				'description' => $this->input->post('description'),
				'teachers_idteachers' => $this->input->post('teachers_idteachers'),
				'subjects_idsubjects' => $this->input->post('subjects_idsubjects'),
				'monthly_fee' => $this->input->post('monthly_fee'),
				'course_category_idcourse_category' => $this->input->post('course_category')
			);
			if ($this->db->insert('courses', $insertData)) {
				echo json_encode(array('success' => TRUE));
			} else {
				echo json_encode(array('success' => FALSE, 'error' => 'Course is not saved. Try again'));
			}
		}
	}



	public function save_content () {
		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('adc');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Content title', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('video_link', 'Video Link', 'required');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() == FALSE)
		{
			$formErr = array(
				'title' => form_error('title'),
				'description' => form_error('description'),
				'video_link' => form_error('video_link')
			);
			echo json_encode(array('form_errors'=> $formErr));
		}
		else
		{
			date_default_timezone_set('Asia/Colombo');
			$insertData = array(
				'title' => $this->input->post('title'),
				'description' => $this->input->post('description'),
				'video_link' => $this->input->post('video_link'),
				'courses_idcourses' => $this->input->post('course_id'),
				'created_at' => date('Y-m-d H:i:s')
			);
			if ($this->db->insert('contents', $insertData)) {
				echo json_encode(array('success' => TRUE));
			} else {
				echo json_encode(array('success' => FALSE, 'error' => 'Content is not saved. Try again'));
			}
		}
	}


	public function getallcontents () {

		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('adc');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}

		$course_id = $this->input->post('course_id');

		$contents = $this->db->select('*')->from('contents')->where('courses_idcourses', $course_id)->get();

		if ($contents->num_rows() > 0) {
			$array = array();
			foreach ($contents->result_array() as $key => $value) {
				$array[$value['idcontents']] = $value;
			}

			echo json_encode(array('contents' => $array));
		} else {
			echo json_encode(array('error' => 'No contents found in the system'));
		}

	}

	public function update_content() {

		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('adc');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}

		$content_id = $this->input->post('content_id');

		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Content title', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('video_link', 'Video Link', 'required');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() == FALSE)
		{
			$formErr = array(
				'title' => form_error('title'),
				'description' => form_error('description'),
				'video_link' => form_error('video_link')
			);
			echo json_encode(array('form_errors'=> $formErr));
		} else {
			$update_array = array (
				'title' => $this->input->post('title'),
				'description' => $this->input->post('description'),
				'video_link' => $this->input->post('video_link'),
				'courses_idcourses' => $this->input->post('course_id')
			);

			if ($this->db->where('idcontents', $content_id)->update('contents', $update_array)) {
				echo json_encode(array('success' => TRUE));
			} else {
				echo json_encode(array('success' => FALSE));
			}
		}
	}


	public function delete_content () {

		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('adc');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}

		$content_id = $this->input->post('content_id');

		$this->db->trans_start();
		$this->db->where('contents_idcontents', $content_id)->delete('available_timeslots');
		$this->db->where('idcontents', $content_id)->delete('contents');
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			echo json_encode(array('success'=> FALSE));
		} else {
			echo json_encode(array('success'=> TRUE));
		}

	}

	public function get_timeslots () {

		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('adc');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}

		$content_id = $this->input->post('content_id');

		$times = $this->db->select('*')->from('available_timeslots')->where('contents_idcontents', $content_id)->get();

		if ($times->num_rows() > 0) {
			$array = array();
			foreach ($times->result_array() as $key => $value) {
				$array[$value['idavailable_timeslots']] = $value;
			}

			echo json_encode(array('timeslots' => $array));
		} else {
			echo json_encode(array('error' => 'No timeslots found in the system'));
		}

	}


	public function add_time_slot () {

		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('adc');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}


		$content_id = $this->input->post('content_id');
		$from = date('Y-m-d H:i:s', strtotime($this->input->post('from_time')));
		$to = date('Y-m-d H:i:s', strtotime($this->input->post('to_time')));

		$array =  array (
			'available_from' => $from,
			'available_to' => $to,
			'contents_idcontents' => $content_id
		);

		if ($this->db->insert('available_timeslots', $array)) {
			echo json_encode(array('success' => TRUE));
		} else {
			echo json_encode(array('success' => FALSE));
		}
	}


	public function delete_time_slot () {

		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('adc');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}

		if ($this->db->where('idavailable_timeslots', $this->input->post('slot_id'))->delete('available_timeslots')) {
			echo json_encode(array('success' => TRUE));
		} else {
			echo json_encode(array('success' => FALSE));
		}

	}


	public function get_all_requests () {

		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('sr');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}

		$requests = $this->db->select('*')->from('allocation_requests')
							->join('students', 'idstudents = students_idstudents')
							->join('contents', 'idcontents = contents_idcontents')
							->where('is_resolved', '0')
							->get();

		if ($requests->num_rows() > 0) {
			echo json_encode(array('requests' => $requests->result_array()));
		} else {
			echo json_encode(array('requests' => array()));
		}
	}


	public function reject_request () {
		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('sr');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}

		$reqid = $this->input->post('request_id');

		$request = $this->db->select('*')->from('allocation_requests')
			->join('students', 'idstudents = students_idstudents')
			->join('contents', 'idcontents = contents_idcontents')
			->where('idallocation_requests', $reqid)
			->get()->row();

		$phone_number = $request->phone_number;


		$username = 'theeconclz';
		$password = 'Tec86eCZ';


		$curl = curl_init();
		curl_setopt_array(
			$curl,
			array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => 'http://sms.textware.lk:5000/sms/send_sms.php?username='.$username.'&password='.$password.'&src=TheEconClz&dst='.$phone_number.'&msg=Please%20note%20that%20your%20watch%20again%20request%20is%20rejected.%20For%20more%20information,%20contact%20our%20representative.&dr=1',
				CURLOPT_HTTPHEADER => array("Content-Type:application/x-www-form-urlencoded")
			)
		);
		$response = curl_exec($curl);
		if (!$response) {
			exit(json_encode(array('success'=>false, 'error'=>'Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl))));
		}
		curl_close($curl);
		$this->db->where('idallocation_requests', $reqid)->update('allocation_requests', array('is_resolved'=> 2));

		echo json_encode(array('success'=>true));
	}


	public function allocate_new_time () {

		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('sr');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}

		date_default_timezone_set('Asia/Colombo');

		$request_id = $this->input->post('request_id');
		$student_id = $this->input->post('student_id');
		$content_id = $this->input->post('content_id');
		$phone_number = $this->input->post('phone_number');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');

		$from = date('Y-m-d H:i:s', strtotime($from_date));
		$to = date('Y-m-d H:i:s', strtotime($to_date));

		$array = array(
			'students_idstudents' => $student_id,
			'contents_idcontents' => $content_id,
			'allocated_from' => $from,
			'allocated_to' => $to,
			'allocated_date' => date('Y-m-d H:i:s'),
			'allocation_requests_idallocation_requests' => $request_id
		);

		$this->db->trans_start();
		$this->db->where('idallocation_requests', $request_id)->update('allocation_requests', array('is_resolved' => 1));
		$this->db->insert('requested_allocations', $array);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			echo json_encode(array('success'=> FALSE));
		} else {
			$username = 'theeconclz';
			$password = 'Tec86eCZ';


			$curl = curl_init();
			curl_setopt_array(
				$curl,
				array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'http://sms.textware.lk:5000/sms/send_sms.php?username='.$username.'&password='.$password.'&src=TheEconClz&dst='.$phone_number.'&msg=Your%20new%20timeslot%20is%20from%20'.str_replace(' ','%20',$from_date).'%20until%20'.str_replace(' ','%20',$to_date).'.&dr=1',
					CURLOPT_HTTPHEADER => array("Content-Type:application/x-www-form-urlencoded")
				)
			);
			$response = curl_exec($curl);
			if (!$response) {
				exit(json_encode(array('success'=>false, 'error'=>'Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl))));
			}
			curl_close($curl);


			echo json_encode(array('success'=>true));
		}

	}

	public function get_all_non_allowed_subs () {

		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('acts');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}

		$data = $this->db->select('*')->from('subscriptions')
									->join('students', 'students_idstudents = idstudents')
									->join('courses', 'idcourses = courses_idcourses')->where('is_allowed', 0)->get()->result_array();

		echo json_encode(array('subs' => $data));

	}

	public function delete_sub () {

		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('acts');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}

		$id = $this->input->post('sub_id');

		if ($this->db->where('idsubscriptions', $id)->delete('subscriptions')) {
			echo json_decode(array('success' => true));
		} else {
			echo json_decode(array('success' => false));
		}
	}

	public function allow_sub () {

		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('acts');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}

		$sub_id = $this->input->post('sub_id');
		$start = $this->input->post('start_date');
		$end = $this->input->post('end_date');

		date_default_timezone_set('Asia/Colombo');

		$today = date('Y-m-d H:i:s');

		$update_array = array(
			'subscription_start' => $start,
			'subscription_end' => $end,
			'subscription_date' => $today,
			'is_allowed' => '1'
		);

		if ($this->db->where('idsubscriptions', $sub_id)->update('subscriptions', $update_array)) {
			echo json_decode(array('success' => true));
		} else {
			echo json_decode(array('success' => false));
		}
	}

	public function getAllStudents () {

		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('acts');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}

		$this->db->select('*');    
		$this->db->from('students');
		$this->db->join('exam_year', 'students.id_exam_year = exam_year.id_exam_year');
		$students = $this->db->get()->result_array();

		//$students = $this->db->get('students')->result_array();
		echo json_encode(array('students'=> $students));

	}

	public function get_student_data_for_update () {
		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('usd');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}

		$student = $this->db->select('*')->from('students')->where('idstudents', $this->input->post('student_id'))->get()->row_array();
		echo json_encode($student);
	}

	public function update_student_data () {
		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('usd');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules('first_name', 'First name', 'required|trim');
		$this->form_validation->set_rules('last_name', 'Last name', 'required|trim');
		$this->form_validation->set_rules('email', 'E-Mail', 'required|trim|valid_email');
		$this->form_validation->set_rules('school', 'School', 'required|trim');
		$this->form_validation->set_rules('student_city', 'City', 'required|trim');
		$this->form_validation->set_rules('phone_number', 'Phone number', 'required|trim|integer');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() == FALSE)
		{
			$formErr = array(
				'first_name' => form_error('first_name'),
				'last_name' => form_error('last_name'),
				'email' => form_error('email'),
				'school' => form_error('school'),
				'student_city' => form_error('student_city'),
				'phone_number' => form_error('phone_number')
			);
			echo json_encode(array('form_errors'=> $formErr));
		} else {
			$array = array(
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'email' => $this->input->post('email'),
				'school' => $this->input->post('school'),
				'student_city' => $this->input->post('student_city'),
				'phone_number' => $this->input->post('phone_number'),
			);

			if ($this->db->where('idstudents', $this->input->post('student_id'))->update('students', $array)) {
				echo json_encode(array('success' => TRUE ));
			} else {
				echo json_encode(array('success' => FALSE, 'error' => 'Student data update failed.' ));
			}
		}
	}

	public function get_all_students () {
		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('usd');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}
    	$students = $this->db->get('students');
    	echo json_encode($students->result_array());
	}

	public function get_all_categories () {
		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('acc');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}

		$categories = $this->db->get('course_category');
		echo json_encode($categories->result_array());
	}

	public function get_category_data_for_update () {
		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('acc');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}
		$catid = $this->input->post('category_id');
		$categories = $this->db->select('*')->from('course_category')->where('idcourse_category', $catid)->get();
		echo json_encode($categories->row_array());
	}

	public function add_new_category () {
		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('acc');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules('category_name', 'Category name', 'required|trim');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() == FALSE)
		{
			$formErr = array(
				'category_name' => form_error('category_name')
			);
			echo json_encode(array('form_errors'=> $formErr));
		} else {
			$array = array(
				'category_name' => $this->input->post('category_name')
			);

			if ($this->db->insert('course_category', $array)) {
				echo json_encode(array('success' => TRUE ));
			} else {
				echo json_encode(array('success' => FALSE, 'error' => 'Category data adding failed.' ));
			}
		}
	}

	public function delete_category () {
		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('acc');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}

		$category_id = $this->input->post('category_id');

		$courses = $this->db->select('*')->from('courses')->where('course_category_idcourse_category', $category_id)->get();
		if ($courses->num_rows() > 0) {
			exit(json_encode(array('error' => 'Cannon delete the category. category already assigned to courses')));
		} else {
			if ($this->db->where('idcourse_category', $category_id)->delete('course_category')) {
				echo json_encode(array('success' => TRUE));
			} else {
				echo json_encode(array('success' => FALSE, 'error' => 'Category is not deleted.'));
			}
		}
	}

	public function update_category_data () {
		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('acc');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules('category_name', 'Category name', 'required|trim');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() == FALSE)
		{
			$formErr = array(
				'category_name' => form_error('category_name')
			);
			echo json_encode(array('form_errors'=> $formErr));
		} else {
			$array = array(
				'category_name' => $this->input->post('category_name')
			);

			if ($this->db->where('idcourse_category', $this->input->post('category_id'))->update('course_category', $array)) {
				echo json_encode(array('success' => TRUE ));
			} else {
				echo json_encode(array('success' => FALSE, 'error' => 'Category data update failed.' ));
			}
		}
	}

	public function get_courses_for_sub_report () {
		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('vsr');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}
		$category_id = $this->input->post('category_id');
		$courses = $this->db->select('*')->from('courses')->where('course_category_idcourse_category', $category_id)->get()->result_array();
		echo json_encode($courses);
	}

	public function get_courses_for_req_report () {
		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('vsrr');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}
		$category_id = $this->input->post('category_id');
		$courses = $this->db->select('*')->from('courses')->where('course_category_idcourse_category', $category_id)->get()->result_array();
		echo json_encode($courses);
	}

	public function get_subscription_report () {
		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('vsr');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}

		$course_id = $this->input->post('course_id');
		$category_id = $this->input->post('category_id');

		$this->db->select('*');
		$this->db->from('subscriptions');
		$this->db->join('courses', 'courses_idcourses = idcourses');
		$this->db->join('students', 'students_idstudents = idstudents');
		$this->db->join('course_category', 'course_category_idcourse_category = idcourse_category');
		if ($course_id !== null && $course_id !== "") {
			$this->db->where('idcourses', $course_id);
		}
		if ($category_id !== null && $category_id !== "") {
			$this->db->where('idcourse_category', $category_id);
		}
		$data = $this->db->get();
		if ($data->num_rows() > 0) {
			echo json_encode($data->result_array());
		} else {
			echo json_encode(array('error' => 'No data found.'));
		}
	}

	public function get_special_request_report () {
		// check for eligibility for user to execute operation
		$res = $this->user_model->validate_user_access('vsrr');
		if ($res === false) {
			exit(json_encode(array('error'=>'You have no permission to perform this action')));
		}

		$course_id = $this->input->post('course_id');
		$category_id = $this->input->post('category_id');

		$this->db->select('*');
		$this->db->from('courses');
		$this->db->join('contents', 'courses_idcourses = idcourses');
		$this->db->join('allocation_requests', 'contents_idcontents = idcontents');
		$this->db->join('students', 'students_idstudents = idstudents');
		$this->db->join('course_category', 'course_category_idcourse_category = idcourse_category');
		if ($course_id !== null && $course_id !== "") {
			$this->db->where('idcourses', $course_id);
		}
		if ($category_id !== null && $category_id !== "") {
			$this->db->where('idcourse_category', $category_id);
		}
		$data = $this->db->get();
		if ($data->num_rows() > 0) {
			echo json_encode($data->result_array());
		} else {
			echo json_encode(array('error' => 'No data found.'));
		}
	}
}

