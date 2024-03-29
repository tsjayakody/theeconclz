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
					<button type="button" v-if="selectedCourse" @click="showSubModal = true"  class="btn btn-fill btn-success">Assign Student</button>
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
									<button class="btn btn-sm btn-danger" v-if="course.is_display == 1"  @click="course_show_hide_alert(index,course.is_display)">Hide</button>
									<button class="btn btn-sm btn-success" v-if="course.is_display == 0"  @click="course_show_hide_alert(index,course.is_display)">Display</button>
								</td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div v-if="showSubModal">
	    <transition name="modal">
	      <div class="modal-mask">
	        <div class="modal-wrapper">
	          <div class="modal-dialog" style="max-width: 90%" role="document">
	            <div class="modal-content">
	              <div class="modal-header">
	                <h5 class="modal-title">Add Subscription To Student</h5>
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                  <span aria-hidden="true" @click="showSubModal = false">&times;</span>
	                </button>
	              	</div>
	              	<div class="modal-body">
	              		<div class="form-row">
	              			<div class="col-md-4 form-group">
	              				<input v-model="student_name" type="text" name="stname" id="stname" class="form-control" placeholder="Name">
	              			</div>
	              			<div class="col-md-4 form-group">
	              				<input v-model="student_email" type="email" name="email" id="email" class="form-control" placeholder="E-Mail">
	              			</div>
	              			<div class="col-md-3 form-group">
	              				<input v-model="student_phone" type="tel" name="phone_number" id="phone_number" class="form-control" placeholder="Phone Number">
	              			</div>
	              			<div class="col-md-1 form-group">
	              				<input v-model="student_id" type="number" name="stid" id="stid" class="form-control" placeholder="ID">
	              			</div>
	              		</div>



	              		<!-- first_name, last_name, Email, phone_number, idstudents -->

					  <div class="table-responsive">
					  	<h3 class="text-center mt-3 text-white bg-dark">Subscription Daterange</h3>
					  	<div class="form-row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="datetimepicker1">From</label>
										<input id="datetimepicker1" type="date" class="form-control">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="datetimepicker2">To</label>
										<input id="datetimepicker2" type="date" class="form-control">
									</div>
								</div>
						</div>
					  	<h3 class="text-center mt-3 text-white bg-dark">Results</h3>
	                    <table class="table">
	                      <thead>
	                        <tr>
	                          <th>Student ID</th>
	                          <th>Student Name</th>
	                          <th>E-Mail</th>
	                          <th>Phone</th>
	                          <th class="text-right">Actions</th>
	                        </tr>
	                      </thead>
	                      <tbody>
	                        <tr v-for="(student, index) in students" v-bind:key="index">
	                          <td>{{student.idstudents}}</td>
	                          <td>{{student.first_name}} {{student.last_name}}</td>
	                          <td>{{student.email}}</td>
	                          <td>{{student.phone_number}}</td>
	                          <td class="td-actions text-right">
	                            <button class="btn btn-success" @click="assignSub(student.idstudents)" type="button">
	                            	Assign
	                            </button>
	                          </td>
	                        </tr>
	                      </tbody>
	                    </table>
	                  </div>	
	              	</div>
	              	<div class="modal-footer">
	                	<button type="button" class="btn btn-secondary" @click="showSubModal = false">Close</button>
	              	</div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </transition>
  	</div>
</div>

