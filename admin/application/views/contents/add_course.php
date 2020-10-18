<div class="content" id="addCourseApp">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card " id="loaderBlock">
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
							<div class="form-group bmd-form-group">
								<label for="course_name" class="bmd-label-floating">Class Name</label>
								<input v-model="courseName" type="text" class="form-control" id="course_name" required>
								<div class="invalid-feedback" style="display: block">{{form_errors.course_name}}</div>
							</div>

							<div class="form-group bmd-form-group">
								<label for="description" class="bmd-label-floating">Description</label>
								<input v-model="courseDescription" type="text" class="form-control" id="description" required>
								<div class="invalid-feedback" style="display: block">{{form_errors.description}}</div>
							</div>

							<div class="form-group bmd-form-group">
								<label for="fee" class="bmd-label-floating">Course Fee</label>
								<input v-model="monthlyFee" type="text" class="form-control" id="fee" required>
								<div class="invalid-feedback" style="display: block">{{form_errors.monthly_fee}}</div>
							</div>

					</div>
					<div class="card-footer ">
						<button type="button" @click="saveCourse" class="btn btn-fill btn-info">Save</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	let addCourseApp = new Vue({


		el: '#addCourseApp',
		data: function () {
			return {
				teachers: '',
				monthlyFee: '',
				selectedSubject: '',
				selectedSubjectName: '',
				selectedTeacherName: '',
				courseName: '',
				courseDescription: '',
				selectedTeacher: '',
				selectedCategory: '',
				form_errors : {
					course_name: '',
					description: ''
				}
			}
		},
		mounted () {
			axios.get('<?php echo base_url('system_operations/get_t_for_add_c') ?>')
				.then(response => {this.teachers = response.data.teachers})
				.catch(error => {console.log(error.response.data)});
		},
		methods: {
			setSubject: function (event) {
				if (this.selectedTeacher) {
					let teacherid = this.selectedTeacher;
					this.selectedSubject = this.teachers[teacherid].idsubjects;
					this.selectedSubjectName = this.teachers[teacherid].subject_name;
				}
			},
			loadTeachers () {
				axios.get('<?php echo base_url('system_operations/get_t_for_add_c') ?>')
				.then(response => {this.teachers = response.data.teachers})
				.catch(error => {console.log(error.response.data)});
				$('.selectpicker').selectpicker('refresh');
			},
			saveCourse (event) {
				Notiflix.Block.Standard('#loaderBlock');
				event.preventDefault();
				let formData = new FormData();
				formData.append('course_name', this.courseName);
				formData.append('description', this.courseDescription);
				formData.append('teachers_idteachers', this.selectedTeacher);
				formData.append('subjects_idsubjects', this.selectedSubject);
				formData.append('monthly_fee', this.monthlyFee);
				formData.append('course_category', this.selectedCategory);

				if (this.selectedTeacher == "") {
					Notiflix.Block.Remove('#loaderBlock', 600);
					// swal("Error!", "Please select a teacher", "error");
					Notiflix.Notify.Failure('Please select a teacher');
					return false;
				}

				if (this.selectedCategory == "") {
					Notiflix.Block.Remove('#loaderBlock', 600);
					// swal("Error!", "Please select a category", "error");
					Notiflix.Notify.Failure('Please select a category');
					return false;
				}

				axios({

					method: 'post',
					url: '<?php echo base_url('system_operations/save_course') ?>',
					data: formData

				}).then(response => {
					Notiflix.Block.Remove('#loaderBlock', 600);
					console.log(response);
					if (response.data.form_errors) {
						this.form_errors.course_name = response.data.form_errors.course_name;
						this.form_errors.description = response.data.form_errors.description;
						this.form_errors.monthly_fee = response.data.form_errors.monthly_fee;
					}
					if (response.data.error) {
						// swal("Error!", response.data.error, "error");
						Notiflix.Notify.Failure(response.data.error);
					}
					else if (response.data.success) {
						// swal("Success!", "Course is saved.", "success");
						Notiflix.Notify.Success('Course is saved.');
						this.reset();
					}
				}).catch(error => {
					Notiflix.Block.Remove('#loaderBlock', 600);
					// swal("Error!", "Course is not saved. Try again.", "error");
					Notiflix.Notify.Failure('Course is not saved. Try again.');
					console.log(error);

				});
			},
			reset() {
				this.form_errors.description = "";
				this.form_errors.course_name = "";
				this.form_errors.monthly_fee = "";
				this.selectedSubject = "";
				this.selectedSubjectName = "";
				this.selectedTeacher = "";
				this.selectedTeacherName = "";
				this.courseName = "";
				this.courseDescription = "";
				this.monthlyFee = "";
				this.selectedCategory = "";
			}
		}
	});
</script>
