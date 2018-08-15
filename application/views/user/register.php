
<div class = "align-middle">
	<?php echo form_open_multipart('user/regist');?>
		<br><br>
		<div class = "row">
			<div class = "col-md-4 offset-md-4 contentbordered" style = "margin:0 auto; float:none;">

				<h3 style = "text-align:center;">사용자등록을 환영합니다.</h3>
				<br>
				<?php if(validation_errors()):?>
				<div class = "alert page-alert-danger" dole="alert">
					<h4 style = "text-align:center;"><?php echo validation_errors();?></h4>
				</div>
				<? endif;?>
				<div class = "form-group">
					<input type = "text" class = "form-control" name = "name" placeholder = "사용자이름" value="<?php echo set_value('name');?>">
				</div>
				<div class = "form-group">
					<input type = "password" class = "form-control" name = "password" placeholder = "암호" value="<?php echo set_value('password');?>">
				</div>
				<div class = "form-group">
					<input type = "password" class = "form-control" name = "password2" placeholder = "암호확인" value="<?php echo set_value('password2');?>">
				</div>
				<div class = "form-group">
					<input type = "text" class = "form-control" id = "phone_number_1" name = "phone_number_1" placeholder = "전화번호" value="<?php echo set_value('phone_number');?>">
				</div>
				<div class = "form-group">
					<input type="file" id = "file" name="picture" class="inputfile">
					<label for="file" style="border-radius:5px; padding:5 5;"><strong>화상화일 선택...</strong></label>
					<p><?php echo $error;?></p>
				</div>
				<br>
				<button type = "submit" class = "btn btn-primary btn-block">등  록</button>

			</div>
		</div>
	<?php echo form_close();?>	
</div>