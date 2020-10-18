<div class="content" id="studentDataApp">
	<div class="container-fluid">
		<div class="col-md-12">
			<div class="card" id="loadingdiv">
				<div class="card-body">
					<h5 class="card-title mb-4">Update details</h5>
					<div class="row">


						<div class="col-md-6 col-sm-12 col-12">
							<div class="input-group mb-3">
								<input @click="formErrors.first_name = ''" type="text" class="form-control" placeholder="First name" v-model="student.first_name">
								<div class="invalid-feedback" style="display: block" >{{formErrors.first_name}}</div>
							</div>
						</div>

						<div class="col-md-6 col-sm-12 col-12">
							<div class="input-group mb-3">
								<input @click="formErrors.last_name = ''" type="text" class="form-control" placeholder="Last name" v-model="student.last_name">
								<div class="invalid-feedback" style="display: block" >{{formErrors.last_name}}</div>
							</div>
						</div>

						<div class="col-md-6 col-sm-12 col-12">
							<div class="input-group mb-3">
								<input @click="formErrors.phone_number = ''" type="text" class="form-control" placeholder="Phone number" v-model="student.phone_number">
								<div class="invalid-feedback" style="display: block" >{{formErrors.phone_number}}</div>
							</div>
						</div>

						<div class="col-md-6 col-sm-12 col-12">
							<div class="input-group mb-3">
								<input @click="formErrors.email = ''" type="text" class="form-control" placeholder="E-Mail" v-model="student.email">
								<div class="invalid-feedback" style="display: block" >{{formErrors.email}}</div>
							</div>
						</div>

						<div class="col-md-6 col-sm-12 col-12">
							<div class="input-group mb-3">
								<input @click="formErrors.school = ''" type="text" class="form-control" placeholder="School" v-model="student.school">
								<div class="invalid-feedback" style="display: block" >{{formErrors.school}}</div>
							</div>
						</div>

						<div class="col-md-6 col-sm-12 col-12">
							<div class="input-group mb-3">
								<input @click="formErrors.student_city = ''" type="text" class="form-control" placeholder="City" v-model="student.student_city">
								<div class="invalid-feedback" style="display: block" >{{formErrors.student_city}}</div>
							</div>
						</div>

						<div class="col-md-6 col-sm-12 col-12" v-if="student.idstudents">
							<div class="input-group mb-3">
								<button v-on:click="updateStudent" class="btn btn-block btn-success">Update</button>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Student data</h5>
					<div class="material-datatables">
						<table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0"
							   width="100%" style="width:100%">
							<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Phone Number</th>
								<th>School</th>
								<th>City</th>
								<th class="text-center">Action</th>
							</tr>
							</thead>
							<tbody>
							<tr v-for="(student, index) in students">
								<td>{{student.first_name}} {{student.last_name}}</td>
								<td>{{student.email}}</td>
								<td>{{student.phone_number}}</td>
								<td>{{student.school}}</td>
								<td>{{student.student_city}}</td>
								<td>
									<button class="btn btn-sm btn-success" v-on:click="getStudentData(student.idstudents)">Edit</button>
									<button class="btn btn-sm btn-danger" v-on:click="deleteStudent(student.idstudents, index)">Delete</button>
								</td>
							</tr>
							</tbody>
							<tfoot>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Phone Number</th>
								<th>School</th>
								<th>City</th>
								<th class="text-center">Action</th>
							</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function () {
		$('#datatables').DataTable();
	});
</script>

<script>
	let updateApp = new Vue({
		el: '#studentDataApp',
		data: {
			students: '',
			student: {
				first_name: '',
				last_name: '',
				email: '',
				phone_number: '',
				school: '',
				student_city: ''
			},
			formErrors: {
				first_name: '',
				last_name: '',
				email: '',
				phone_number: '',
				school: '',
				student_city: ''
			}
		},
		created () {
			this.getAllStudents();

		},
		methods: {
			deleteStudent (studentID, index) {
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
						this.confirmDelete(studentID, index);
					}
				});
			},
			confirmDelete (param, index) {

				let formData = new FormData();
				formData.append('student_id', param);

				axios({
					method: 'post',
					url: '<?php echo base_url('system_operations/delete_student') ?>',
					data : formData
				})
				.then(response => {
					if (response.data.success) {
						this.$delete(this.students, index);
						Notiflix.Notify.Success('Student is deleted.');
					} else {
						Notiflix.Notify.Failure('Student is not deleted. Try again.');
					}
				})
				.catch(error => {
					console.log(error);
					Notiflix.Notify.Failure('Student is not deleted. Try again.');
				});
			},
			getAllStudents () {
				axios.get('<?php echo base_url('system_operations/get_all_students') ?>').then(response => {this.students = response.data});
			},

			getStudentData (studentID) {
				Notiflix.Block.Standard('#loadingdiv');
				let formData = new FormData();
				formData.append('student_id', studentID);
				axios({
					method: 'post',
					url: '<?php echo base_url('system_operations/get_student_data_for_update') ?>',
					data: formData
				}).then(response => {
					if (response.data.error) {
						Notiflix.Notify.Failure(response.data.error);
					} else {
						this.student = response.data;
					}
				}).catch(error => {
					console.log(error);
				}).then(function () {
					Notiflix.Block.Remove('#loadingdiv', 600);
				});
			},

			updateStudent () {
				Notiflix.Block.Standard('#loadingdiv');
				let formData = new FormData();
				formData.append('student_id', this.student.idstudents);
				formData.append('first_name', this.student.first_name);
				formData.append('last_name', this.student.last_name);
				formData.append('email', this.student.email);
				formData.append('phone_number', this.student.phone_number);
				formData.append('school', this.student.school);
				formData.append('student_city', this.student.student_city);
				axios({
					method: 'post',
					url: '<?php echo base_url('system_operations/update_student_data') ?>',
					data: formData
				}).then(response => {
					if (response.data.error) {
						Notiflix.Notify.Failure(response.data.error);
					} else if (response.data.form_errors) {
						this.formErrors = response.data.form_errors;
					} else {
						Notiflix.Notify.Success('Student updated successfully.');
						this.getAllStudents();
						this.student.idstudents = '';
						this.student.first_name = '';
						this.student.last_name = '';
						this.student.email = '';
						this.student.phone_number = '';
						this.student.school = '';
						this.student.student_city = '';
					}
				}).catch(error => {
					console.log(error);
				}).then(function () {
					Notiflix.Block.Remove('#loadingdiv', 600);
				});
			}
		}
	});
</script>

