<div class="content" id="studentDataApp">
	<div class="container-fluid">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-md-4 col-sm-4 col-12 form-group">
							<label for="selectCategory"> Select category</label>
							<select name="selectCategory" v-model="categoryID" v-on:change="getCourses" id="selectCategory" data-style="btn btn-link" class="form-control selectpicker">
								<option value="" selected>Select All</option>
								<?php
								$cts = $this->db->get('course_category');
								foreach ($cts->result_array() as $item) {
									echo '<option value="'.$item['idcourse_category'].'">'.$item['category_name'].'</option>';
								}
								?>
							</select>
						</div>
						<div class="col-md-4 col-sm-4 col-12 form-group">
							<label for="selectCourse"> Select course</label>
							<select name="selectCourse" v-model="courseID" id="selectCourse" data-style="btn btn-link" class="form-control selectpicker">
								<option value="" selected>Select All</option>
								<option v-for="course in courses" v-bind:value="course.idcourses">{{course.course_name}}</option>
							</select>
						</div>
						<div class="col-md-4 col-sm-4 col-12 d-flex flex-column">
							<button @click="getReport" class="btn btn-block btn-success mt-auto">Search</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Report data</h5>
					<div class="toolbar">
						<!--        Here you can write extra buttons/actions for the toolbar              -->
					</div>
					<div class="material-datatables">
						<table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0"
							   width="100%" style="width:100%">
							<thead>
							<tr>
								<th>#</th>
								<th>Course</th>
								<th>Content</th>
								<th>Student</th>
								<th>Phone</th>
								<th>Sent on</th>
								<th>Status</th>
							</tr>
							</thead>
							<tfoot>
							<tr>
								<th>#</th>
								<th>Course</th>
								<th>Content</th>
								<th>Student</th>
								<th>Phone</th>
								<th>Sent on</th>
								<th>Status</th>
							</tr>
							</tfoot>


							<tbody>
							<tr v-for="(row, index) in reportData">
								<td>#{{index+1}}</td>
								<td>{{row.course_name}}</td>
								<td>{{row.title}}</td>
								<td>{{row.first_name}} {{row.last_name}}</td>
								<td>{{row.phone_number}}</td>
								<td>{{row.sent_date}}</td>
								<td v-if="row.is_resolved === '0'" class="text-warning">Pending</td>
								<td v-if="row.is_resolved === '1'" class="text-success">Resolved</td>
								<td v-if="row.is_resolved === '2'" class="text-danger">Rejected</td>
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
			categoryID: '',
			courseID: '',
			courses: '',
			reportData: '',
			tableInit: false
		},
		created () {
			this.getReport();
		},
		methods: {
			getCourses () {
				let formData = new FormData();
				formData.append('category_id', this.categoryID);
				axios({
					method: 'post',
					url: '<?php echo base_url('system_operations/get_courses_for_req_report') ?>',
					data: formData
				}).then(response => {
					if (response.data.error) {
						// swal("Error!", response.data.error, "error");
						Notiflix.Notify.Failure(response.data.error);
					} else {
						this.courses = response.data;
					}
				}).catch(error => {
					console.log(error);
				}).then(function () {
					$("#selectCourse").selectpicker();
					$("#selectCourse").selectpicker("render");
					$("#selectCourse").selectpicker("refresh");
				});
			},

			getReport () {
				let formData = new FormData();
				formData.append('course_id', this.courseID);
				formData.append('category_id', this.categoryID);

				axios({
					method: 'post',
					url: '<?php echo base_url('system_operations/get_special_request_report') ?>',
					data: formData
				}).then(response => {
					if (response.data.error) {
						// swal("Error!", response.data.error, "error");
						Notiflix.Notify.Failure(response.data.error);
						this.reportData = Array;
						if (!this.tableInit) {
							this.$nextTick(function() {
								this.initDt()
							});
						}
					} else {
						this.reportData = response.data;
						if (!this.tableInit) {
							this.$nextTick(function() {
								this.initDt()
							});
						}
					}
				});
			},

			initDt() {
				$('#datatables').DataTable({
					dom: 'Bfrtip',
					buttons: [
						'excel',
						'print'
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
				this.tableInit = true;
			}
		}
	});
</script>

