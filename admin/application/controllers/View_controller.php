<?php

class View_controller extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['user_data']) && $this->uri->segment(1) !== null) { // if unlogged client request others than login page

			redirect('/login');

		} elseif (!isset($_SESSION['user_data']) && $this->uri->segment(1) === null) { //if unlogged client request login page

			redirect('/login');

		} elseif (isset($_SESSION['user_data']) && $this->uri->segment(1) === null) {

			redirect('/dashbord');

		}
	}

	// create array for build menu
	public function build_user_menu($view)
	{

		$user_id = $_SESSION['user_data']['id'];
		$user_type = $this->db->select('l_types')->from('user')->join('login_type', 'user.login_type_idlogin_type = login_type.idlogin_type')->where('user.iduser', $user_id)->get()->row()->l_types;
		if ($user_type == 'admin') { // if user has admin rights
			$data = array();
			$main_menu = $this->db->select('*')->from('main_menu')->get(); // get main menu data
			foreach ($main_menu->result_array() as $key => $value) {
				$temp = null;
				$temp = array(
					'idmain_menu' => $value['idmain_menu'],
					'main_menu_name' => $value['title'],
					'main_menu_icon' => $value['icon'],
					'main_nav_class' => " ",
					'area_expand' => false,
					'collaps' => " "
				);
				//get sub menu data
				$sub_menu = $this->db->select('*')->from('sub_menu')->where('main_menu_idmain_menu', $value['idmain_menu'])->get(); // get sub menu data
				foreach ($sub_menu->result_array() as $subkey => $subvalue) {
					$temp['sub_menu'][$subkey] = array(
						'idsub_menu' => $subvalue['idsub_menu'],
						'sub_menu_name' => $subvalue['sub_menu_title'],
						'view' => $subvalue['view'],
						'short_name' => $subvalue['short_name'],
						'sub_item' => " "
					);
					if ($view != null) {
						if ($view == $subvalue['view']) {
							$temp['main_nav_class'] = 'active';
							$temp['area_expand'] = true;
							$temp['collaps'] = 'show';
							$temp['sub_menu'][$subkey]['sub_item'] = 'active';
						}
					}
				}
				$data[] = $temp;
			}
		} else {
			$data = array();
			$main_menu = $this->db
				->select('*')
				->from('user_menu')
				->join('main_menu', 'main_menu.idmain_menu = user_menu.main_menu_idmain_menu')
				->where('user_menu.user_iduser', $user_id)
				->group_by('idmain_menu')
				->get(); // get main menu data

			foreach ($main_menu->result_array() as $key => $value) {
				$temp = null;
				$temp = array(
					'idmain_menu' => $value['idmain_menu'],
					'main_menu_name' => $value['title'],
					'main_menu_icon' => $value['icon'],
					'main_nav_class' => " ",
					'area_expand' => false,
					'collaps' => " "
				);
				//get sub menu data
				$sub_menu = $this->db->select('*')
					->from('user_menu')
					->join('sub_menu', 'sub_menu.idsub_menu = user_menu.sub_menu_idsub_menu')
					->where('user_menu.main_menu_idmain_menu', $value['idmain_menu'])
					->get(); // get sub menu data

				foreach ($sub_menu->result_array() as $subkey => $subvalue) {
					$temp['sub_menu'][$subkey] = array(
						'idsub_menu' => $subvalue['idsub_menu'],
						'sub_menu_name' => $subvalue['sub_menu_title'],
						'view' => $subvalue['view'],
						'short_name' => $subvalue['short_name'],
						'sub_item' => " "
					);
					if ($view != null) {
						if ($view == $subvalue['view']) {
							$temp['main_nav_class'] = 'active';
							$temp['area_expand'] = true;
							$temp['collaps'] = 'show';
							$temp['sub_menu'][$subkey]['sub_item'] = 'active';
						}
					}
				}
				$data[] = $temp;
			}
		}
		return $data;
	}

	// function for dashboard view
	public function dashbord()
	{
		$data = array(
			'menu' => $this->build_user_menu(null),
			'name' => $_SESSION['user_data']['first_name'] . ' ' . $_SESSION['user_data']['last_name'],
			'nav_brand' => 'Dashboard'
		);
		$this->load->view('includes/header', $data);
		$this->load->view('contents/dashbord');
		$this->load->view('includes/footer', array('js' => null));
	}

	public function view_access($view)
	{
		$user_id = $_SESSION['user_data']['id'];
		if (!isset($user_id)) {
			redirect('/login');
		} else {
			$user_type = $this->db->select('l_types')
				->from('user')
				->join('login_type', 'login_type_idlogin_type = idlogin_type')
				->where('iduser', $user_id)
				->get()->row()->l_types;

			if ($user_type == 'admin') {
				return true;
			} else {
				$dt = $this->db->select('*')
					->from('sub_menu')
					->join('access_permissions', 'idsub_menu = sub_menu_idsub_menu')
					->where('access_permissions.is_view', 1)
					->where('sub_menu.view', $view)
					->get()->row()->access_code;
				return $this->user_model->validate_user_access($dt);
			}
		}
	}

	// function for system user management view
	public function manage_system_users()
	{
		$perm = $this->view_access('manage_system_users');
		if ($perm) {
			$data = array(
				'menu' => $this->build_user_menu('manage_system_users'),
				'name' => $_SESSION['user_data']['first_name'] . ' ' . $_SESSION['user_data']['last_name'],
				'nav_brand' => 'Manage System Users'
			);
			$this->load->view('includes/header', $data);
			$this->load->view('contents/manage_system_users');
			$this->load->view('includes/footer', array('js' => 'manage_system_users'));
		} else {
			$data = array(
				'menu' => $this->build_user_menu('manage_system_users'),
				'name' => $_SESSION['user_data']['first_name'] . ' ' . $_SESSION['user_data']['last_name'],
				'nav_brand' => 'No Access'
			);
			$this->load->view('includes/header', $data);
			$this->load->view('contents/noaccess');
			$this->load->view('includes/footer', array('js' => null));
		}
	}

	// function for set user permissions view
	public function set_user_permissions()
	{
		$perm = $this->view_access('set_user_permissions');
		if ($perm) {
			$data = array(
				'menu' => $this->build_user_menu('set_user_permissions'),
				'name' => $_SESSION['user_data']['first_name'] . ' ' . $_SESSION['user_data']['last_name'],
				'nav_brand' => 'Change User Permissions'
			);
			$this->load->view('includes/header', $data);
			$this->load->view('contents/set_user_permissions');
			$this->load->view('includes/footer', array('js' => 'set_user_permissions'));
		} else {
			$data = array(
				'menu' => $this->build_user_menu('set_user_permissions'),
				'name' => $_SESSION['user_data']['first_name'] . ' ' . $_SESSION['user_data']['last_name'],
				'nav_brand' => 'No Access'
			);
			$this->load->view('includes/header', $data);
			$this->load->view('contents/noaccess');
			$this->load->view('includes/footer', array('js' => null));
		}
	}

	// function for view add course
	public function add_course()
	{
		$perm = $this->view_access('add_course');
		if ($perm) {
			$data = array(
				'menu' => $this->build_user_menu('add_course'),
				'name' => $_SESSION['user_data']['first_name'] . ' ' . $_SESSION['user_data']['last_name'],
				'nav_brand' => 'Add New Class'
			);
			$this->load->view('includes/header', $data);
			$this->load->view('contents/add_course');
			$this->load->view('includes/footer', array('js' => null));
		} else {
			$data = array(
				'menu' => $this->build_user_menu('add_course'),
				'name' => $_SESSION['user_data']['first_name'] . ' ' . $_SESSION['user_data']['last_name'],
				'nav_brand' => 'No Access'
			);
			$this->load->view('includes/header', $data);
			$this->load->view('contents/noaccess');
			$this->load->view('includes/footer', array('js' => null));
		}
	}

	// function for view update delete course
	public function update_course()
	{
		$perm = $this->view_access('update_course');
		if ($perm) {
			$data = array(
				'menu' => $this->build_user_menu('update_course'),
				'name' => $_SESSION['user_data']['first_name'] . ' ' . $_SESSION['user_data']['last_name'],
				'nav_brand' => 'Update / Delete Class'
			);
			$this->load->view('includes/header', $data);
			$this->load->view('contents/update_course');
			$this->load->view('includes/footer', array('js' => 'update_records'));
		} else {
			$data = array(
				'menu' => $this->build_user_menu('update_course'),
				'name' => $_SESSION['user_data']['first_name'] . ' ' . $_SESSION['user_data']['last_name'],
				'nav_brand' => 'No Access'
			);
			$this->load->view('includes/header', $data);
			$this->load->view('contents/noaccess');
			$this->load->view('includes/footer', array('js' => null));
		}
	}

	public function add_update_contents()
	{
		$perm = $this->view_access('add_update_contents');
		if ($perm) {
			$data = array(
				'menu' => $this->build_user_menu('add_update_contents'),
				'name' => $_SESSION['user_data']['first_name'] . ' ' . $_SESSION['user_data']['last_name'],
				'nav_brand' => 'Add Update Lession'
			);
			$this->load->view('includes/header', $data);
			$this->load->view('contents/add_update_contents');
			$this->load->view('includes/footer', array('js' => 'add_update_contents'));
		} else {
			$data = array(
				'menu' => $this->build_user_menu('add_update_contents'),
				'name' => $_SESSION['user_data']['first_name'] . ' ' . $_SESSION['user_data']['last_name'],
				'nav_brand' => 'No Access'
			);
			$this->load->view('includes/header', $data);
			$this->load->view('contents/noaccess');
			$this->load->view('includes/footer', array('js' => null));
		}
	}


	public function special_requests()
	{
		$perm = $this->view_access('special_requests');
		if ($perm) {
			$data = array(
				'menu' => $this->build_user_menu('special_requests'),
				'name' => $_SESSION['user_data']['first_name'] . ' ' . $_SESSION['user_data']['last_name'],
				'nav_brand' => 'Manage Specail Requests'
			);
			$this->load->view('includes/header', $data);
			$this->load->view('contents/special_requests');
			$this->load->view('includes/footer', array('js' => 'special_requests'));
		} else {
			$data = array(
				'menu' => $this->build_user_menu('special_requests'),
				'name' => $_SESSION['user_data']['first_name'] . ' ' . $_SESSION['user_data']['last_name'],
				'nav_brand' => 'No Access'
			);
			$this->load->view('includes/header', $data);
			$this->load->view('contents/noaccess');
			$this->load->view('includes/footer', array('js' => null));
		}
	}

	public function active_subs()
	{
		$perm = $this->view_access('active_subs');
		if ($perm) {
			$data = array(
				'menu' => $this->build_user_menu('active_subs'),
				'name' => $_SESSION['user_data']['first_name'] . ' ' . $_SESSION['user_data']['last_name'],
				'nav_brand' => 'Activate Subscriptions'
			);
			$this->load->view('includes/header', $data);
			$this->load->view('contents/active_subs');
			$this->load->view('includes/footer', array('js' => 'active_subs'));
		} else {
			$data = array(
				'menu' => $this->build_user_menu('active_subs'),
				'name' => $_SESSION['user_data']['first_name'] . ' ' . $_SESSION['user_data']['last_name'],
				'nav_brand' => 'No Access'
			);
			$this->load->view('includes/header', $data);
			$this->load->view('contents/noaccess');
			$this->load->view('includes/footer', array('js' => null));
		}
	}


	public function student_data_report()
	{
		$perm = $this->view_access('student_data_report');
		if ($perm) {
			$data = array(
				'menu' => $this->build_user_menu('student_data_report'),
				'name' => $_SESSION['user_data']['first_name'] . ' ' . $_SESSION['user_data']['last_name'],
				'nav_brand' => 'Student data report'
			);
			$this->load->view('includes/header', $data);
			$this->load->view('contents/student_data_report');
			$this->load->view('includes/footer', array('js' => 'student_data_report'));
		} else {
			$data = array(
				'menu' => $this->build_user_menu('student_data_report'),
				'name' => $_SESSION['user_data']['first_name'] . ' ' . $_SESSION['user_data']['last_name'],
				'nav_brand' => 'No Access'
			);
			$this->load->view('includes/header', $data);
			$this->load->view('contents/noaccess');
			$this->load->view('includes/footer', array('js' => null));
		}
	}

	public function change_student_details ()
	{
		$perm = $this->view_access('change_student_details');
		if ($perm) {
			$data = array(
				'menu' => $this->build_user_menu('change_student_details'),
				'name' => $_SESSION['user_data']['first_name'] . ' ' . $_SESSION['user_data']['last_name'],
				'nav_brand' => 'Change student details'
			);
			$this->load->view('includes/header', $data);
			$this->load->view('contents/change_student_details');
			$this->load->view('includes/footer', array('js' => null));
		} else {
			$data = array(
				'menu' => $this->build_user_menu('change_student_details'),
				'name' => $_SESSION['user_data']['first_name'] . ' ' . $_SESSION['user_data']['last_name'],
				'nav_brand' => 'No Access'
			);
			$this->load->view('includes/header', $data);
			$this->load->view('contents/noaccess');
			$this->load->view('includes/footer', array('js' => null));
		}
	}

	public function course_categories ()
	{
		$perm = $this->view_access('course_categories');
		if ($perm) {
			$data = array(
				'menu' => $this->build_user_menu('course_categories'),
				'name' => $_SESSION['user_data']['first_name'] . ' ' . $_SESSION['user_data']['last_name'],
				'nav_brand' => 'Add update class categories'
			);
			$this->load->view('includes/header', $data);
			$this->load->view('contents/course_categories');
			$this->load->view('includes/footer', array('js' => null));
		} else {
			$data = array(
				'menu' => $this->build_user_menu('course_categories'),
				'name' => $_SESSION['user_data']['first_name'] . ' ' . $_SESSION['user_data']['last_name'],
				'nav_brand' => 'No Access'
			);
			$this->load->view('includes/header', $data);
			$this->load->view('contents/noaccess');
			$this->load->view('includes/footer', array('js' => null));
		}
	}

	public function course_subscription_report ()
	{
		$perm = $this->view_access('course_subscription_report');
		if ($perm) {
			$data = array(
				'menu' => $this->build_user_menu('course_subscription_report'),
				'name' => $_SESSION['user_data']['first_name'] . ' ' . $_SESSION['user_data']['last_name'],
				'nav_brand' => 'Class Subscription Report'
			);
			$this->load->view('includes/header', $data);
			$this->load->view('contents/course_subscription_report');
			$this->load->view('includes/footer', array('js' => null));
		} else {
			$data = array(
				'menu' => $this->build_user_menu('course_subscription_report'),
				'name' => $_SESSION['user_data']['first_name'] . ' ' . $_SESSION['user_data']['last_name'],
				'nav_brand' => 'No Access'
			);
			$this->load->view('includes/header', $data);
			$this->load->view('contents/noaccess');
			$this->load->view('includes/footer', array('js' => null));
		}
	}

	public function special_request_report ()
	{
		$perm = $this->view_access('special_request_report');
		if ($perm) {
			$data = array(
				'menu' => $this->build_user_menu('special_request_report'),
				'name' => $_SESSION['user_data']['first_name'] . ' ' . $_SESSION['user_data']['last_name'],
				'nav_brand' => 'Special Request Report'
			);
			$this->load->view('includes/header', $data);
			$this->load->view('contents/special_request_report');
			$this->load->view('includes/footer', array('js' => null));
		} else {
			$data = array(
				'menu' => $this->build_user_menu('special_request_report'),
				'name' => $_SESSION['user_data']['first_name'] . ' ' . $_SESSION['user_data']['last_name'],
				'nav_brand' => 'No Access'
			);
			$this->load->view('includes/header', $data);
			$this->load->view('contents/noaccess');
			$this->load->view('includes/footer', array('js' => null));
		}
	}
}
