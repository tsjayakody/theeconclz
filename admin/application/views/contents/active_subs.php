<div class="content" id="activeSub">
	<div class="container-fluid">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Set Date Range</h5>

					<hr/>
					<div class="row">
						<div class="col-md-3 col-sm-12 col-12">
							<select v-model="selectedCategory" v-on:change="getCourses" data-live-search="true" class="selectpicker" data-size="7" data-style="btn btn-info btn-round" title="Select year">
								<option disabled selected>Select year</option>
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
							<select id="selectCourse"  v-model="selectedCourse" v-on:change="getAllnonAllowedSubs"  data-live-search="true" class="selectpicker" data-size="7" data-style="btn btn-info btn-round" title="Select class">
								<option disabled selected value="">Select class</option>
								<option v-for="course in courses" v-bind:value="course.idcourses">{{course.course_name}}</option>
							</select>
						</div>
					</div>		

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

						<div class="col-md-4">
							<div class="form-group">
								<label for="datetimepicker1">Start Date</label>
								<input id="datetimepicker1" type="text" class="form-control datetimepicker"
									   value="<?php date_default_timezone_set('Asia/Colombo');
									   echo date('Y:m:d') ?>">
							</div>
						</div>

						<div class="col-md-4">
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
					<button v-if="selectedCourse" @click="getAllAllowedSubs" type="button" class="btn btn-fill btn-success">Allowed Subscriptions</button>
				</div>
			</div>
		</div>

		<div class="col-md-12" id="loadingBlock">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Subscriptions</h5>
					<div class="toolbar">
						<!--        Here you can write extra buttons/actions for the toolbar              -->
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
	<div v-if="showModal">
	    <transition name="modal">
	      <div class="modal-mask">
	        <div class="modal-wrapper">
	          <div class="modal-dialog" style="max-width: 90%" role="document">
	            <div class="modal-content" id="allowedLodingBlock">
	              <div class="modal-header">
	                <h5 class="modal-title">Allowed Subscriptions</h5>
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                  <span aria-hidden="true" @click="showModal = false">&times;</span>
	                </button>
	              	</div>

	              	<div class="modal-body">
	              		<div class="material-datatables">
							<table id="allowed_datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0"
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
									<tr v-for="(sub, index) in allAllowedSubs" v-bind:key="index">
										<td>{{sub.course_name}}</td>
										<td>{{sub.first_name}}</td>
										<td>{{sub.reference_number}}</td>
										<td>{{sub.phone_number}}</td>
										<td class="text-right td-actions">
											<button type="button" @click="deleteAllowedSubs(index)" class="btn btn-danger ">
												Delete
											</button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
		            </div>
	              	<div class="modal-footer">
	                	<button type="button" class="btn btn-secondary" @click="showModal = false">Close</button>
	              	</div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </transition>
  	</div>
</div>

<script>
	let activeSub = new Vue({
		el: '#activeSub',
		data: {
			courses: '',
			startDate: '',
			endDate: '',
			availableFor: 0,
			AllSubs: '',
			allAllowedSubs: '',
			tableInit: false,
			fload: false,
			selectedCourse: '',
			selectedCategory: '',
			showModal: false,
		},
		watch: {
			showModal: function (val, oldVal) {
				if (oldVal === true) {
					this.delete_allowed_datatable();
				}
			}
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
			deleteAllowedSubs(index) {
				let formData = new FormData();

				let subid = this.allAllowedSubs[index].idsubscriptions;

				alert(subid);

				formData.append('sub_id', subid);
				Notiflix.Block.Standard('#allowedLodingBlock');

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
								this.allAllowedSubs.splice(index,1);
								// Swal.fire('Deleted!', 'Subscription has been deleted.', 'success');
								Notiflix.Notify.Success('Subscription has been deleted.');
							
							}
						}).catch(error => {
							// Swal.fire('Error!', 'Operation failed try again.', 'error');
							Notiflix.Notify.Failure('Operation failed try again.');
						}).then( function () {
							  Notiflix.Block.Remove('#allowedLodingBlock', 600);
						});
					}
				});
			},
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

		/*	getAllContents () {
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
			},*/
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

				let formData = new FormData();
				formData.append('course_id', this.selectedCourse);
				
				if(this.fload==true){ 
					this.delete_datatable();
				}	
                
                this.AllSubs=0;
               
				axios({
					method: 'post',
					url: '<?php echo base_url('system_operations/get_all_non_allowed_subs'); ?>',
					data: formData,
				})
				.then(response => {
					this.AllSubs = response.data.subs;
						if (!this.tableInit) {
							this.$nextTick(function() {
								this.initDt()
							});
						}

				})
				.catch(error => {
					Notiflix.Notify.Failure(response.data.error);
						this.AllSubs = Array;
						if (!this.tableInit) {
							this.$nextTick(function() {
								this.initDt()
							});
						}
				})
				
			},
			getAllAllowedSubs() {
				let formData = new FormData();
				formData.append('course_id', this.selectedCourse);	
                
                this.allAllowedSubs=0;
               
				axios({
					method: 'post',
					url: '<?php echo base_url('system_operations/get_all_allowed_subs'); ?>',
					data: formData,
				})
				.then(response => {
					this.showModal = true;
					this.allAllowedSubs = response.data.subs;
					this.$nextTick(function() {
						$('#allowed_datatables').DataTable({
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
					});
					

				})
				.catch(error => {
					Notiflix.Notify.Failure(response.data.error);
						this.allAllowedSubs = Array;
						this.$nextTick(function() {
							$('#allowed_datatables').DataTable({
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
						});
						this.showModal = true;
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
				this.AllSubs.length=0;  
					$(document).ready(function() { 
						var table = $('#datatables').DataTable();
  						table.clear().destroy();
					});
			},
			delete_allowed_datatable() {
				this.allAllowedSubs = Array;
				var allowedTable = $('#allowed_datatables').DataTable();
				allowedTable.clear().destroy();
			}
		}
	})
</script>

<style scoped>
.modal-mask {
	position: fixed;
	z-index: 1050;
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
