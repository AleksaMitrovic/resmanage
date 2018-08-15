<div class="c-layout-header-fixed c-layout-header-mobile-fixed c-layout-header-fullscreen c-layout-header-topbar c-layout-header-topbar-collapse">
	<?php if($this->session->flashdata('page') == 'project'):?>
	<header class="c-layout-header c-layout-header-2 c-layout-header-dark-mobile c-header-transparent-dark" data-minimize-offset="80">
		<div class="c-navbar">
			<div class="container-fluid">
	<? endif;?>
	<?php if($this->session->flashdata('page') == 'dailyrep'):?>
	<header class="c-layout-header c-layout-header-4 c-layout-header-default-mobile" data-minimize-offset="80">
		<div class="c-navbar">
			<div class="container">
	<? endif;?> 
	<?php if($this->session->flashdata('page') == 'home'):?>
	<header class="c-layout-header c-layout-header-3 c-layout-header-3-custom-menu c-layout-header-dark-mobile"data-minimize-offset="80">
		<div class="c-navbar">
			<div class="container">	
	<? endif;?>
				<!-- BEGIN: BRAND -->
				<div class="c-navbar-wrapper clearfix">
					<div class="c-brand c-pull-left">
						<button class="c-hor-nav-toggler" type="button" data-target=".c-mega-menu">
						<span class="c-line"></span>
						<span class="c-line"></span>
						<span class="c-line"></span>
						</button>
						<button class="c-topbar-toggler" type="button">
							<i class="fa fa-ellipsis-v"></i>
						</button>
						<button class="c-search-toggler" type="button">
							<i class="fa fa-search"></i>
						</button>
					</div>
					<!-- END: BRAND -->				
					<!-- BEGIN: QUICK SEARCH -->
					<form class="c-quick-search" action="#">
						<input type="text" name="query" placeholder="Type to search..." value="" class="form-control" autocomplete="off">
						<span class="c-theme-link">&times;</span>
					</form>
					<!-- END: QUICK SEARCH -->	
					<!-- BEGIN: HOR NAV -->
					<!-- BEGIN: LAYOUT/HEADERS/MEGA-MENU -->
					<!-- BEGIN: MEGA MENU -->
					<!-- Dropdown menu toggle on mobile: c-toggler class can be applied to the link arrow or link itself depending on toggle mode -->
					<nav class="c-mega-menu c-pull-right c-mega-menu-dark c-mega-menu-dark-mobile c-theme c-fonts-uppercase c-fonts-bold">
						<ul class="nav navbar-nav c-theme-nav"> 
							<?php if($this->session->userdata('logged_in')):?>
							<li >
								<a href="<?php echo base_url()?>" class="c-link" id = "home">첫 페지</a>
							</li>
							<li>
								<a href="<?php echo base_url()?>dailyrep" class="c-link" id = "dailyrep">일보관리</a>
							</li>
							<li>
								<a href="<?php echo base_url()?>project" class="c-link" id = "project">프로젝트관리</a>
							</li>
							<li>
								<a href="<?php echo base_url()?>update/from_menu_bar" class="c-link" id = "present">사용자정보변경</a>
							</li>
							<?php if($this->session->userdata('status') == STATUS_BOSS):?>
							<li >
								<?php
									$current_date = (new DateTime())->format('Y-m-d');
								?>
								<a href="<?php echo base_url()?>dailyrep/entire/<?php echo $current_date;?>" class="c-link" id = "present">일보종합</a>
							</li>	
							<li>
								<a href="<?php echo base_url()?>project/entire" class="c-link" id = "present">프로젝트종합</a>
							</li>
							<? endif;?>
												<!-- BEGIN: DESKTOP VERSION OF THE TAB MEGA MENU -->
							<li>
								<?php if($this->session->flashdata('page') == 'home' || $this->session->flashdata('page') == 'project'):?>
								<a href="<?php echo base_url()?>logout" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-white c-btn-circle c-btn-uppercase c-btn-sbold">
								<? endif;?>
								<?php if($this->session->flashdata('page') == 'dailyrep'):?>
								<a href="<?php echo base_url()?>logout" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">	
								<? endif;?>									
								<i class="icon-user"></i> 가입탈퇴</a>
							</li>	
							<? endif;?>		
							<?php if(!$this->session->userdata('logged_in')):?>
								<li>
									<?php if($this->session->flashdata('page') == 'home' || $this->session->flashdata('page') == 'project'):?>
									<a href="<?php echo base_url()?>login" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-white c-btn-circle c-btn-uppercase c-btn-sbold">
									<? endif;?>
									<?php if($this->session->flashdata('page') == 'dailyrep'):?>
									<a href="<?php echo base_url()?>login" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">	
									<? endif;?>									
									<i class="icon-user"></i> 가입</a>
								</li>
								<!--
								<li>
									<?php if($this->session->flashdata('ishome')):?>
									<a href="<?php echo base_url()?>regist" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-white c-btn-circle c-btn-uppercase c-btn-sbold">
									<? endif;?>
									<?php if(!$this->session->flashdata('ishome')):?>
									<a href="<?php echo base_url()?>regist" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">	
									<? endif;?>									
									<i class="icon-user"></i> 등록</a>
								</li>
								-->	
							<? endif;?>				
							<!--	
							<li class="c-quick-sidebar-toggler-wrapper">	
								<a href="#" class="c-quick-sidebar-toggler">		     		
									<span class="c-line"></span>
									<span class="c-line"></span>
									<span class="c-line"></span>
								</a>
							</li>
							-->	
						</ul>
					</nav>
					<!-- END: MEGA MENU --><!-- END: LAYOUT/HEADERS/MEGA-MENU -->
					<!-- END: HOR NAV -->		
				</div>			
			</div>
		</div>
	</header>
</div>