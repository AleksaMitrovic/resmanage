
<html>
	<head>
		<title> Soft Tutorial zone find us on lisenme.com</title>
		<!-- BEGIN BASE CSS -->
		<link href="<?php echo base_url()?>assets/vendor/bootstrap/css/bootstrap.min.css" rel = "stylesheet">
		<link href="<?php echo base_url()?>assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<!-- END BASE CSS-->

		<!-- BEGIN ADMINLTE CSS -->
		<link rel="stylesheet" href="<?php echo base_url()?>assets/adminlte/bower_components/Ionicons/css/ionicons.min.css">
		<link rel="stylesheet" href="<?php echo base_url()?>assets/adminlte/dist/css/AdminLTE.min.css">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
		<!--
		<link rel="stylesheet" href="<?php echo base_url()?>assets/adminlte/bower_components/morris.js/morris.css">
		-->

		<!-- END ADMINLTE CSS-->

		<!-- BEGIN PLUGIN CSS -->
		<link href="<?php echo base_url()?>assets/css/plugins/ribbon.css" rel="stylesheet">
  		<link rel="stylesheet" href="<?php echo base_url()?>assets/adminlte/dist/css/skins/_all-skins.min.css">
  		<link rel="stylesheet" href="<?php echo base_url()?>assets/adminlte/plugins/iCheck/all.css">
 		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
 		<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
 		<!-- END PLUGIN CSS-->

 		<!-- BEGIN THEME CSS-->
 		<link href="<?php echo base_url()?>assets/css/themes/plugins.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo base_url()?>assets/css/themes/components.css" id="style_components" rel="stylesheet" type="text/css"/>
		<link href="<?php echo base_url()?>assets/css/themes/default.css" rel="stylesheet" id="style_theme" type="text/css"/>
		<link href="<?php echo base_url()?>assets/css/themes/cuberportfolio.min.css" rel="stylesheet" id="style_theme" type="text/css"/>
		<link href="<?php echo base_url()?>assets/vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" id="style_theme" type="text/css"/>
		<!-- END THEME CSS -->

		<!-- BEGIN CUSTOM CSS -->
		<link href="<?php echo base_url()?>assets/css/style.css" rel = "stylesheet">
		<!-- END CUSTOM CSS -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>js
	</head>
	<body>

		<?php
		/*
			$connect = mysqli_connect("127.0.0.1","root","12345678","test");
			$query="SELECT * FROM account";
			$result = mysqli_query($connect,$query);
			$chart_data = '';
			while($row = mysqli_fetch_array($result))
			{
				$chart_data .= "{ year:'".$row["year"]."', profit:".$row["profit"]."}, ";

			}
			$chart_data = substr($chart_data,0,-2);
		*/
			$chart_data = '';
			foreach($taxed_logs as $taxed_log)
			{
				$date = DateTime::createFromFormat('Y-m-d H:i:s',$taxed_log['taxed_date']);

				$chart_data .= "{ year:'".$date->format('Y')."', profit:".$taxed_log['taxed_price']."}, ";
			}
			$chart_data = substr($chart_data,0,-2);
			print_r($chart_data);
		?>
		<div class="container" style="width:900px;">
			<h2 align = "center">Morris.js chart with PHP & Mysql </h2>
			<h3 align= "center">Last 10 years.......</h3>
			<div id="chart"></div>
			<div class = "gray-panel">
				
				<div class = "news-content">
					<br><br><br><br><br>
					<div class = "row">
						<div class = "col-md-4 offset-md-4" style="margin:0 auto;float:none;">
							<section class = "clock-container">
								<svg viewBox = "0 0 40 40">
									<circle cx="20" cy="20" r="19.5" style = "stroke-width:0.25;"/>
									<circle cx="20" cy="20" r="19" style = "stroke-width:0.15;"/>
									<text x="0" y="0" class="tiaText" style= "font-size:1.5px; text-align:center;">평 양</text>
									<g class="marks">
									    <line x1="15" y1="0" x2="16" y2="0" />
									    <line x1="15" y1="0" x2="16" y2="0" />
									    <line x1="15" y1="0" x2="16" y2="0" />
									    <line x1="15" y1="0" x2="16" y2="0" />
									    <line x1="15" y1="0" x2="16" y2="0" />
									    <line x1="15" y1="0" x2="16" y2="0" />
									    <line x1="15" y1="0" x2="16" y2="0" />
									    <line x1="15" y1="0" x2="16" y2="0" />
									    <line x1="15" y1="0" x2="16" y2="0" />
									    <line x1="15" y1="0" x2="16" y2="0" />
									    <line x1="15" y1="0" x2="16" y2="0" />
									    <line x1="15" y1="0" x2="16" y2="0" />
									</g>
									<line x1="0" y1="0" x2="9" y2="0" class="hour" />
									<line x1="0" y1="0" x2="13" y2="0" class="minute" />
									<line x1="0" y1="0" x2="16" y2="0" class="seconds" />
									<circle cx="20" cy="20" r="0.7" class="pin" />
								</svg>
							</section>
						</div>
					</div>
					<div class = "row">
						<div class = "col-md-4 offset-md-4" style = "margin:0 auto; float:none;">
							<h1 class = "c-font-bold c-font-center c-font-white">
							<?php
							$date = new DateTime();
							echo "주체(".((int)date('Y') - 1911).") ".$date->format("Y년 m월 d일");
							?></h1>
						</div>
					</div>
				</div>
				<div class = "container">

					<div class = "row" style = "margin-top:40px;">
						<div class = "col-md-7">
							<div class="today-rep-view">
								<div class = "box box-primary">
									<div class = "box-header ui-sortable-handle" style="cursor:move;">
										<i class="ion ion-compose"></i>
										<h3 class = "box-title">일보열람</h3>
									</div>
									<div class = "box-body">
										<?php if($rep_refresh):?>
										<div class="alert alertbar alertbar-transition">
										<? endif;?>
										<?php if(!$rep_refresh):?>
										<div class="alert alertbar alertbar-transition-active">
										<? endif;?>	
											<button type = "button" class = "close" data-dismiss="alert" aria-hidden="true" style="color:white;">x</button>
											<h4>알림</h4>
											오늘 일보를 작성해야 합니다.
										</div>
										<div class = "c-cotent-title-1 c-title-md">
											<?php
												$report_result = "보관된 일보자료가 없습니다.";
												$report_day = new DateTime('0001-01-01 00:00:00');
												
												if($last_report['created_at']){
													$report_day = new DateTime($last_report['created_at']);
													$report_result = $report_day->format("Y년 m월 d일 일보");
												}
												echo "<input type='hidden' id='report-day' value='".$report_day->format('Y-m-d H:i:s')."'>";
												echo "<h3 style = 'background-color:#f7f7f7;font-size:18px; padding:7 10;text-align:center;'>".$report_result;
											?>
											</h3>
										</div>
										<?php if($last_report):?>
										<div class="report-content">
											<div class="box box-default collapsed-box box-solid">
						       					<div class="box-header with-border">
						          					<h3 class="box-title">사업내용</h3>
							         				<div class="box-tools pull-right">
							            				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
							           					</button>
							          				</div>
						        				</div>
										        <div class="box-body" style = "padding:15;">
										          <?php echo $last_report['businessrep'];?>
										        </div>
						      				</div>
						      				<?php if(sizeof($project_logs) > 0):?>
										    <div class="box box-default collapsed-box box-solid">
										        <div class="box-header with-border">
										          <h3 class="box-title">프로젝트별 진행정형</h3>
										          <div class="box-tools pull-right">
										            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
										            </button>
										          </div>
										        </div>
										        <div class="box-body">
										        	<ul class = "todo-list">
											        <?php foreach($project_logs as $project_log):?>
											        	<?php if($project_log['bus_at_pro']):?>
											        	<li>
											        		<div class = "project_panel_head">
												        		<span class = "handle">
												        			<i class = "fa fa-ellipsis-v"></i>
												        			<i class = "fa fa-ellipsis-v"></i>
												        		</span>
												        		<span class = "text"><?php echo $project_log['project_title'];?></span>
											        		</div>
											        		<div class = "project_panel_body" style= "padding:0 30">
											        			<p style = "margin:15 0"><?php echo $project_log['prev_rate']."% - ".$project_log['pro_rate_change']."%";?></p>
											        			<p><?php echo $project_log['bus_at_pro'];?></p>
											        		</div>
											        	</li>
											        	<? endif;?>
											        <? endforeach;?>
										      		</ul>
										        </div>
										    </div>
											<? endif;?>
										    <div class="box box-default collapsed-box box-solid">
										        <div class="box-header with-border">
										          <h3 class="box-title">제기할 내용</h3>
										          <div class="box-tools pull-right">
										            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
										            </button>
										          </div>   
										        </div>
										        <div class="box-body" style = "padding:15;">
										          <?php echo $last_report['suggestion'];?>
										        </div>
										    </div>
										</div>
										<? endif;?>
									    <hr>
									    <div class = "newreport newreport-transition">
								    		<?php echo form_open('dailyrep/create');?>
												<input type = "hidden" name = "user_id" value = "<?php echo $this->session->userdata('user_id');?>">
												<div class = "panel panel-info">
					                              <div class = "panel-heading">
					                                <h3 class = "c-font-bold c-font-20 panel-title">
					                                  사업내용
					                                </h3>
					                              </div>
					                              <div class = "panel-body">
					                                <textarea id = "editor1" class = "form-control" name = "businessrep"></textarea>
					                              </div>
					                            </div>
					                            <?php if(sizeof($progress_projects) > 0):?>
					                            <div class = "panel panel-info">
					                              	<div class = "panel-heading">
					                                <h3 class = "c-font-bold c-font-20 panel-title">
					                                  프로젝트별 일보
					                                </h3>
						                            </div>
						                            <div class = "panel-body">
						                                <?php foreach($progress_projects as $project):?>
															<div class = "box box-default collapsed-box box-solid box-project">
																<div class = "box-header with-border">
																	<h3 class = "box-title"><?php echo $project['project_title'];?></h3>
																	<div class = "box-tools pull-right">
																		<button type = "button" class="btn btn-box-tool" data-widget = "collapse">
																			<i class = "fa fa-plus"></i>
																		</button>
																	</div>
																</div>
																<div class = "box-body">
																	<div class = "form-group">
																		<span class = "c-font-15">진척률:</span>
																		<?php echo "<input type ='text' name='rate_".$project['id']."'>%";?>
																	</div>
																	<div class = "form-group">
																		<span class = "c-font-15">진행한 사업:</span>
																		<?php echo "<textarea id='editor' class='form-control' name='projectrep_".$project['id']."'></textarea>";?>
																	</div>
																</div>
															</div>
														<? endforeach;?>
					                              	</div>
					                            </div>
												<? endif;?>
												<div class = "panel panel-info">
					                              <div class = "panel-heading">
					                                <h3 class = "c-font-bold c-font-20 panel-title">
					                                  제기할 내용
					                                </h3>
					                              </div>
					                              <div class = "panel-body">
					                                <textarea id = "editor3" class = "form-control" name = "suggestion"></textarea>
					                              </div>
					                            </div>
												<div class = "button-group" style = "text-align:center">
													<button type = "submit" class = "btn btn-sm c-theme-btn c-btn-square c-btn-uppercase c-btn-bold">+보관</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
							<div class="progress-project-view">
								<div class = "box box-primary">
									<div class = "box-header ui-sortable-handle" style="cursor:move;">
										<i class="ion ion-clipboard"></i>
										<h3 class = "box-title">프로젝트 진행중...</h3>
									</div>
									<?php if(sizeof($progress_projects) > 0):?>
									<div class = "box-body c-page-faq-2">
										<div class="tab-content">
											<div class = "tab-pane active" id="all">
												<div class = "c-content-accordion-1">
													<div class = "panel-group" id="accordion" role="tablist">
														<?php foreach($progress_projects as $project):?>
															<div class = "panel">
																<div class="panel-heading" role="tab" id="heading">
																	<div class = "panel-title" style= "padding:15 0">
																		<?php echo "<a class='c-font-bold collapsed' data-toggle='collapse' data-parent='#accordion' href='#collapse".$project['id']."' aria-expanded='false' aria-controls='collapse' style='display:inline'>";?>
																			<i class = "c-theme-font fa fa-check-circle-o c-theme-font"></i>
																			<?php echo $project['project_title'];?>
																			<?php
																				$label_color = null;
																				if($project['progress_rate'] <= 25){
																				  $label_color = "bg-red";
																				}
																				elseif($project['progress_rate'] <= 50){
																				  $label_color = "bg-yellow";
																				}
																				elseif($project['progress_rate'] <= 75){
																				  $label_color = "bg-green";
																				}
																				elseif($project['progress_rate'] <= 100){
																				  $label_color = "bg-blue";
																				}
																				echo "<span class = 'badge ".$label_color."'>".$project['progress_rate']."%</span>";
																			?>
																		</a>
																		<div class = "pull-right">
																			<a href = "<?php echo site_url('/project/edit/'.$project['id']);?>">
																				<i class="fa fa-edit"></i>
																			</a>
																			<a href = "<?php echo site_url('/project/delete/'.$project['id']);?>">
																				<i class="fa fa-trash-o"></i>
																			</a>
																		</div>
																	</div>
											          			</div>
											          			<?php echo "<div id='collapse".$project['id']."' class='panel-collapse collapse' role='tabpanel' aria-labelledby='heading' aria-expanded='false' style='height:0px;'>";?>
											          				<div class="panel-body">
											          					<div class = "c-content-title-3 c-theme-border">
											          						<div class = "c-line c-dot c-dot-left"></div>
											          						<p class = "project-period">
											          							<?php 
											          							$start_date = DateTime::createFromFormat('Y-m-d H:i:s',$project['start_at']);
											          							echo $start_date->format('Y년m월d일 - ');
											          							$end_date = DateTime::createFromFormat('Y-m-d H:i:s',$project['end_at']);
											          							echo $end_date->format('Y년m월d일');
											          							?>
											          						</p>
											          						<p class = "project-detail-info">
											          							$<?php echo $project['contract_price'];?>
											          							<?php
											          							 if($project['project_type']=='hourly')
											          							 	echo "/Per Hour";
											          							 ?>
											          						</p>
											          						<p class = "project-description">
											          							<?php echo $project['project_description'];?>	
											          						</p>
											          					</div>
											          				</div>
											          			</div>
											          		</div>
											          	<? endforeach;?>
													</div>
												</div>
											</div>
										</div>
									</div>
									<? endif;?>
								</div>
							</div>
						</div>
						<div class = "col-md-5">
							<div class="my-result-view">
								<div class = "monthly-result">
									<div class = "box box-primary">
										<div class = "box-header ui-sortable-handle" style = "cursor:move;">
											<i class="ion ion-stats-bars"></i>
											<h3 class = "box-title">월별실적
											</h3>
										</div>
										<div class = "box-body">
											
										</div>
									</div>
								</div>
								<div class = "compare-with-before">
									<div class = "box box-primary">
										<div class = "box-header ui-sortable-handle" style = "cursor:move;">
											<i class="ion ion-map"></i>
											<h3 class = "box-title">실적분석</h3>
										</div>
										<div class = "box-body">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<pre>
			<?php print_r($chart_data);
			?>
		</pre>
		<script>
/*
		Morris.Area({
			element : 'chart',
			data:[<?php echo $chart_data;?>],
			xkey:'year',
			ykeys:['profit','purchase','sale'],
			labels:['profit','purchase','sale'],
			hideHover:'auto',
		});
*/
		Morris.Area({
			element : 'chart',
			data:[<?php echo $chart_data;?>],
			xkey:'year',
			ykeys:['profit'],
			labels:['profit'],
			hideHover:'auto',
		});
		</script>
	</body>
</html>