<script>
	let updateCourse = new Vue ({

		el: '#updateCourse',
		data: {
			courses: '',
			tableInit: false,
			fload: false,
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
			selectedCategory: '',
			is_display: '',
			showSubModal: false,

			students: '',
			student_name: '',
			student_email: '',
			student_phone: '',
			student_id: '',
			awaitingSearch: false,
		},
		watch: {
			student_name: function() {
				if (!this.awaitingSearch) {
		          setTimeout(() => {
		          	console.log('innnn');
		            this.searchStudent();
		            this.awaitingSearch = false;
		          }, 1500); // 1.5 sec delay
		        }
		        this.awaitingSearch = true;
			},
			student_id: function() {
				if (!this.awaitingSearch) {
		          setTimeout(() => {
		            this.searchStudent();
		            this.awaitingSearch = false;
		          }, 1500); // 1.5 sec delay
		        }
		        this.awaitingSearch = true;
			},
			student_email: function() {
				if (!this.awaitingSearch) {
		          setTimeout(() => {
		            this.searchStudent();
		            this.awaitingSearch = false;
		          }, 1500); // 1.5 sec delay
		        }
		        this.awaitingSearch = true;
			},
			student_phone: function() {
				if (!this.awaitingSearch) {
		          setTimeout(() => {
		            this.searchStudent();
		            this.awaitingSearch = false;
		          }, 1500); // 1.5 sec delay
		        }
		        this.awaitingSearch = true;
			}
		},
		mounted () {
			axios.get('<?php echo base_url('system_operations/get_c_for_update_c') ?>')
				.then(response => {

					this.courses = response.data.courses;
					if (!this.tableInit) {
							this.$nextTick(function() {
								this.initDt()
							});
					}
				})
				.catch(error => {console.log(error.response.data)});

			axios.get('<?php echo base_url('system_operations/get_t_for_add_cu') ?>')
					.then(response => {this.teachers = response.data.teachers})
					.catch(error => {console.log(error.response.data)});

		},
		methods: {
			all_class(){
				if(this.fload==true){ 
					this.delete_datatable();
				}	
				
				this.courses=0;
				axios.get('<?php echo base_url('system_operations/get_c_for_update_c') ?>')
				.then(response => {
					this.courses = response.data.courses;
					if (!this.tableInit) {
							this.$nextTick(function() {
								this.initDt()
							});
					}
				})
				.catch(error => {console.log(error.response.data)});

			axios.get('<?php echo base_url('system_operations/get_t_for_add_cu') ?>')
					.then(response => {this.teachers = response.data.teachers})
					.catch(error => {console.log(error.response.data)});
			},
			initpicker () {
				$('.datetimepicker').datetimepicker({
					format: 'YYYY-MM-DD hh:mm A',
					useCurrent: true,
					showClear: true,
					toolbarPlacement: 'bottom',
					sideBySide: false,
					icons: {
						time: "fa fa-clock-o",
						date: "fa fa-calendar",
						up: "fa fa-arrow-up",
						down: "fa fa-arrow-down",
						previous: "fa fa-chevron-left",
						next: "fa fa-chevron-right",
						today: "fa fa-clock-o",
						clear: "fa fa-trash-alt"
					}
				});
			},

			assignSub (student) {

				if (document.getElementById('datetimepicker1').value === '') {
					Notiflix.Notify.Failure('Please select start date.');
					return false;
				}

				if (document.getElementById('datetimepicker2').value === '') {
					Notiflix.Notify.Failure('Please select end date.');
					return false;
				}

				let formData = new FormData();
				formData.append('course_id', this.selectedCourse);
				formData.append('student_id', student);
				formData.append('from', document.getElementById('datetimepicker1').value);
				formData.append('to', document.getElementById('datetimepicker2').value);

				axios({
					method: 'post',
					url: '<?php echo base_url('system_operations/assign_student_to_course') ?>',
					data: formData
				}).then(response => {
					if (response.data.success) {
						this.showSubModal = false;
						Notiflix.Notify.Success('Student subscribed to the course.');
					} else {
						Notiflix.Notify.Failure('Something went wrong. Try again later.');
					}

				}).catch(error => {
					Notiflix.Notify.Failure('Something went wrong. Try again later.');
				});
			},

			searchStudent () {
				
				let formData = new FormData();
				formData.append('name', this.student_name);
				formData.append('email', this.student_email);
				formData.append('phone', this.student_phone);
				formData.append('id', this.student_id);

				axios({
					method: 'post',
					url: '<?php echo base_url('system_operations/search_student_for_assign_sub') ?>',
					data: formData
				})
				.then(response => {
					this.students = response.data;
				})
				.catch(error => {
					console.log(error);
				})

			},
			deleteCourse (param) {
				Swal.fire({
					title: 'Are you sure?',
					text: "You won't be able to revert this!",
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
			course_show_hide_alert (param,sh) {
				var btn= 'Yes, view it!';
				var val=1;
				if(sh==1){
					btn= 'Yes, hide it!';
					val=0;
				}
				Swal.fire({
					title: 'Are you sure?',
					text: "You won't be able to revert this!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: btn
				}).then((result) => {
					if (result.value) { 
						this.confirmShowHide(param,val);
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

			confirmShowHide(param,val) {

				let formData = new FormData();
				formData.append('course_id', param);
				formData.append('now', val);
				var msg='hidden';
				if(val==1){
					msg='displayed';
				}
				axios({
					method: 'post',
					url: '<?php echo base_url('system_operations/update_view_hide') ?>',
					data : formData
				})
				.then(response => {
					if (response.data.success) {
						updateCourse.all_class();
						// swal("Success!", "Course is deleted.", "success");
						Notiflix.Notify.Success('Class is '+msg+'.');
					} else {
						Notiflix.Notify.Failure('Class is not '+msg+'. Try again.');
						// swal("Error!", "Course is not deleted. Try again.", "error");
					}
				})
				.catch(error => {
					console.log(error);
					// swal("Error!", "Course is not deleted. Try again.", "error");
					Notiflix.Notify.Failure('Course is not display and hide. Try again.');
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
			initDt() {
				$('#datatables').DataTable({
					//destroy: true,
					dom: 'Bfrtip',
					buttons: [
						/*'excel',
						'print'*/
					],
					"pagingType": "full_numbers",
					"lengthMenu": [
						[10, 25, 50, -1],
						[10, 25, 50, "All"]
					],
					responsive: true,
					language: {
						search: "_INPUT_",
						searchPlaceholder: "Search records",
						 
					}
				});
				this.tableInit = false;
				this.fload=true;

			},
			delete_datatable(){
				//this.AllSubs.length=0;  

					$(document).ready(function() { 
						var table = $('#datatables').DataTable();
  						table.clear().destroy();
  						
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
				this.selectedCategory = '';
				this.is_display= '';
			}
		}
	});
</script>

<style scoped>
.modal-mask {
	position: fixed;
	z-index: 9998;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background-color: rgba(0, 0, 0, .5);
	display: table;
	transition: opacity .3s ease;
}

.modal-wrapper {
	display: table-cell;
	vertical-align: middle;
}
</style>
