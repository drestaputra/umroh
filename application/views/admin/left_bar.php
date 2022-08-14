<?php $cont=$this->uri->segment(2, 0); ?>
<?php $url1=$this->uri->segment(1, 0); ?>
<aside id="sidebar-left" class="sidebar-left">
				
					<div class="sidebar-header">
						<div class="sidebar-title">
							Navigation
						</div>
						<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
							<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
						</div>
					</div>
				
					<div class="nano">
						<div class="nano-content">
							<nav id="menu" class="nav-main" role="navigation">
								<ul class="nav nav-main">
									<li <?php if (isset($cont) AND trim($cont)!="" AND $cont=="dashboard"): ?>
										 class="nav-active"
									<?php endif ?>>
										<a href="<?php echo base_url('admin/dashboard'); ?>">
											<i class="fa fa-home" aria-hidden="true"></i>
											<span>Dashboard</span>
										</a>
									</li>
									<li <?php if (isset($url1) AND trim($url1)!="" AND $url1=="produk"): ?>
										 class="nav-active"
									<?php endif ?>>
										<a href="<?php echo base_url('produk/index'); ?>">
											<i class="fa fa-dropbox" aria-hidden="true"></i>
											<span>Produk</span>
										</a>
									</li>
									<li <?php if (isset($url1) AND trim($url1)!="" AND $url1=="agen"): ?>
										 class="nav-active"
									<?php endif ?>>
										<a href="<?php echo base_url('agen/index'); ?>">
											<i class="fa fa-users" aria-hidden="true"></i>
											<span>Agen</span>
										</a>
									</li>
									<li <?php if (isset($url1) AND trim($url1)!="" AND $url1=="artikel"): ?>
										 class="nav-active"
									<?php endif ?>>
										<a href="<?php echo base_url('artikel/index'); ?>">
											<i class="fa fa-newspaper-o" aria-hidden="true"></i>
											<span>Artikel</span>
										</a>
									</li>
									<li <?php if (isset($url1) AND trim($url1)!="" AND $url1=="jadwal"): ?>
										 class="nav-active"
									<?php endif ?>>
										<a href="<?php echo base_url('jadwal/index'); ?>">
											<i class="fa fa-calendar" aria-hidden="true"></i>
											<span>Jadwal</span>
										</a>
									</li>
									<li <?php if (isset($url1) AND trim($url1)!="" AND $url1=="program"): ?>
										 class="nav-active"
									<?php endif ?>>
										<a href="<?php echo base_url('program/index'); ?>">
											<i class="fa fa-tasks" aria-hidden="true"></i>
											<span>Program</span>
										</a>
									</li>
									<li <?php if (isset($url1) AND trim($url1)!="" AND $url1=="testimoni"): ?>
										 class="nav-active"
									<?php endif ?>>
										<a href="<?php echo base_url('testimoni/index'); ?>">
											<i class="fa fa-comments-o" aria-hidden="true"></i>
											<span>Testimoni</span>
										</a>
									</li>
									<li <?php if (isset($url1) AND trim($url1)!="" AND $url1=="manasik"): ?>
										 class="nav-active"
									<?php endif ?>>
										<a href="<?php echo base_url('manasik/index'); ?>">
											<i class="fa fa-book" aria-hidden="true"></i>
											<span>Manasik</span>
										</a>
									</li>
									<li <?php if (isset($url1) AND trim($url1)!="" AND $url1=="itinerary"): ?>
										 class="nav-active"
									<?php endif ?>>
										<a href="<?php echo base_url('itinerary/index'); ?>">
											<i class="fa fa-plane" aria-hidden="true"></i>
											<span>Itinerary</span>
										</a>
									</li>
									<li <?php if (isset($url1) AND trim($url1)!="" AND $url1=="slider"): ?>
										 class="nav-active"
									<?php endif ?>>
										<a href="<?php echo base_url('slider/index'); ?>">
											<i class="fa fa-image" aria-hidden="true"></i>
											<span>Slider</span>
										</a>
									</li>	
																	
									<li <?php if (isset($url1) AND trim($url1)!="" AND $url1=="pengaturan"): ?>
										 class="nav-active"
									<?php endif ?>>
										<a href="<?php echo base_url('pengaturan/edit'); ?>">
											<i class="fa fa-cog" aria-hidden="true"></i>
											<span>Pengaturan</span>
										</a>
									</li>
									
									
								

								</ul>
							</nav>				
							
						</div>
				
					</div>
				
				</aside>