<div class="content" id="categoryData">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6 col-sm-6 col-12">
			<div class="card" id="loadingdiv">
				<div class="card-body">
					<h5 class="card-title mb-4">Update details</h5>
					<div class="row">


						<div class="col-md-12 col-sm-12 col-12">
							<div class="input-group mb-3">
								<input @click="formErrors.category_name = ''" type="text" class="form-control" placeholder="Category name" v-model="category.category_name">
								<div class="invalid-feedback" style="display: block" >{{formErrors.category_name}}</div>
							</div>
						</div>

						<div class="col-md-6 col-sm-12 col-12" v-if="category.idcourse_category">
							<div class="input-group mb-3">
								<button v-on:click="updateCategory" class="btn btn-block btn-success">Update</button>
							</div>
						</div>
						<div class="col-md-6 col-sm-12 col-12" v-if="category.idcourse_category">
							<div class="input-group mb-3">
								<button v-on:click="category.category_name = ''; category.idcourse_category = '';" class="btn btn-block btn-danger">Clear</button>
							</div>
						</div>
						<div class="col-md-6 col-sm-12 col-12" v-else>
							<div class="input-group mb-3">
								<button v-on:click="addCategory" class="btn btn-block btn-success">Save</button>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
			<div class="col-md-6 col-sm-6 col-12">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Category data</h5>
					<div class="material-datatables">
						<table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0"
							   width="100%" style="width:100%">
							<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th class="text-center">Action</th>
							</tr>
							</thead>
							<tbody>
							<tr v-for="(cat, index) in categories">
								<td>#{{index+1}}</td>
								<td>{{cat.category_name}}</td>
								<td class="text-center">
									<button class="btn btn-sm btn-success" v-on:click="getStudentData(cat.idcourse_category)">Edit</button>
									<button class="btn btn-sm btn-danger" v-on:click="deleteCategory(cat.idcourse_category)">Delete</button>
								</td>
							</tr>
							</tbody>
							<tfoot>
							<tr>
								<th>#</th>
								<th>Name</th>
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
</div>

<script>
	$(document).ready(function () {
		$('#datatables').DataTable();
	});
</script>

<script>
	let updateApp = new Vue({
		el: '#categoryData',
		data: {
			categories: '',
			category: {
				category_name: ''
			},
			formErrors: ''
		},
		created () {
			this.getAllCategories();

		},
		methods: {
			getAllCategories () {
				axios.get('<?php echo base_url('system_operations/get_all_categories') ?>').then(response => {this.categories = response.data});
			},

			deleteCategory (catid) {
				Notiflix.Block.Standard('#loadingdiv');
				let formData = new FormData();
				formData.append('category_id', catid);

				axios({
					method: 'post',
					url: '<?php echo base_url('system_operations/delete_category') ?>',
					data: formData
				}).then(response => {
					if (response.data.error) {
						Notiflix.Notify.Failure(response.data.error);
					} else if (response.data.success){
						Notiflix.Notify.Success('Category deleted successfully.');
						this.getAllCategories();
					}
				}).catch(error => {
					console.log(error);
					Notiflix.Notify.Failure('Category is not deleted.');
				}).then(function () {
					Notiflix.Block.Remove('#loadingdiv', 600);
				});
			},

			getStudentData (catid) {
				Notiflix.Block.Standard('#loadingdiv');
				let formData = new FormData();
				formData.append('category_id', catid);
				axios({
					method: 'post',
					url: '<?php echo base_url('system_operations/get_category_data_for_update') ?>',
					data: formData
				}).then(response => {
					if (response.data.error) {
						Notiflix.Notify.Failure(response.data.error);
					} else {
						this.category = response.data;
					}
				}).catch(error => {
					console.log(error);
				}).then(function () {
					Notiflix.Block.Remove('#loadingdiv', 600);
				});
			},

			addCategory () {
				Notiflix.Block.Standard('#loadingdiv');
				let formData = new FormData();
				formData.append('category_name', this.category.category_name);
				axios({
					method: 'post',
					url: '<?php echo base_url('system_operations/add_new_category') ?>',
					data: formData
				}).then(response => {
					if (response.data.error) {
						Notiflix.Notify.Failure(response.data.error);
					} else if (response.data.form_errors) {
						this.formErrors = response.data.form_errors;
					} else {
						this.category.category_name = '';
						this.getAllCategories();
						Notiflix.Notify.Success('Category added successfully.');
					}
				}).catch(error => {
					console.log(error);
				}).then(function () {
					Notiflix.Block.Remove('#loadingdiv', 600);
				});
			},

			updateCategory () {
				Notiflix.Block.Standard('#loadingdiv');
				let formData = new FormData();
				formData.append('category_id', this.category.idcourse_category);
				formData.append('category_name', this.category.category_name);
				axios({
					method: 'post',
					url: '<?php echo base_url('system_operations/update_category_data') ?>',
					data: formData
				}).then(response => {
					if (response.data.error) {
						Notiflix.Notify.Failure(response.data.error);
					} else if (response.data.form_errors) {
						this.formErrors = response.data.form_errors;
					} else {
						this.category.category_name = '';
						this.category.idcourse_category = '';
						Notiflix.Notify.Success('Category updated successfully.');
						this.getAllCategories();
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

