<!--  BEGIN SIDEBAR  -->
<div class="sidebar-wrapper sidebar-theme">
            
            <div id="dismiss" class="d-lg-none"><i class="flaticon-cancel-12"></i></div>
            
            <nav id="sidebar">

                <ul class="navbar-nav theme-brand flex-row  text-center">
                    <li class="nav-item theme-logo">
                        <a href="<?php echo base_url(); ?>dashboard">
                            <img src="<?php echo base_url(); ?>files/assets/img/90x90.png" class="navbar-logo" alt="logo">
                        </a>
                    </li>
                     <li class="nav-item theme-text">
                        <a href="<?php echo base_url(); ?>home" class="nav-link"> <img style="width:150px;" src="<?php echo base_url(); ?>files/assets/img/logo.png" > </a>
                    </li>
                </ul>

                <ul class="list-unstyled menu-categories" id="accordionExample">

                    <li class="menu <?php if ($menu == 'dashboard') { echo 'active';} ?>">
                        <a href="<?php echo base_url(); ?>dashboard" aria-expanded="<?php if ($menu == 'dashboard') { echo 'true';} else { echo 'false'; } ?>" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                <span> My Classes</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu <?php if ($menu == 'courses') { echo 'active';} ?>">
                        <a href="<?php echo base_url(); ?>courses" aria-expanded="<?php if ($menu == 'courses') { echo 'true';} else { echo 'false'; } ?>" class="dropdown-toggle">
                            <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                                <span> All Classes</span>
                            </div>
                        </a>
                    </li>

                    <!-- <li class="menu <?php if ($menu == 'teachers') { echo 'active';} ?>">
                        <a href="teachers" aria-expanded="<?php if ($menu == 'teachers') { echo 'true';} else { echo 'false'; } ?>" class="dropdown-toggle">
                            <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                <span> Teachers</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu <?php if ($menu == 'institutes') { echo 'active';} ?>">
                        <a href="institutes" aria-expanded="<?php if ($menu == 'institutes') { echo 'true';} else { echo 'false'; } ?>" class="dropdown-toggle">
                            <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-award"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                                <span> Institutes</span>
                            </div>
                        </a>
                    </li> -->

					<li class="menu <?php if ($menu == 'mysubs') { echo 'active';} ?>">
						<a href="<?php echo base_url(); ?>mysubscriptions" aria-expanded="<?php if ($menu == 'mysubs') { echo 'true';} else { echo 'false'; } ?>" class="dropdown-toggle">
							<div class="">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tv"><rect x="2" y="7" width="20" height="15" rx="2" ry="2"></rect><polyline points="17 2 12 7 7 2"></polyline></svg>
								<span> My Subscriptions</span>
							</div>
						</a>
					</li>

					<li class="menu <?php if ($menu == 'mysreqs') { echo 'active';} ?>">
						<a href="<?php echo base_url(); ?>my_special_requests" aria-expanded="<?php if ($menu == 'mysreqs') { echo 'true';} else { echo 'false'; } ?>" class="dropdown-toggle">
							<div class="">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
								<span> My Special Requests</span>
							</div>
						</a>
					</li>

                    <li class="menu <?php if ($menu == 'myaccount') { echo 'active';} ?>">
                        <a href="<?php echo base_url(); ?>myaccount" aria-expanded="<?php if ($menu == 'myaccount') { echo 'true';} else { echo 'false'; } ?>" class="dropdown-toggle">
                            <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <span> My Account</span>
                            </div>
                        </a>
                    </li>



                </ul>
            </nav>

        </div>
        <!--  END SIDEBAR  -->
