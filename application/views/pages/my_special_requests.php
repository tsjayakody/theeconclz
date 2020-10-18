<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
	<title>Special Requests | LMS </title>
	<link rel="icon" type="image/x-icon" href="<?php echo base_url() ?>files/assets/img/90x90.jpg"/>
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
	<link href="<?php echo base_url() ?>files/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url() ?>files/assets/css/plugins.css" rel="stylesheet" type="text/css"/>
	<!-- END GLOBAL MANDATORY STYLES -->

	<!--  BEGIN CUSTOM STYLE FILE  -->
	<link href="<?php echo base_url() ?>files/assets/css/users/user-profile.css" rel="stylesheet" type="text/css"/>
	<!--  END CUSTOM STYLE FILE  -->
	<!-- notiflix notification library -->
	<!-- notiflix notification library css -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>files/plugins/Notiflix-2.3.2/dist/notiflix-2.3.2.min.css">
	<script src="<?php echo base_url() ?>files/plugins/Notiflix-2.3.2/dist/notiflix-aio-2.3.2.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
	<!-- development version, includes helpful console warnings -->
	<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
</head>
<body class="alt-menu sidebar-noneoverflow">

<!--  BEGIN NAVBAR  -->
<?php echo $this->load->view('includes/navbar', '', true); ?>
<!--  END NAVBAR  -->

<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container sidebar-closed sbar-open" id="container">

	<div class="overlay"></div>
	<div class="cs-overlay"></div>
	<div class="search-overlay"></div>

	<!--  BEGIN SIDEBAR  -->
	<?php echo $this->load->view('includes/sidebar', array('menu' => 'mysreqs'), true); ?>
	<!--  END SIDEBAR  -->

	<!--  BEGIN CONTENT AREA  -->
	<div id="content" class="main-content">
		<div class="layout-px-spacing" id="account_app">

			<div class="row layout-spacing">
				<div class="col-xl-12 col-lg-12 col-md-12 layout-spacing layout-top-spacing">
					<div class="table-responsive">
						<table class="table table-dark table-bordered mb-4">
							<thead>
							<tr>
								<th colspan="7" class="text-center">Special Request History</th>
							</tr>
							<tr>
								<th>#</th>
								<th>Message</th>
								<th>Content</th>
								<th>Requested on</th>
								<th class="text-center">Status</th>
								<th class="text-center">View</th>
							</tr>
							</thead>
							<tbody>
							<tr v-for="( req, index ) in tableData">
								<td>#{{index+1}}</td>
								<td>{{req.messege}}</td>
								<td>{{req.title}}</td>
								<td>{{req.sent_date}}</td>
								<td v-if="req.is_resolved === '1'" class="text-center"><span class="text-success">Resolved</span></td>
								<td v-if="req.is_resolved === '0'" class="text-center"><span class="text-warning">Pending</span></td>
								<td v-if="req.is_resolved === '2'" class="text-center"><span class="text-danger">Rejected</span></td>
								<td v-if="req.is_resolved === '1'" class="text-center"><button v-on:click="viewTime(req.idallocation_requests)" class="btn btn-sm btn-success">View Timeslot</button></td>
								<td v-if="req.is_resolved !== '1'" class="text-center"><span class="text-danger">No timeslots available</span></td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div class="col-xl-12 col-lg-12 col-md-12 layout-spacing layout-top-spacing" v-if="visibleTable">
					<div class="table-responsive">
						<table class="table table-dark table-bordered mb-4">
							<thead>
							<tr>
								<th>Content</th>
								<th>Available form</th>
								<th>Available until</th>
								<th>Allocated on</th>
							</tr>
							</thead>
							<tbody>
							<tr v-for="( req, index ) in allocationData">
								<td>{{req.title}}</td>
								<td>{{req.allocated_from}}</td>
								<td>{{req.allocated_to}}</td>
								<td>{{req.allocated_date}}</td>
							</tr>
							<tr>
								<td colspan="3"></td>
								<td><button v-on:click="visibleTable = false" class="btn btn-block btn-danger btn-sm">Close</button></td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>

			</div>
		</div>
	</div>
	<!--  END CONTENT AREA  -->
</div>
<!-- END MAIN CONTAINER -->

<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="<?php echo base_url() ?>files/assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url() ?>files/bootstrap/js/popper.min.js"></script>
<script src="<?php echo base_url() ?>files/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>files/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?php echo base_url() ?>files/assets/js/app.js"></script>

<script>
	$(document).ready(function () {
		App.init();
	});
</script>
<script src="<?php echo base_url() ?>files/assets/js/custom.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->


<script>

	let mySubsApp = new Vue({
		el: '#content',
		data: {
			tableData: '',
			allocationData: '',
			visibleTable: false
		},
		created () {
			this.getAllRequests();
		},
		methods: {
			getAllRequests () {
				axios({
					method: 'get',
					url: '<?php echo base_url('myaccount_controller/get_all_requests') ?>'
				}).then(response => {
					if (response.data.error) {
						Notiflix.Notify.Failure(response.data.error);
					} else {
						this.tableData = response.data;
					}
				});
			},

			viewTime (id) {
				let formData = new FormData();
				formData.append('request_id', id);
				axios({
					method: 'post',
					url: '<?php echo base_url('myaccount_controller/get_timeslot_allocation') ?>',
					data: formData
				}).then(response => {
					if (response.data.error) {
						Notiflix.Notify.Failure(response.data.error);
					} else {
						this.allocationData = response.data;
						this.visibleTable = true;
					}
				});
			}
		}
	});

</script>

</body>
</html>


