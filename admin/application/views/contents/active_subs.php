<div class="content" id="activeSub">
	<div class="container-fluid">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Set Date Range</h5>

					<hr/>
					<div class="row">
						<div class="col-md-4">
							<h5 class="m-0">Start Date: </h5><h6 class="inline">{{startDate}}</h6>
						</div>
						<div class="col-md-4">
							<h5 class="m-0">End Date: </h5><h6>{{endDate}}</h6>
						</div>
						<div class="col-md-4">
							<h5 class="m-0">Available For: </h5><h6 class="">{{availableFor}} Days</h6>
						</div>
					</div>


					<hr/>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="datetimepicker1">Start Date</label>
								<input id="datetimepicker1" type="text" class="form-control datetimepicker"
									   value="<?php date_default_timezone_set('Asia/Colombo');
									   echo date('Y:m:d') ?>">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="datetimepicker2">End Date</label>
								<input id="datetimepicker2" type="text" class="form-control datetimepicker"
									   value="<?php date_default_timezone_set('Asia/Colombo');
									   echo date('Y:m:d') ?>">
							</div>
						</div>
					</div>
				</div>

				<div class="card-footer ">
					<button type="button" @click="setRange" class="btn btn-fill btn-info">Set Range</button>
				</div>
			</div>
		</div>

		<div class="col-md-12" id="loadingBlock">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Subscriptions</h5>
					<div class="toolbar">
						<div class="row">
							<div class="col-md-4 col-sm-4 col-12 form-group">
							<label for=""> Select Year</label>
							<select name="" id="" data-style="btn btn-link" class="form-control selectpicker">
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
							<label for=""> Select Year</label>
							<select name="" id="" data-style="btn btn-link" class="form-control selectpicker">
								<option value="" selected>Select All</option>
								<?php
								$cts = $this->db->get('course_category');
								foreach ($cts->result_array() as $item) {
									echo '<option value="'.$item['idcourse_category'].'">'.$item['category_name'].'</option>';
								}
								?>
							</select>
						</div>
						</div>
					</div>
					<div class="material-datatables">
						<table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0"
							   width="100%" style="width:100%">
							<thead>
							<tr>
								<th>Class name</th>
								<th>student name</th>
								<th>Reference Number</th>
								<th>Phone Number</th>
								<th class="disabled-sorting text-right">Actions</th>
							</tr>
							</thead>
							<tfoot>
							<tr>
								<th>Class name</th>
								<th>student name</th>
								<th>Reference Number</th>
								<th>Phone Number</th>
								<th class="text-right">Actions</th>
							</tr>
							</tfoot>


							<tbody>
							<tr v-for="(sub, index) in AllSubs">
								<td>{{sub.course_name}}</td>
								<td>{{sub.first_name}}</td>
								<td>{{sub.reference_number}}</td>
								<td>{{sub.phone_number}}</td>
								<td class="text-right td-actions">
									<button v-if="startDate" type="button" @click="allowSub(sub.idsubscriptions)"
											class="btn btn-success ">Activate
									</button>
									<button type="button" @click="deleteSub(sub.idsubscriptions)"
											class="btn btn-danger ">Delete
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

<script>
	let activeSub = new Vue({
		el: '#activeSub',
		data: {
			startDate: '',
			endDate: '',
			availableFor: 0,
			AllSubs: ''
		},
		mounted() {
			$('.datetimepicker').datetimepicker({
				format: 'YYYY-MM-DD',
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
			this.getAllnonAllowedSubs();
		},
		methods: {
			allowSub(subid) {

				Notiflix.Block.Standard('#loadingBlock');
				let formData = new FormData();
				formData.append('sub_id', subid);
				formData.append('start_date', this.startDate);
				formData.append('end_date', this.endDate);

				axios({
					method: 'post',
					url: '<?php echo base_url('system_operations/allow_sub') ?>',
					data: formData
				}).then(response => {

					if (response.data.success === false) {
						// Swal.fire('Error!', 'Operation failed try again.', 'error');
						Notiflix.Notify.Failure('Operation failed try again.');
					} else {
						// Swal.fire('Activated!', 'Subscription has been activated.', 'success');
						Notiflix.Notify.Success('Subscription has been activated.');
					}
				}).catch(error => {
					// Swal.fire('Error!', 'Operation failed try again.', 'error');
					Notiflix.Notify.Failure('Operation failed try again.');
				}).then( function () {
					Notiflix.Block.Remove('#loadingBlock', 600);
					activeSub.getAllnonAllowedSubs();
				});
			},
			deleteSub(subid) {
				let formData = new FormData();
				formData.append('sub_id', subid);
				Notiflix.Block.Standard('#loadingBlock');

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
							url: '<?php echo base_url('system_operations/delete_sub') ?>',
							data: formData
						}).then(response => {
							if (response.data.success === false) {
								// Swal.fire('Error!', 'Operation failed try again.', 'error');
								Notiflix.Notify.Failure('Operation failed try again.');
							} else {
								// Swal.fire('Deleted!', 'Subscription has been deleted.', 'success');
								Notiflix.Notify.Success('Subscription has been deleted.');
							}
						}).catch(error => {
							// Swal.fire('Error!', 'Operation failed try again.', 'error');
							Notiflix.Notify.Failure('Operation failed try again.');
						}).then( function () {
							Notiflix.Block.Remove('#loadingBlock', 600);
							activeSub.getAllnonAllowedSubs();
						});
					}
				});
			},
			setRange() {
				let sdate = document.getElementById('datetimepicker1').value;
				let edate = document.getElementById('datetimepicker2').value;

				this.startDate = sdate;
				this.endDate = edate;

				let dateFrom = new Date(sdate);
				let dateUntil = new Date(edate);

				let Difference_In_Time = dateUntil.getTime() - dateFrom.getTime();

				this.availableFor = Difference_In_Time / (1000 * 3600 * 24);
			},

			getAllnonAllowedSubs() {

				axios.get('<?php echo base_url('system_operations/get_all_non_allowed_subs') ?>')
						.then(response => {
							this.AllSubs = response.data.subs;
						})
						.catch(error => {
							console.log(error.response);
						})
			}
		}
	})
</script>
