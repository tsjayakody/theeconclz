<div class="content" id="specialRequestsApp">
    <div class="container-fluid">
        <div class="col-md-12">
        	<div class="card" >
				<div class="card-body">
					<h5 class="card-title">All Resolved Requests</h5>
					<div class="toolbar">
						<!--        Here you can write extra buttons/actions for the toolbar              -->
					</div>
					<div class="material-datatables">
						<table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
							<thead>
							<tr>
								<th>Content Name</th>
								<th>Student</th>
								<th>Phone number</th>
								<td>Message</td>
								<th>Requested on</th>
								<th class="disabled-sorting text-right">Actions</th>
							</tr>
							</thead>
							<tfoot>
							<tr>
                                <th>Content Title</th>
								<th>Student</th>
								<th>Phone number</th>
								<th>Massage</th>
								<th>Requested on</th>
								<th class="text-right">Actions</th>
							</tr>
							</tfoot>


							<tbody>
							<tr v-for="(request, index) in requests">
								<td>{{request.title}}</td>
								<td>{{request.first_name}}</td>
								<td>{{request.phone_number}}</td>
								<td>{{request.messege}}</td>
								<td>{{request.sent_date}}</td>
								<td class="text-right td-actions">
									<button type="button" @click="loadtopanel(index)"   class="btn btn-success ">Resolve</button>
									<button type="button" @click="reject(request.idallocation_requests)"   class="btn btn-danger ">Reject</button>
								</td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
        </div>
		<div class="col-md-12">
			<div class="card" id="loader1">
				<div class="card-body">
					<h5 class="card-title">Resolve Panel</h5>

					<hr/>
					<h5 class="m-0">Name: </h5><h6>{{stName}}</h6>
					<h5 class="m-0">Content title: </h5><h6>{{title}}</h6>
					<h5 class="m-0">Message: </h5><h6>{{message}}</h6>


					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="datetimepicker1">Available From</label>
								<input id="datetimepicker1"  type="text" class="form-control datetimepicker" value="<?php date_default_timezone_set('Asia/Colombo'); echo date('Y:m:d h:i A') ?>">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="datetimepicker2">Available until</label>
								<input id="datetimepicker2"  type="text" class="form-control datetimepicker" value="<?php date_default_timezone_set('Asia/Colombo'); echo date('Y:m:d h:i A') ?>">
							</div>
						</div>
					</div>
				</div>

				<div class="card-footer ">
					<button v-if="selectedRequest" type="button" @click="allocateTime" class="btn btn-fill btn-primary">Allocate</button>
				</div>
			</div>
		</div>
    </div>
</div>

<script>

	let specialRequestsApp = new Vue({
		el: '#specialRequestsApp',
		data: {
			requests: '',
			selectedRequest: '',
			stName: '',
			title: '',
			message: '',
			phone_number: '',
			content_id: '',
			student_id: ''
		},
		mounted () {
			this.loadRequests();
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
		methods: {
			loadRequests () {
				axios.get('<?php echo base_url('system_operations/get_all_requests') ?>')
				.then(response => {
					this.requests = response.data.requests;
				})
				.catch(error => {
					console.log(error.response);
				});
			},

			clearAll() {
				this.selectedRequest = '';
				this.stName = '';
				this.title = '';
				this.message = '';
				this.phone_number = '';
				this.content_id = '';
				this.student_id = '';
				specialRequestsApp.loadRequests();
			},

			allocateTime () {
				Notiflix.Block.Standard('#loader1');

				let formData =  new FormData();

				formData.append('request_id', this.selectedRequest);
				formData.append('student_id', this.student_id);
				formData.append('content_id', this.content_id);
				formData.append('phone_number', this.phone_number);
				formData.append('from_date', document.getElementById('datetimepicker1').value);
				formData.append('to_date', document.getElementById('datetimepicker2').value);

				axios({
					method: 'post',
					url: '<?php echo base_url('system_operations/allocate_new_time') ?>',
					data: formData
				})
				.then(response => {
					Notiflix.Block.Remove('#loader1', 600);
					if (response.data.error) {
						// Swal.fire(
						// 		'Error!',
						// 		response.data.error,
						// 		'error'
						// );
						Notiflix.Notify.Failure(response.data.error);
					} else {
						// Swal.fire(
						// 		'Success!',
						// 		'New time allocated.',
						// 		'success'
						// );
						Notiflix.Notify.Success('New time allocated.');
					}
				})
				.catch(error => {
					Notiflix.Block.Remove('#loader1', 600);
					// Swal.fire(
					// 		'Error!',
					// 		'Something went wrong!',
					// 		'error'
					// );
					Notiflix.Notify.Failure('Something went wrong!');
					console.log(error.response);
				})
				.then( function () {
					specialRequestsApp.clearAll();
				});



			},

			loadtopanel (param) {
				let req = this.requests[param];
				this.selectedRequest = req.idallocation_requests;
				this.stName = req.first_name;
				this.title = req.title;
				this.message = req.messege;
				this.phone_number = req.phone_number;
				this.student_id = req.idstudents;
				this.content_id = req.idcontents;

			},

			reject (param) {
				Notiflix.Block.Standard('#loader1');
				Swal.fire({
					title: 'Are you sure?',
					text: "You won't be able to revert this!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, reject it!'
				}).then((result) => {
					Notiflix.Block.Remove('#loader1', 600);
					if (result.value) {

						let formData = new FormData();
						formData.append('request_id', param);

						axios({
							method: 'post',
							url: '<?php echo base_url('system_operations/reject_request') ?>',
							data: formData
						})
						.then(response => {
							if (response.data.error) {
								// Swal.fire(
								// 		'Error!',
								// 		response.data.error,
								// 		'error'
								// );
								Notiflix.Notify.Failure(response.data.error);
							} else {
								// Swal.fire(
								// 		'Rejected!',
								// 		'Request has been rejected.',
								// 		'success'
								// );
								Notiflix.Notify.Success('Request has been rejected.');
							}
						})
						.catch(error => {
							Notiflix.Block.Remove('#loader1', 600);
							// Swal.fire(
							// 		'Error!',
							// 		'Operation failed try again',
							// 		'error'
							// );
							Notiflix.Notify.Failure('Operation failed try again');
						});

					}
				});
			},
		}
	});

</script>
