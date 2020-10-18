<div class="content" id="updateCourse">
	<div class="container-fluid">
		<div class="col-md-12">
			<div class="card " id="loader1">
				<div class="card-header card-header-info">
					<h4 class="card-title">Add Class</h4>
				</div>
				<div class="card-body ">

					<div class="row">
						<div class="col-md-3 col-sm-12 col-12">

							<select v-model="selectedTeacher" v-on:change="setSubject" data-live-search="true" class="selectpicker" data-size="7" data-style="btn btn-info btn-round" title="Select teacher">
								<option disabled selected>Select teacher</option>
								


								<?php

									$this->db->select('*');
									$this->db->from('teachers');
									$this->db->join('subjects', 'idsubjects = subjects_idsubjects');
									$teachersObject = $this->db->get();

									if ($teachersObject->num_rows() > 0) {
										$array = array();
										foreach ($teachersObject->result_array() as $key => $value) {
											echo '<option value="'.$value['idteachers'].'" >'.$value['teachers_name'].'</option>';
										}
									} 

								?>
							</select>

						</div>

						<div class="col-md-3 col-sm-12 col-12">

							<select v-model="selectedCategory" data-live-search="true" class="selectpicker" data-size="7" data-style="btn btn-info btn-round" title="Select category">
								<option disabled selected>Select category</option>

								<?php
								$category = $this->db->get('course_category');

								if ($category->num_rows() > 0) {
									foreach ($category->result_array() as $key => $value) {
										echo '<option value="'.$value['idcourse_category'].'" >'.$value['category_name'].'</option>';
									}
								}

								?>

							</select>

						</div>

						<div class="col-md-6 col-sm-12 col-12">

							<h3>Subject: <span>{{selectedSubjectName}}</span></h3>

						</div>
					</div>
					<div class="form-group bmd-form-group " v-bind:class="{ 'is-focused': courseName }">
						<label for="course_name" class="bmd-label-floating">Class Name</label>
						<input v-model="courseName" type="text" class="form-control" id="course_name" required>
						<div class="invalid-feedback" style="display: block">{{form_errors.course_name}}</div>
					</div>

					<div class="form-group bmd-form-group " v-bind:class="{ 'is-focused': courseDescription }">
						<label for="description" class="bmd-label-floating">Description</label>
						<input v-model="courseDescription" type="text" class="form-control" id="description" required>
						<div class="invalid-feedback" style="display: block">{{form_errors.description}}</div>
					</div>

					<div class="form-group bmd-form-group " v-bind:class="{ 'is-focused': monthlyFee }">
						<label for="monthlyFee" class="bmd-label-floating">Monthly Fee</label>
						<input v-model="monthlyFee" type="text" class="form-control" id="monthlyFee" required>
						<div class="invalid-feedback" style="display: block">{{form_errors.monthly_fee}}</div>
					</div>

				</div>
				<div class="card-footer ">
					<button type="button" @click="updateCourse"  class="btn btn-fill btn-info">Update</button>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="toolbar">
						<!--        Here you can write extra buttons/actions for the toolbar              -->
					</div>
					<div class="material-datatables">
						<table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
							<thead>
							<tr>
								<th>Class name</th>
								<th>Class fee</th>
								<th>Teacher</th>
								<th>Subject</th>
								<th>Category</th>
								<th class="disabled-sorting text-right">Actions</th>
							</tr>
							</thead>
							<tfoot>
							<tr>
								<th>Class name</th>
								<th>Class fee</th>
								<th>Teacher</th>
								<th>Subject</th>
								<th>Category</th>
								<th class="text-right">Actions</th>
							</tr>
							</tfoot>


							<tbody>
							<tr v-for="( course, index ) in courses">
								<td>{{course.course_name}}</td>
								<td>{{course.monthly_fee}}</td>
								<td>{{course.teachers_name}}</td>
								<td>{{course.subject_name}}</td>
								<td>{{course.category_name}}</td>
								<td class="text-right">
									<a href="#" @click="editCourse(index)" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">dvr</i></a>
									<a href="#" @click="deleteCourse(index)" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a>
								</td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	let updateCourse = new Vue ({

		el: '#updateCourse',
		data: {
			courses: '',


			teachers: '',
			monthlyFee: '',
			selectedSubject: '',
			selectedSubjectName: '',
			selectedTeacherName: '',
			courseName: '',
			courseDescription: '',
			selectedTeacher: '',
			form_errors : '',
			selectedCourse: '',
			selectedCategory: ''
		},
		mounted () {
			axios.get('<?php echo base_url('system_operations/get_c_for_update_c') ?>')
				.then(response => {this.courses = response.data.courses})
				.catch(error => {console.log(error.response.data)});

			axios.get('<?php echo base_url('system_operations/get_t_for_add_cu') ?>')
					.then(response => {this.teachers = response.data.teachers})
					.catch(error => {console.log(error.response.data)});

		},
		methods: {
			deleteCourse (param) {
				Swal.fire({
					title: 'Are you sure?',
					text: "This action will delete all the related data in the databse. You won't be able to revert this!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.value) {
						this.confirmDelete(param);
					}
				});
			},
			setSubject: function (event) {
				if (this.selectedTeacher) {
					let teacherid = this.selectedTeacher;
					this.selectedSubject = this.teachers[teacherid].idsubjects;
					this.selectedSubjectName = this.teachers[teacherid].subject_name;
				}
			},
			editCourse (param) {
				$('.selectpicker').selectpicker('refresh');
				let courseitem = this.courses[param];
				this.selectedSubject = courseitem.idsubjects;
				this.selectedTeacher = courseitem.idteachers;
				this.selectedSubjectName = courseitem.subject_name;
				this.selectedTeacherName = courseitem.teachers_name;
				this.courseDescription = courseitem.description;
				this.selectedCourse = courseitem.idcourses;
				this.monthlyFee = courseitem.monthly_fee;
				this.courseName = courseitem.course_name;
				this.selectedCategory = courseitem.idcourse_category;
				$('.selectpicker').val(this.selectedTeacher);

				$('.selectpicker').selectpicker('render');
			},

			confirmDelete (param) {

				let formData = new FormData();
				formData.append('course_id', param);

				axios({
					method: 'post',
					url: '<?php echo base_url('system_operations/delete_course') ?>',
					data : formData
				})
				.then(response => {
					if (response.data.success) {
						this.$delete(this.courses, param);
						// swal("Success!", "Course is deleted.", "success");
						Notiflix.Notify.Success('Course is deleted.');
					} else {
						Notiflix.Notify.Failure('Course is not deleted. Try again.');
						// swal("Error!", "Course is not deleted. Try again.", "error");
					}
				})
				.catch(error => {
					console.log(error);
					// swal("Error!", "Course is not deleted. Try again.", "error");
					Notiflix.Notify.Failure('Course is not deleted. Try again.');
				});
			},
			updateCourse () {
				Notiflix.Block.Standard('#loader1');
				let formData = new FormData();
				formData.append('course_name', this.courseName);
				formData.append('description', this.courseDescription);
				formData.append('teacher_id', this.selectedTeacher);
				formData.append('subject_id', this.selectedSubject);
				formData.append('course_id', this.selectedCourse);
				formData.append('monthly_fee', this.monthlyFee);
				formData.append('category_id', this.selectedCategory);

				if (this.selectedCourse === '') {
					// swal("Error!", "Please select a course.", "error");
					Notiflix.Notify.Failure('Please select a course.');
					Notiflix.Block.Remove('#loader1', 600);
					return false;
				}

				axios({
					method: 'post',
					url: '<?php echo base_url('system_operations/update_course') ?>',
					data: formData
				})
				.then(response => {
					Notiflix.Block.Remove('#loader1', 600);
					if (response.data.form_errors) {
						this.form_errors = response.data.form_errors;
					}
					if (response.data.error) {
						// swal("Error!", "Course is not updated.", "error");
						Notiflix.Notify.Failure('Course is not updated.');
					}
					else if (response.data.success) {
						swal("Success!", "Course is updated.", "success");
						this.courses[this.selectedCourse].course_name = this.courseName;
						this.courses[this.selectedCourse].description = this.courseDescription;
						this.courses[this.selectedCourse].idcourse = this.selectedCourse;
						this.courses[this.selectedCourse].idteachers = this.selectedTeacher;
						this.courses[this.selectedCourse].teachers_name = this.selectedTeacherName;
						this.courses[this.selectedCourse].subject_name = this.selectedSubjectName;
						this.courses[this.selectedCourse].monthly_fee = this.monthlyFee;
						this.courses[this.selectedCourse].idcourse_category = this.selectedCategory;
						this.resetAll();
					}

				})
				.catch(error => {
					Notiflix.Block.Remove('#loader1', 600);
					// swal("Error!", "Course is not updated. Try again.", "error");
					Notiflix.Notify.Failure('Course is not updated. Try again.');
					console.log(error);
				});
			},
			resetAll () {
				this.selectedSubject= '';
				this.selectedSubjectName= '';
				this.selectedTeacherName= '';
				this.courseName= '';
				this.courseDescription= '';
				this.selectedTeacher= ''
				this.form_errors.course_name = '';
				this.form_errors.description = '';
				this.selectedCourse= '';
				this.monthlyFee= '';
				this.selectedCategory = ''
			}
		}
	});
</script>
