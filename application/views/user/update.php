<div class="body-content">
	<div class = "align-middle">
		<?php echo form_open_multipart('update/submit');?>
			<br><br>
			<input type="hidden" name = "user_id" value = "<?php echo $this->session->userdata('user_id');?>">
			<div class = "row">
				<div class = "col-md-4 offset-md-4 contentbordered" style = "margin:0 auto; float:none;">

					<h3 style = "text-align:center;">사용자정보변경</h3>
					<br>
					<?php if($error):?>
					<div class = "alert page-alert-danger" dole="alert">
						<h4 style = "text-align:center;"><?php echo $error;?></h4>
					</div>
					<? endif;?>
					<div class = "form-group">
						<input type = "text" class = "form-control" name = "name" placeholder = "사용자이름" value="<?php echo set_value('name');?>">
					</div>
					<hr>
					<div class = "form-group">
						<input type = "password" class = "form-control" name = "password" placeholder = "새 암호" value="<?php echo set_value('password');?>">
					</div>
					<div class = "form-group">
						<input type = "password" class = "form-control" name = "password2" placeholder = "암호확인" value="<?php echo set_value('password2');?>">
					</div>
					<hr>
					<div class = "form-group">
						<div class="element" id="div_1">
							<input type = "text" class="form-control" id = "phone_number_1" name = "phone_number_1" style = "display:inline;width:80%;margin-bottom:15px;" placeholder = "전화번호" value = "<?php echo set_value('phone_number');?>">&nbsp;<span class="c-font-15 badge add" style="cursor:handle;">추가</span>
						</div>
					</div>
					<hr>
					<div class = "form-group">
						<input type="file" id = "file" name="picture" class="inputfile">
						<label for="file" style="border-radius:5px; padding:5 5;"><strong>화상화일 선택...</strong></label>
					</div>
					<br>
					<button type = "submit" class = "btn btn-primary btn-block">변  경</button>

				</div>
			</div>
		<?php echo form_close();?>	
	</div>
	<script>
		/*
		$('#update_user_info').click(function(e){
			e.preventDefault();
			var me = $(this);
		    $.ajax({
		        url: me.attr('action'),
		        type:'post',
		        data: me.serialize(),
		        dataType:'json',
		        success: function(response){
		          if(response.success == true)
		          {
		          	alert("123");
		            window.location.href = '<?php echo base_url();?>logout';
		          }
		        }
		    });
		});
		*/
		$(".add").click(function(){
		  // Finding total number of elements added
		  var total_element = $(".element").length;
		  // last <div> with element class id
		  var lastid = $(".element:last").attr("id");
		  var split_id = lastid.split("_");
		  var nextindex = Number(split_id[1]) + 1;

		  var max = 7;
		  // Check total number elements
		  if(total_element < max ){
		   // Adding new div container after last occurance of element class
		   $(".element:last").after("<div class='element' id='div_"+ nextindex +"'></div>");
		 
		   // Adding element to <div>
		   $("#div_" + nextindex).append("<input class='form-control' type = 'text' id = 'phone_number_" + nextindex + "' name='phone_number_" + nextindex + "' style = 'display:inline;width:80%;margin-bottom:15px;' placeholder = '전화번호'>&nbsp;<span id='remove_" + nextindex + "' class='c-font-15 badge remove'>취소</span>");
		   $("#phone_number_"+nextindex).mask("(+)381-061-999-9999");

		  }
		 
		 });

		 // Remove element
		 $('.form-group').on('click','.remove',function(){
		 
		  var id = this.id;
		  var split_id = id.split("_");
		  var deleteindex = split_id[1];

		  // Remove <div> with id
		  $("#div_" + deleteindex).remove();

		 }); 
	</script>