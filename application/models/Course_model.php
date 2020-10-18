<?php
class Course_model extends CI_Model {


	public function getStudentSubscribedCourses ($student_id) {

		// get all active subscriptions for student
		return $this->db	->select('*')
							->from('subscriptions')
							->join('courses', 'subscriptions.courses_idcourses = courses.idcourses')
							->join('subjects', 'courses.subjects_idsubjects = subjects.idsubjects')
							->join('teachers', 'courses.teachers_idteachers = teachers.idteachers')
							->where('subscriptions.students_idstudents', $student_id)
							->get();
	}

	public function getContentsOfCourse ($course_id) {

		// get all the contents of the course
		return $this->db	->select('*')
							->from('contents')
							->where('courses_idcourses', $course_id)
							->get();
	}


}
