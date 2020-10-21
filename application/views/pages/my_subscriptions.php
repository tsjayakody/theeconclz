<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
	<title>Subscriptions | LMS </title>
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
	<?php echo $this->load->view('includes/sidebar', array('menu' => 'mysubs'), true); ?>
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
								<th colspan="7" class="text-center">Subscription History</th>
							</tr>
							<tr>
								<th>#</th>
								<th>Start</th>
								<th>End</th>
								<th>Subscribed on</th>
								<th>Reference no</th>
								<th>Course name</th>
								<th class="text-center">Status</th>
							</tr>
							</thead>
							<tbody>
							<tr v-for="( sub, index ) in tableData">
								<td>#{{index+1}}</td>
								<td>{{sub.subscription_start}}</td>
								<td>{{sub.subscription_end}}</td>
								<td>{{sub.subscription_date}}</td>
								<td>{{sub.reference_number}}</td>
								<td>{{sub.course_name}}</td>
								<td v-if="sub.is_allowed === '1'" class="text-center"><span class="text-success btn-sm btn btn-outline-success">Active</span></td>
								<td v-if="sub.is_allowed === '0'" class="text-center">
									<span class="text-danger btn btn-sm btn-outline-danger">Pending</span>
									<button class="btn btn-sm btn-danger" @click="deletePendingSub(index)">Delete</button>
								</td>
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
		tableData: ''
	},
	created () {
		this.getAllStudentSubs();
	},
	methods: {
		getAllStudentSubs () {
			axios({
				method: 'get',
				url: '<?php echo base_url('myaccount_controller/get_my_subs') ?>'
			}).then(response => {
				if (response.data.error) {
					Notiflix.Notify.Failure(response.data.error);
				} else {
					this.tableData = response.data;
				}
			});
		},

		deletePendingSub (index) {

			let formData = new FormData();
			formData.append('subscription_id', this.tableData[index].idsubscriptions);

			axios({
				method: 'post',
				url: '<?php echo base_url('myaccount_controller/delete_my_pending_sub') ?>',
				data: formData,
			}).then(response => {
				if (response.data.success) {
					this.tableData.splice(index, 1);
					Notiflix.Notify.Success("Successfully deleted the subscription.");
				} else {
					Notiflix.Notify.Failure("Something went wrong. Try again later.");
				}
			});
		}
	}
});

</script>

</body>
</html>

