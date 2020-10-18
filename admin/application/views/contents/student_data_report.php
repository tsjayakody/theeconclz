<div class="content" id="studentDataApp">
	<div class="container-fluid">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Student data</h5>
					<div class="toolbar">
						<!--        Here you can write extra buttons/actions for the toolbar              -->
					</div>
					<div class="material-datatables">
						<table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0"
							   width="100%" style="width:100%">
							<thead>
							<tr>
								<th>Name</th>
								<th>ID</th>
								<th>Email</th>
								<th>Phone Number</th>
								<th>Al-Year</th>
								<th>School</th>
								<th>City</th>
								<th>Joined On</th>
							</tr>
							</thead>
							<tfoot>
							<tr>
								<th>Name</th>
								<th>ID</th>
								<th>Email</th>
								<th>Phone Number</th>
								<th>Al-Year</th>
								<th>School</th>
								<th>City</th>
								<th>Joined On</th>
							</tr>
							</tfoot>


							<tbody>
							<tr v-for="student in students">
								<td>{{student.first_name}} {{student.last_name}}</td>
								<td>{{student.	student_id}} </td>
								<td>{{student.email}}</td>
								<td>{{student.phone_number}}</td>
								<td>{{student.years}}</td>
								<td>{{student.school}}</td>
								<td>{{student.student_city}}</td>
								<td>{{student.created_at}}</td>
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
	let studentDataApp = new Vue({
		el: '#studentDataApp',
		data: {
			students: ''
		},
		mounted () {
			this.getAllStudents()
		},
		methods: {
			getAllStudents () {
				axios.get('<?php echo base_url('system_operations/getAllStudents') ?>')
				.then(response => {
					this.students = response.data.students;
				})
				.catch(error => {
					console.log(error.response);
				})
			}
		}
	});
</script>
