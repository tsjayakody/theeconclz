<div class="content">
<input type="hidden" value="<?php echo base_url(); ?>" id="baseurl" />
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form id="createUser" action="<?php echo base_url() ?>user_controller/create_user" method="post"
                    novalidate="novalidate">
                    <div class="card " id="loader1">
                        <div class="card-header card-header-info card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">account_circle</i>
                            </div>
                            <h4 class="card-title">Create User</h4>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group is-filled">
                                        <label for="firstName" class="bmd-label-floating"> First Name</label>
                                        <input type="text" class="form-control" id="firstName" required="true"
                                            aria-required="true" aria-invalid="false">
                                        <label id="firstName-error" class="error" for="firstName"></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group is-filled">
                                        <label for="lastName" class="bmd-label-floating"> Last Name</label>
                                        <input type="text" class="form-control" id="lastName" required="true"
                                            aria-required="true" aria-invalid="false">
                                        <label id="lastName-error" class="error" for="lastName"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group bmd-form-group is-filled">
                                        <label for="contactNumber" class="bmd-label-floating"> Contact Number</label>
                                        <input type="text" class="form-control" id="contactNumber" required="true"
                                            aria-required="true" aria-invalid="false">
                                        <label id="contactNumber-error" class="error" for="contactNumber"></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group bmd-form-group is-filled">
                                        <label for="emailAddress" class="bmd-label-floating"> Email Address</label>
                                        <input type="text" class="form-control" id="emailAddress" required="true"
                                            aria-required="true" aria-invalid="false">
                                        <label id="emailAddress-error" class="error" for="emailAddress"></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group bmd-form-group is-filled">
                                        <label for="password" class="bmd-label-floating"> Password</label>
                                        <input type="text" class="form-control" id="password" required="true"
                                            aria-required="true" aria-invalid="false">
                                        <label id="password-error" class="error" for="password"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <select class="selectpicker" id="typeSelect" data-size="7" data-width="100%"
                                        data-style="btn btn-info btn-round" title="User Type">
                                        <option disabled selected>User Type</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right" id="formButtons">
                            <input type="reset" hidden id="resetForm" />
                            <input type="hidden" value="create" id="functionSelector"/>
                            <button type="submit" class="btn btn-info">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">table_chart</i>
                        </div>
                        <h4 class="card-title">System Users</h4>
                    </div>
                    <div class="card-body">
                        <div class="material-datatables">
                            <table id="year_table" class="table table-striped table-no-bordered table-hover"
                                cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Contact Number</th>
                                        <th>Email Address</th>
                                        <th>User Type</th>
                                        <th>Created Date</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Contact Number</th>
                                        <th>Email Address</th>
                                        <th>User Type</th>
                                        <th>Created Date</th>
                                        <th class="text-right">Actions</th>
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
