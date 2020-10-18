<?php  

class Student_model extends CI_Model {

    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $phone_number;
    public $active_status;
    public $created_at;

    // creates a new stuent in the database
    public function create_student($student_data)
    {
        date_default_timezone_set('Asia/Colombo');

        $this->first_name = $student_data['first_name'];
        $this->last_name = $student_data['last_name'];
        $this->email = $student_data['email'];
        $this->password = password_hash($student_data['password'], PASSWORD_DEFAULT);
        $this->phone_number = $student_data['phone_number'];
        $this->active_status = 'inactive';
        $this->created_at = date('Y-m-d H:i:s');

        return $this->db->insert('students',$this);
    }

    // retrieve student by student code
    public function search_student_by_email($email)
    {
        $student = FALSE;
        $row = $this->db->select('*')
                        ->from('students')
                        ->where('email',$email)
                        ->get();

        if($row->num_rows() > 0){
            $student = $row->row_array();
        } else {
            $student = FALSE;
        }

        return $student;
    }

	// retrieve student by student code
	public function search_student_by_phone($phone)
	{
		$student = FALSE;
		$row = $this->db->select('*')
			->from('students')
			->where('phone_number',$phone)
			->get();

		if($row->num_rows() > 0){
			$student = $row->row_array();
		} else {
			$student = FALSE;
		}

		return $student;
	}

    // update student data in the students table
    public function update_student_password($data, $id)
    {
        $new_password = password_hash($data['password'], PASSWORD_DEFAULT);
        $response = $this->db->where('idstudents',$id)->update('students',array('password'=>$new_password));
        return $response;
    }
}
