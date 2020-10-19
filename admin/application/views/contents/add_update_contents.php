<div class="content" id="addContentApp">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card " id="loader1">
					<div class="card-header card-header-info">
						<h4 class="card-title">Add Lessons</h4>
					</div>
					<div class="card-body ">
						<div class="row">

							<div class="col-md-3 col-sm-12 col-12">
								<select v-model="selectedCategory" v-on:change="getCourses" data-live-search="true" class="selectpicker" data-size="7" data-style="btn btn-info btn-round" title="Select category">
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

							<div class="col-md-3 col-sm-12 col-12">
								<select id="selectCourse"  v-model="selectedCourse" v-on:change="getAllContents"  data-live-search="true" class="selectpicker" data-size="7" data-style="btn btn-info btn-round" title="Select class">
									<option disabled selected>Select class</option>
									<option v-for="course in courses" v-bind:value="course.idcourses">{{course.course_name}}</option>
								</select>
							</div>

						</div>
						<div class="form-group bmd-form-group" v-bind:class="{ 'is-focused': title }">
							<label for="title" class="bmd-label-floating" >Title</label>
							<input v-model="title" type="text" class="form-control" id="title" required>
							<div class="invalid-feedback" style="display: block">{{form_errors.title}}</div>
						</div>
						<div class="form-group bmd-form-group" v-bind:class="{ 'is-focused': description }">
							<label for="description" class="bmd-label-floating" >Description</label>
							<input v-model="description" type="text" class="form-control" id="description" required>
							<div class="invalid-feedback" style="display: block">{{form_errors.description}}</div>
						</div>
						<div class="form-group bmd-form-group" v-bind:class="{ 'is-focused': videoLink }">
							<label for="videoLink" class="bmd-label-floating" >Video Link</label>
							<input v-model="videoLink" type="text" class="form-control" id="videoLink" required>
							<div class="invalid-feedback" style="display: block">{{form_errors.video_link}}</div>
						</div>
					</div>
					<div class="card-footer ">
						<button v-if="isSave" type="button" @click="saveContent" class="btn btn-fill btn-info">Save</button>
						
						<div v-else>
							<button type="button" @click="updateContent" class="btn btn-fill btn-success">Update</button>
							<button type="button" @click="clearAll" class="btn btn-fill btn-danger">Cancel</button>
						</div>
						
					</div>
				</div>
			</div>

			<div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Contents of lessons</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Title</th>
                          <th>Created At</th>
                          <th class="text-right">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(content, index) in contents">
                          <td>{{content.title}}</td>
                          <td>{{content.created_at}}</td>
                          <td class="td-actions text-right">
                            <button type="button" v-on:click="editContent(index)"  rel="tooltip" class="btn btn-success">
                              Edit
                            </button>
                            <button type="button" v-on:click="deleteContent(index)" rel="tooltip" class="btn btn-danger">
                              Delete
                            </button>
                            <button type="button" v-on:click="timeSlots(index)" rel="tooltip" class="btn btn-info">
                              Timeslots
                            </button>
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


	<div v-if="showModal">
	    <transition name="modal">
	      <div class="modal-mask">
	        <div class="modal-wrapper">
	          <div class="modal-dialog modal-lg" role="document">
	            <div class="modal-content">
	              <div class="modal-header">
	                <h5 class="modal-title">Time Slots</h5>
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                  <span aria-hidden="true" @click="showModal = false">&times;</span>
	                </button>
	              	</div>
	              	<div class="modal-body">

					  <div class="table-responsive">
	                    <table class="table">
	                      <thead>
	                        <tr>
	                          <th>From</th>
	                          <th>To</th>
	                          <th class="text-right">Actions</th>
	                        </tr>
	                      </thead>
	                      <tbody>
	                        <tr v-for="slot in timeslots">
	                          <td>{{slot.available_from}}</td>
	                          <td>{{slot.available_to}}</td>
	                          <td class="td-actions text-right">
	                            <button  type="button" v-on:click="deleteSlot(slot.idavailable_timeslots)"   rel="tooltip" class="btn btn-danger">
	                              Delete
	                            </button>
	                          </td>
	                        </tr>
	                      </tbody>
	                    </table>
	                  </div>

					  
					  	<h5 class="modal-title text-center bg-dark text-white"> Add Timeslot </h5>
						  	<div class="row">
								<div class="col-md-5">
									<div class="form-group">
										<input id="datetimepicker1" @click="initpicker" type="text" class="form-control datetimepicker" value="<?php date_default_timezone_set('Asia/Colombo'); echo date('Y:m:d h:i A') ?>">
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
										<input id="datetimepicker2" @click="initpicker" type="text" class="form-control datetimepicker" value="<?php date_default_timezone_set('Asia/Colombo'); echo date('Y:m:d h:i A') ?>">
									</div>
								</div>
							</div>
				  	
	              	</div>
	              	<div class="modal-footer">
	                	<button type="button" class="btn btn-secondary" @click="showModal = false">Close</button>
	                	<button id="btnLoader" type="button" @click="addtimeslot" class="btn btn-info">Add Timeslot</button>
	              	</div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </transition>
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
					  	<h3 class="text-center mt-3 text-white bg-dark">Results</h5>
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
	                            <button class="btn btn-success" @click="addSub(student.idstudents)" type="button">
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
	let addContentApp = new Vue({
		el: '#addContentApp',
		data: {
			courses: '',
			selectedCategory: '',
			selectedCourse: '',
			title: '',
			description: '',
			videoLink: '',
			isSave: true,
			selectedContent: '',
			form_errors: '',
			contents: '',
			showModal: false,
			showSubModal: true,
			timeslots: '',
			contentForTimeSlot: '',

			
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

		methods: {
			getCourses () {
				let formData = new FormData();
				formData.append('category_id', this.selectedCategory);
				axios({
					method: 'post',
					url: '<?php echo base_url('system_operations/get_c_for_add_ts') ?>',
					data: formData
				}).then(response => {
					if (response.data.error) {
						// swal("Error!", response.data.error, "error");
						Notiflix.Notify.Failure(response.data.error);
					} else {
						this.courses = response.data.courses
					}
				}).catch(error => {
					console.log(error);
				}).then(function () {
					$("#selectCourse").selectpicker();
					$("#selectCourse").selectpicker("render");
					$("#selectCourse").selectpicker("refresh");
				});
			},

			addSub (stid) {
				
			},

			deleteSlot (param) {
				let formData = new FormData();

				formData.append('slot_id', param);

				axios({
					method: 'post',
					url: '<?php echo base_url('system_operations/delete_time_slot') ?>',
					data: formData
				})
				.then(response =>{
					if (response.data.success) {
						this.getContentTimeSlots(this.contentForTimeSlot);
					} 
				})
				.catch(error => {
					// Swal.fire(
					// 	'Failed!',
					// 	'Timeslot is not deleted.',
					// 	'error'
					// );
					Notiflix.Notify.Failure('Timeslot is not deleted.');
					console.log(error.response);
				})
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

			addtimeslot () {
				Notiflix.Block.Standard('#btnLoader');
				let formData = new FormData();

				let from = document.getElementById('datetimepicker1').value;
				let to = document.getElementById('datetimepicker2').value;

				formData.append('content_id', this.contentForTimeSlot);
				formData.append('from_time', from);
				formData.append('to_time', to);

				axios({
					method: 'post',
					url: '<?php echo base_url('system_operations/add_time_slot') ?>',
					data: formData
				})
				.then(response =>{
					Notiflix.Block.Remove('#btnLoader', 600);
					if (response.data.success) {
						this.getContentTimeSlots(this.contentForTimeSlot);
					} 
				})
				.catch(error => {
					Notiflix.Block.Remove('#btnLoader', 600);
					// Swal.fire(
					// 	'Failed!',
					// 	'Timeslot is not added.',
					// 	'error'
					// );
					Notiflix.Notify.Failure('Timeslot is not added.');
					console.log(error.response);
				})
			},

			editContent (params) {
				this.isSave = false;
				this.selectedContent = this.contents[params].idcontents;
				this.title = this.contents[params].title;
				this.description = this.contents[params].description;
				this.videoLink = this.contents[params].video_link;
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

			timeSlots (param) {

				
				
				let content_id = this.contents[param].idcontents;
				this.contentForTimeSlot = content_id;
				this.getContentTimeSlots(content_id);
				this.showModal = true;
			},

			getContentTimeSlots (param) {
				let formData = new FormData();
				formData.append('content_id', param);
				axios({
					method: 'post',
					url: '<?php echo base_url('system_operations/get_timeslots') ?>',
					data: formData
				})
				.then(response => {
					this.timeslots = response.data.timeslots;
				})
				.catch(error => {
					console.log(error.response);
				})
			},

			deleteContent (param) {
				let contentId = this.contents[param].idcontents;
				let formData = new FormData();
				formData.append('content_id', contentId);

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

					axios({
						method: 'post',
						url: '<?php echo base_url('system_operations/delete_content') ?>',
						data: formData
					})
					.then(response => {
						if (response.data.success) {
							// Swal.fire(
							// 	'Deleted!',
							// 	'Content has been deleted.',
							// 	'success'
							// );
							Notiflix.Notify.Success('Content has been deleted.');
							addContentApp.clearAll();
						} else {
							// Swal.fire(
							// 	'Failed!',
							// 	'Content is not deleted.',
							// 	'error'
							// );
							Notiflix.Notify.Failure('Content is not deleted.');
						}
					})
					.catch(error => {
						console.log(error.response);
						// Swal.fire(
						// 	'Failed!',
						// 	'Content is not deleted.',
						// 	'error'
						// );
						Notiflix.Notify.Failure('Content is not deleted.');
					});
				}
				});
			},

			updateContent () {
				Notiflix.Block.Standard('#loader1');
				let formData = new FormData();
				formData.append('content_id', this.selectedContent);
				formData.append('title', this.title);
				formData.append('description', this.description);
				formData.append('video_link', this.videoLink);
				formData.append('course_id', this.selectedCourse);

				axios({
					method: 'post',
					url: '<?php echo base_url('system_operations/update_content') ?>',
					data: formData
				})
				.then(response => {
					Notiflix.Block.Remove('#loader1', 600);
					if (response.data.success) {
						// swal("Success!", "Content updated", "success");
						Notiflix.Notify.Success('Content updated');
						this.isSave = true;
						this.selectedContent = '';
						this.clearAll();
					} else if (response.data.error){
						// swal("Error!", "Content is not updated.", "error");
						Notiflix.Notify.Failure('Content is not updated.');
					} else if (response.data.form_errors) {
						this.form_errors = response.data.form_errors;
					}
				})
				.catch(error => {
					Notiflix.Block.Remove('#loader1', 600);
					// swal("Error!", "Content is not updated.", "error");
					Notiflix.Notify.Failure('Content is not updated.');
				})
			},

			saveContent () {
				Notiflix.Block.Standard('#loader1');
				if (addContentApp.selectedCourse === '') {
					Notiflix.Block.Remove('#loader1', 600);
					// swal("Error!", "Please select a course.", "error");
					Notiflix.Notify.Failure('Please select a course.');
					return false;
				}

				let formData = new FormData();
				formData.append('title' ,this.title);
				formData.append('description', this.description);
				formData.append('video_link', this.videoLink);
				formData.append('course_id', this.selectedCourse);

				axios({
					method: 'post',
					url: '<?php echo base_url('system_operations/save_content') ?>',
					data: formData
				})
				.then(response => {
					Notiflix.Block.Remove('#loader1', 600);
					if (response.data.form_errors) {
						this.form_errors = response.data.form_errors;
					} else if (response.data.error) {
						// swal("Error!", response.data.error, "error");
						Notiflix.Notify.Failure(response.data.error);
					} else if (response.data.success) {
						// swal("Success!", "Content added!", "success");
						Notiflix.Notify.Success('Content added!');
						this.clearAll();
					}

				})
				.catch(error => {
					Notiflix.Block.Remove('#loader1', 600);
					console.log(error.response.data);
					// swal("Error!", "Content is not added please try again.", "error");
					Notiflix.Notify.Failure('Content is not added please try again.');
				});

			},

			getAllContents () {
				let formData = new FormData();
				formData.append('course_id', this.selectedCourse);

				axios({
					method: 'post',
					url: '<?php echo base_url('system_operations/getallcontents'); ?>',
					data: formData,
				})
				.then(response => {
					this.contents = response.data.contents;

				})
				.catch(error => {
					console.log(error.response);
				})
			},

			clearAll () {

				this.title = '';
				this.description = '';
				this.videoLink = '';
				this.isSave = true;
				this.selectedContent = '';
				this.form_errors = '';
				this.getAllContents();
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
