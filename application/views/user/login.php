
<div class = "align-middle">
	<?php echo form_open('user/login');?>
		<br><br>
		<div class = "row">
			<div class = "col-md-4 offset-md-4 contentbordered" style = "margin:0 auto; float:none;">

				<h3 style = "text-align:center;">홈페지 가입을 환영합니다.</h3>
				<br>
				<?php if(validation_errors()):?>
				<div class = "alert page-alert-danger" dole="alert">
					<h4 style = "text-align:center;"><?php echo validation_errors();?></h4>
				</div>
				<? endif;?>
				<?php if($this->session->flashdata('user_loggedin_fail')):?>
				<div class = "alert page-alert-danger" dole="alert">
					<h4 style = "text-align:center;"><?php echo $this->session->flashdata('user_loggedin_fail');?></h4>
				</div>
				<? endif;?>
				<div class = "form-group">
					<input type = "text" class = "form-control" name = "name" placeholder = "사용자이름" value="<?php echo set_value('name');?>">
				</div>
				<div class = "form-group">
					<input type = "password" class = "form-control" name = "password" placeholder = "가입암호" value="<?php echo set_value('password');?>">
				</div><br>
				<button type = "submit" class = "btn btn-block btn-primary">가   입</button>
				<div class = "loginSignUpSeparator">
					<span class = "textInSeparator c-font-14">아니면</span>
				<a href = "<?php echo base_url();?>regist" class = "btn btn-block btn-default">등   록</a>
			</div>
		</div>
	<?php echo form_close();?>	
</div>