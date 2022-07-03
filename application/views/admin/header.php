<!-- start: header -->
			<header class="header">
				<div class="logo-container">
					<a href="../" class="logo">
						<img src="<?php echo base_url(); ?>assets/images//logo.png" height="35" alt="Porto Admin" />
					</a>
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>
			
				<!-- start: search & user box -->
				<div class="header-right">
								
			
				
			
					<div id="userbox" class="userbox">
						<a href="#" data-toggle="dropdown">
							<figure class="profile-picture">
								<img src="<?php echo base_url(); ?>assets/images//!logged-user.jpg" alt="Joseph Doe" class="img-circle" data-lock-picture="<?php echo base_url(); ?>assets/images//!logged-user.jpg" />
							</figure>
							<div class="profile-info" data-lock-name="" data-lock-email="">
								<span class="name"><?php echo $this->session->userdata('admin')['username']; ?></span>
								<span class="role">administrator</span>
							</div>
			
							<i class="fa custom-caret"></i>
						</a>
			
						<div class="dropdown-menu">
							<ul class="list-unstyled">

								<li class="divider"></li>
								<li>
									<a role="menuitem" tabindex="-1" href="<?php echo base_url('user/admin/profil'); ?>"><i class="fa fa-user"></i> Profil</a>
								</li>
								<li class="divider"></li>
								
								<li>
									<a role="menuitem" tabindex="-1" href="<?php echo base_url('admin/logout'); ?>"><i class="fa fa-power-off"></i> Logout</a>
								</li>

							</ul>
						</div>
					</div>
				</div>
				<!-- end: search & user box -->
			</header>
			<!-- end: header -->