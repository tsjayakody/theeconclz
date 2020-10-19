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
        $student_verify=0; $card_number="";
        if($student_data['card_number']!=""){
            $this->load->model('student_model');
             $student_verify= $this->student_model->check_student_ids($student_data['card_number']);

             if($student_verify==1){
                $card_number=$student_data['card_number'];
             }else{
                $card_number="N"."-".number_format(strtotime("now"),0,"-","-"); 
             }

        }else{
            $card_number="N"."-".number_format(strtotime("now"),0,"-","-"); 
        }

        $this->first_name = $student_data['first_name'];
        $this->last_name = $student_data['last_name'];
        $this->email = $student_data['email'];
        $this->password = password_hash($student_data['password'], PASSWORD_DEFAULT);
        $this->phone_number = $student_data['phone_number'];
        //$this->active_status = 'active';
        $this->active_status = 'inactive';
        $this->created_at = date('Y-m-d H:i:s');
        $this->id_exam_year = $student_data['al_year'];
        $this->student_id = $card_number;
        $this->student_city = $student_data['student_city'];
        $this->school = $student_data['school'];
        $this->class_student=$student_verify;
        //$this->class_student='';

        return $this->db->insert('students',$this);
    }


    public function check_student_ids($card_number){
        // where are we posting to?
        $url = 'https://aselamallikarathne.com/student_id_cheacking.php';
        // what post fields?
        $fields = array(
            'card' => $card_number,
        );

        // build the urlencoded data
        $postvars = http_build_query($fields);

        // open connection
        $ch = curl_init();

        $token = 'test';

        // set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array("AppToken: $token", "Content-Type: application/x-www-form-urlencoded"));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // execute post
        $result = curl_exec($ch);

        return $result;

        // close connection
        curl_close($ch);
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
