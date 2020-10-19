


<div class="content" id="studentDataApp">
	<div class="container-fluid">
		<div class="col-md-12">

			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-md-4 col-sm-4 col-12 form-group">
							<label for="selectCategory"> Select Year</label>
							<select name="selectCategory" v-model="categoryID" v-on:change="getAllStudents" data-style="btn btn-link" class="form-control selectpicker">
								<option value="" selected>Select All</option>
								<?php
								$cts = $this->db->get('exam_year');
								foreach ($cts->result_array() as $item) {
									echo '<option value="'.$item['id_exam_year'].'">'.$item['years'].'</option>';
								}
								?>
							</select>
						</div>
						
						
					</div>
				</div>
			</div>		


			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Student data</h5>
					<div class="toolbar">
						<!--        Here you can write extra buttons/actions for the toolbar              -->
					</div>
					
					<!--  v-show="isFirstDataLoaded"-->
					<div class="material-datatables" >
						<table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0"
							   width="100%" style="width:100%">
							<thead>
							<tr>
							
								<th>Name</th>
								<th>ID</th>
								<th style="width:10%;">Email</th>
								<th  style="width:10%;">Phone Number</th>
								<th>Al-Year</th>
								<th style="width:10%;">School</th>
								<th>City</th>
								<th>Joined On</th>
							</tr>
							</thead>
							<tfoot>
							<tr>
								
								<th>Name</th>
								<th>ID</th>
								<th style="width:10%;">Email</th>
								<th  style="width:10%;">Phone Number</th>
								<th>Al-Year</th>
								<th style="width:10%;">School</th>
								<th>City</th>
								<th>Joined On</th>
							</tr>
							</tfoot>


							<tbody>
							<tr v-for="(student, index) in students">
							
								<td>{{student.first_name}} {{student.last_name}}</td>
								<td>{{student.student_id}} </td>
								<td>{{student.email}}</td>
								<td>{{student.phone_number}}</td>
								<td>{{student.years}}</td>
								<td>{{student.school}}</td>
								<td>{{student.student_city}}</td>
								<td>{{student.created_at}}</td>
							</tr>		
							<!--<tr v-for="student in students">
								<td>{{student.first_name}} {{student.last_name}}</td>
								<td>{{student.student_id}} </td>
								<td>{{student.email}}</td>
								<td>{{student.phone_number}}</td>
								<td>{{student.years}}</td>
								<td>{{student.school}}</td>
								<td>{{student.student_city}}</td>
								<td>{{student.created_at}}</td>
							</tr>-->
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>



$(document).ready(function() {
	//$('#datatables').DataTable();
});

	let studentDataApp = new Vue({
		el: '#studentDataApp',
		data: {
			categoryID: '',
			students: '',
			//isFirstDataLoaded: false,
			tableInit: false,
			fload: false
		},
		 created: function() {
        // non-observable vars can go here
        //this.dataTable = null;
     	},

		mounted () {
			this.getAllStudents()
		},
		methods: {
		getAllStudents () {
				if(this.fload==true){ 
					this.delete_datatable();
				}				
				
				//this.isFirstDataLoaded = false;
				let formData = new FormData();
				formData.append('category_id', this.categoryID);
				 
				console.log(this.categoryID+"bbbb");

    			
				axios({
					method: 'post',
					url: '<?php echo base_url('system_operations/getAllStudents') ?>',
					data: formData
				}).then(response => {
					if (response.data.error) {
						Notiflix.Notify.Failure(response.data.error);
						this.students = Array;
						if (!this.tableInit) {  
							this.$nextTick(function() {
								this.initDt()  
							});
						}
					} else {
						//this.isFirstDataLoaded = true;
						this.students = response.data;
						if (!this.tableInit) {  
							this.$nextTick(function() {
								this.initDt(); 
							});
							
						}
					}

				}).catch(error => {
					console.log(error);
				})
			},
		    initDt() {
				$('#datatables').DataTable({
					//destroy: true,
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
				this.tableInit = false;
				this.fload=true;

			},
			delete_datatable(){
				this.students.length=0;  

					$(document).ready(function() { 
						var table = $('#datatables').DataTable();
  						table.clear().destroy();
  						
					});
			}
		}
	});
</script>
