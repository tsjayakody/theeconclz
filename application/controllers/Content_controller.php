<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Course_controller extends CI_Controller {

    public function index() {
		if ($this->session->userdata('profile') === null){
			redirect('login');
		} else {

			$this->load->view('pages/courses');
		}
    }

    public function my_courses() {
    	if ($this->session->userdata('profile') === null){
    		redirect('login');
		} else {

    		$data = array();

    		// get student id from the session
    		$student_id = $this->session->userdata('id_student');

			// load course model
			$this->load->model('course_model');

			// get all subscribed courses
			$all_subscriptions = $this->course_model->getStudentSubscribedCourses($student_id);

			// if student have subscriptions
			if ($all_subscriptions->num_rows() > 0) {

				// loop through all results
				foreach ($all_subscriptions->result_array() as $key => $value) {

					// check if expired subscription
					$subscription_end = $value['subscription_end'];

					// get today date
					date_default_timezone_set('Asia/Colombo');
					$toDate = $today = date("Y-m-d");

					if ($subscription_end > $toDate) {

						$sub_data = $value;

						// get contents of the course
						$contents = $this->course_model->getContentsOfCourse($value['idcourses']);

						// loop through contents
						foreach ($contents->result_array() as $key1 => $value1) {


							// get time allocations
							$allocated_times = $this->db->select('*')->from('available_timeslots')->where('contents_idcontents', $value1['idcontents'])->get();

							if ($allocated_times->num_rows() > 0) {
								$data1 = array(
									'idcontents' => $value1['idcontents'],
									'title' => $value1['title'],
									'description' => $value1['description'],
									'time_slots' => $allocated_times->result_array()
								);
							}
							$sub_data['contents'][] = $data1;
						}


						$data[] = $sub_data;

					}
				}

			}
			$this->load->view('pages/dashboard', array('data'=> $data));
		}
	}


	public function getAllCourses () {
		if ($this->session->userdata('profile') === null){
			echo json_encode(array('error' => 'You are not logged in. Please login and try again.'));
		} else {

			$category_id = $this->input->post('category_id');

			$this->db->select('*');
			$this->db->from('subjects');
			$this->db->join('teachers','subjects_idsubjects = idsubjects');
			$subject_data =	$this->db->get();

			if ($subject_data->num_rows() > 0) {

				$dt = array();
				foreach ($subject_data->result_array() as $key => $value) {
					$this->db->select('*')->from('courses');
					$this->db->join('course_category', 'idcourse_category = course_category_idcourse_category');
					$this->db->where('subjects_idsubjects', $value['idsubjects']);
					if ($category_id !== "" && $category_id !== null) {
						$this->db->where('course_category_idcourse_category', $category_id);
					}
					$courses = $this->db->get();
					if ($courses->num_rows() > 0) {
						$ww = $value;
						foreach ($courses->result_array() as $course) {



							$this->db->select('*');
							$this->db->from('contents');
							$this->db->join('available_timeslots', 'idcontents = contents_idcontents');
							$this->db->where('courses_idcourses', $course['idcourses']);
							$data = $this->db->get();

							if ($data->num_rows() > 0) {
								$ww['courses'][] = $course;
							}
						}


						$dt[] = $ww;
					}
				}
				echo json_encode($dt);
			} else {
				echo json_encode(array('error' => 'No subjects found in the system'));
			}

		}
	}

	public function getCourseDetails () {
		if ($this->session->userdata('profile') === null){
			echo json_encode(array('error' => 'You are not logged in. Please login and try again.'));
		} else {

			// get course id
			$course_id = $this->input->post('course_id');

			$course = $this->db->select("teachers.description AS `teacher_description`")
																->select("subject_name")
																->select("monthly_fee")
																->select("teachers_name")
																->select("courses.description AS `course_description`")
																->select("course_name")
																->from('courses')->join('teachers', 'teachers.idteachers = courses.teachers_idteachers')
																->join('subjects','subjects.idsubjects = courses.subjects_idsubjects')
																->where('idcourses',$course_id)->get();

			$contents = $this->db->select('title,description,created_at,idcontents')->from('contents')->where('courses_idcourses',$course_id)->get();


			if ($course->num_rows() > 0) {

				$course_array = $course->result_array();
				$data = $course_array[0];
				$data1 = array();
				foreach ($contents->result_array() as $key => $value) {
					$value1 = $value;
					$time_slots = $this->db->select('*')->from('available_timeslots')->where('contents_idcontents',$value['idcontents'])->get();
					$value1['time_slots'] = $time_slots->result_array();
					$data1[] = $value1;
				}
				$data['contents'] = $data1;
				echo json_encode($data);


			} else {
				echo json_encode(array('error' => 'Cannot find course data.'));
			}
		}
	}

	public function subscribeCourse () {


    	// get course id
		$course_id = $this->input->post('course_id');

		if ($this->session->userdata('profile') === null){
			echo json_encode(array('error' => 'You are not logged in. Please login and try again.'));
		} else {

			date_default_timezone_set('Asia/Colombo');

			// get user id
			$user_id = $this->session->userdata('id_student');

			$old_rec = $this->db->select('*')->from('subscriptions')->where('courses_idcourses',$course_id)->where('students_idstudents',$user_id)->get();

			if ($old_rec->num_rows() > 0) {

				$row = $old_rec->row_array();
				$subscription_start = $row['subscription_start'];
				$subscription_end = $row['subscription_end'];
				$toDate = $today = date("Y-m-d");
				$is_allowed = $row['is_allowed'];

				if (($is_allowed == 1) && ($subscription_end > $toDate) && ($toDate > $subscription_start)) {

						exit(json_encode(array('error' => 'You are already subscribed for this month')));

				} else {

					$subscriptions_id = $row['idsubscriptions'];
					if ($this->db->where('idsubscriptions',$subscriptions_id)->delete('subscriptions') == FALSE) {
						exit(json_encode(array('error' => 'Something went wrong.')));
					} else {
						$ref_no = rand(100000,999999).$user_id;
						$insert_data = array(
							'reference_number' => $ref_no,
							'courses_idcourses' => $course_id,
							'students_idstudents' => $user_id
						);
						if ($this->db->insert('subscriptions', $insert_data)) {
							echo json_encode(array('ref_code'=>$ref_no));
						} else {
							exit(json_encode(array('error' => 'Something went wrong.')));
						}
					}

				}

			} else {
				$ref_no = rand(100000,999999).$user_id;
				$insert_data = array(
					'reference_number' => $ref_no,
					'courses_idcourses' => $course_id,
					'students_idstudents' => $user_id
				);
				if ($this->db->insert('subscriptions', $insert_data)) {
					echo json_encode(array('ref_code'=>$ref_no));
				} else {
					exit(json_encode(array('error' => 'Something went wrong.')));
				}
			}

		}

	}


	public function content($content_id) {

		

    	date_default_timezone_set('Asia/Colombo');

		if ($this->session->userdata('profile') === null){
			redirect('login');
			
		} else {
			
			$data = array();
			$user_id = $this->session->userdata('id_student');

			$content_data = $this->db->select('*')->from('contents')->join('courses','courses.idcourses = contents.courses_idcourses')
																	->join('subscriptions','subscriptions.courses_idcourses = courses.idcourses')
																	->where('is_allowed', 1)
																	->where('students_idstudents',$user_id)
																	->where('idcontents',$content_id)->get();

			
			if ($content_data->num_rows() > 0) {

				

				$content_array = $content_data->row_array();
				$data['contentid'] = $content_array['idcontents'];

				$toDate = date("Y-m-d");
				$subscription_from = $content_array['subscription_start'];
				$subscription_to = $content_array['subscription_end'];


				// this is a code for get remaining percentage and day count
				$date1=date_create($content_array['subscription_start']);
				$date2=date_create($content_array['subscription_end']);
				$toDate1=date_create();

				$diff=date_diff($date1,$date2);
				$diff1 = date_diff($date1,$toDate1);

				$fullDays =  $diff->format("%a");
				$nowDays = $diff1->format("%a");

				$percent = (($fullDays-$nowDays)/$fullDays) * 100;
				$dayCount = $fullDays-$nowDays;
				// end of special code block


				
				

				if (($subscription_to >= $toDate) && $subscription_from <= $toDate) {

					$timeslots = $this->db->select('*')->from('available_timeslots')->where('contents_idcontents', $content_id)->get()->result_array();

					

					$status = FALSE;
					$currentTimeSlot = array();
					foreach ($timeslots as $key => $value) {

						$toDateTime = $today = date("Y-m-d H:i:s");
						$fromtime = $value['available_from'];
						$totime = $value['available_to'];



						if (($fromtime < $toDateTime) && ($totime > $toDateTime)) {
							$status = TRUE;
							$currentTimeSlot = $value;
						}
					}

					if ($status == TRUE) {


						$data['watchAllowed'] = FALSE;

						$activeTimeSlot = $this->db->select('*')->from('activated_timeslots')->where('available_timeslots_idavailable_timeslots',$currentTimeSlot['idavailable_timeslots'])->where('subscriptions_idsubscriptions',$content_array['idsubscriptions'])->get();

						if ($activeTimeSlot->num_rows() > 0) {
							$data['watchAllowed'] = TRUE;
						} else {

							$res = $this->db->insert('activated_timeslots', array('available_timeslots_idavailable_timeslots'=>$currentTimeSlot['idavailable_timeslots'], 'subscriptions_idsubscriptions'=>$content_array['idsubscriptions']));
							if ($res) {
								$data['watchAllowed'] = TRUE;
							}

						}


						$resources = $this->db->select('idresources, file_name, description')->from('resources')->where('contents_idcontents',$content_id)->get();
						if ($resources->num_rows() > 0) {
							$data['resources'] = $resources->result_array();

						} else {
							$data['resources'] = array();
						}
						$data['percent'] = $percent;
						$data['dayCount'] = $dayCount;
						$data['content'] = $content_array;

					} else {
						$toDateTime1 = $today = date("Y-m-d H:i:s");
						$adt = $this->db->select('*')->from('requested_allocations')->where('students_idstudents', $user_id)->where('contents_idcontents', $content_id)->where('allocated_from <',$toDateTime1)->where('allocated_to >',$toDateTime1)->get();

						if ($adt->num_rows() > 0) {
							$data['watchAllowed'] = TRUE;

							$resources = $this->db->select('idresources, file_name, description')->from('resources')->where('contents_idcontents',$content_id)->get();
							if ($resources->num_rows() > 0) {
								$data['resources'] = $resources->result_array();

							} else {
								$data['resources'] = array();
							}

							$data['percent'] = $percent;
							$data['dayCount'] = $dayCount;
							$data['content'] = $content_array;
							$data['adt_from'] = $adt->row()->allocated_from;
							$data['adt_to'] = $adt->row()->allocated_to;

						} else {

							$data['err_status'] = 'NO_STD_TIMESLOT';
							$data['error'] = 'You are not in the available time slot of the content. Please come back within the correct time slot';

						}

					}


				} else {
					$data['error'] = 'Your subscription is already expired or not activated yet. Please contact the representative.';
				}

			} else {
				$data['error'] = 'You are not subscribed the course which is the content you requested belongs to.';
			}

			$this->load->view('pages/content',$data);

		}
	}


	public function download_resources ($res_id) {

		date_default_timezone_set('Asia/Colombo');
		if ($this->session->userdata('profile') === null){
			redirect('login');
		} else {

			$content_id = $this->db->select('contents_idcontents')->from('resources')->where('idresources', $res_id)->get()->row()->contents_idcontents;

			$data = array();
			$user_id = $this->session->userdata('id_student');

			$content_data = $this->db->select('*')->from('contents')->join('courses','courses.idcourses = contents.courses_idcourses')
				->join('subscriptions','subscriptions.courses_idcourses = courses.idcourses')
				->where('is_allowed', 1)
				->where('students_idstudents',$user_id)
				->where('idcontents',$content_id)->get();

			if ($content_data->num_rows() > 0) {

				$content_array = $content_data->row_array();

				$toDate = $today = date("Y-m-d");
				$subscription_from = $content_array['subscription_start'];
				$subscription_to = $content_array['subscription_end'];


				if (($subscription_to > $toDate) && $subscription_from < $toDate) {

					$timeslots = $this->db->select('*')->from('available_timeslots')->where('contents_idcontents', $content_id)->get()->result_array();

					$status = FALSE;
					foreach ($timeslots as $key => $value) {

						$toDateTime = $today = date("Y-m-d H:i:s");
						$fromtime = $value['available_from'];
						$totime = $value['available_to'];

						if (($fromtime < $toDateTime) && ($totime > $toDateTime)) {
							$status = TRUE;
						}
					}

					if ($status == TRUE) {

						$resources = $this->db->select('location, file_name')->from('resources')->where('contents_idcontents',$content_id)->get()->row_array();


						$file_location = $resources['location'];

						$filedata = @file_get_contents($file_location);

						// SUCCESS
						if ($filedata)
						{
							// GET A NAME FOR THE FILE
							$basename = basename($file_location);

							// THESE HEADERS ARE USED ON ALL BROWSERS
							header("Content-Type: application-x/force-download");
							header("Content-Disposition: attachment; filename=$basename");
							header("Content-length: " . (string)(strlen($filedata)));
							header("Expires: ".gmdate("D, d M Y H:i:s", mktime(date("H")+2, date("i"), date("s"), date("m"), date("d"), date("Y")))." GMT");
							header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");

							// THIS HEADER MUST BE OMITTED FOR IE 6+
							if (FALSE === strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE '))
							{
								header("Cache-Control: no-cache, must-revalidate");
							}

							// THIS IS THE LAST HEADER
							header("Pragma: no-cache");

							// FLUSH THE HEADERS TO THE BROWSER
							flush();

							// CAPTURE THE FILE IN THE OUTPUT BUFFERS - WILL BE FLUSHED AT SCRIPT END
							ob_start();
							echo $filedata;
						}

						// FAILURE
						else
						{
							die("ERROR: UNABLE TO OPEN $file_location");
						}


					} else {
						exit('You are not in the available time slot of the content. Please come back within the correct time slot');
					}


				} else {
					exit('Your subscription is already expired or not activated yet. Please contact the representative.');
				}

			} else {
				exit('We are unable to find the requested content.');
			}
		}
	}


	public function verify_active_timeslot () {

		if ($this->session->userdata('profile') === null){
			redirect('login');
		} else {

			$content_id = $this->input->post('content_id');
			$user_id = $this->session->userdata('id_student');

			$record = $this->db->select('*')->from('activated_timeslots')->join('available_timeslots', 'available_timeslots_idavailable_timeslots = idavailable_timeslots')
											->join('subscriptions', 'subscriptions_idsubscriptions = idsubscriptions')
											->join('students', 'subscriptions.students_idstudents = students.idstudents')
											->where('contents_idcontents', $content_id)
											->where('idstudents', $user_id)
											->get();
			if (!$record === FALSE) {
				echo json_encode(array('row_count'=> $record->num_rows()));
			} else {
				echo json_encode(FALSE);
			}
		}
	}

	public function request_additional_timeslot ()
	{

		if ($this->session->userdata('profile') === null) {
			redirect('login');
		} else {

			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');

			$error_messages = array();
			$this->form_validation->set_rules('message', 'Message', 'trim|required');
			$this->form_validation->set_error_delimiters('', '');

			if ($this->form_validation->run() == FALSE) {
				$error_messages = array(
					'message' => form_error('message')
				);
				echo json_encode(array('success' => FALSE, 'form_errors' => $error_messages));
			} else {
				date_default_timezone_set('Asia/Colombo');
				$inarray = array(
					'messege' => $this->input->post('message'),
					'contents_idcontents' => $this->input->post('content_id'),
					'students_idstudents' => $this->session->userdata('id_student'),
					'sent_date' => $toDate = $today = date("Y-m-d H:i:s"),
					'is_resolved' => 0
				);
				$res = $this->db->insert('allocation_requests', $inarray);
				if ($res) {
					echo json_encode(array('success' => TRUE));
				} else {
					echo json_encode(array('success' => FALSE, 'error' => 'Request sending failed'));
				}
			}
		}
	}
}
