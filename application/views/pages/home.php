<div class = "body-content">
	<?php
		$chart_data = '';
		$total_result = 0;
		$this_month_result = 0;
		$tax_result = array();
		$id = 0;
		$current_date = new DateTime();

		for($x = 1; $x <= 12; $x++){
			$month = $x;
			if($x < 10)
				$month = "0".$x;
			$year = (int)$current_date->format('Y');
			if($x > (int)$current_date->format('m'))
				$year -= 1;
			$date_month = $year."-".$month;
			$tax_result += [$date_month => 0];
		}
		foreach($taxed_logs as $taxed_log)
		{	

			$total_result += $taxed_log['taxed_price'];
			$date = DateTime::createFromFormat('Y-m-d H:i:s',$taxed_log['taxed_date']);

			$year = (int)$date->format('Y') - 1;
			$month = (int)$date->format('m') + 1;
			$last_date = DateTime::createFromFormat('Y-m-d H:i:s',$year."-".$month."-"."01 00:00:00");
			if(($current_date->diff($date))->format('f') >= 0 && ($date->diff($last_date))->format('f') >= 0)
				$tax_result[$date->format('Y-m')] += $taxed_log['taxed_price'];
		}
		$current_year = (int)$current_date->format('Y');
		$current_month = (int)$current_date->format('m');
		$x = $current_month + 1;
		$year = $current_year - 1;
		$this_month_result = $tax_result[$current_year."-".(($current_month < 10) ? "0".$current_month : $current_month)];
		do
		{
			if($x > 12){
				$x = 1;
				$year++;
			}
			$month = ($x < 10) ? "0".$x : $x;
			$date_month = $year."-".$month;
			$chart_data .= "{ date:'".$date_month."', profit:".$tax_result[$date_month]."}, ";
			$x++;
		}while($x != (int)$current_date->format('m') + 1);
		$chart_data = substr($chart_data,0,-2);
	
	?>

	<div class = "black-panel">
		<br><br><br><br>
		<div class = "row">
			<div class="col-md-10" style="margin:0 auto; float:none;">
				<div class="row" style = "margin-top:30px;">
					<div class="col-md-4">
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
					</div>
				</div>
				<div class = "row" style = "margin-top:20px;">
					<div class = "col-md-7">
						<div class="my-result-view">
							<div class = "monthly-result">
								<div class = "box box-solid bg-teal-gradient">
									<div class = "box-header">
										<i class="ion ion-stats-bars"></i>
										<h3 class = "c-font-white box-title">월별실적
										</h3>
										<?php if($this->session->flashdata('boss_page')):?>
											<div class="pull-right">
												<a style="padding:0px 15px;display:inline;">
													<?php if(!$result_owner_image):?>
														<a style="padding:0px 15px;display:inline;">
															<button class="img-bordered-sm" style = "background-color:#f4f4f4;vertical-align:middle;width:40px;height:40px; border-radius:50%;" value="total">전체</button>
														</a>
													<? endif;?>
													<?php if($result_owner_image):?>

													<img src="<?php echo base_url();?>assets/img/account/<?php echo $result_owner_image;?>"
														 style="width:40px;height:40px;border-radius:50%;">                  
													<? endif;?>
												</a>
											</div>
										<? endif;?>
									</div>
									<div class = "box-body border-radius-none">
										<div class = "svg-chart" id = "chart" style = "width:100%;"></div>
									</div>
									<div class="box-footer">
										<div class="row">
											<div class="col-md-6 text-center" style="border-right:1px solid #f4f4f4;">
												<p class="c-font-20 c-font-black"><?php echo $total_result;?>$</p>
												<span class="c-font-15 c-font-black">루계실적</span>
											</div>
											<div class="col-md-6 text-center">
												<p class="c-font-20 c-font-black"><?php echo $this_month_result;?>$</p>	
												<span class="c-font-15 c-font-black">월실적</span>
											</div>
										</div>
										<hr>
										<?php if($this->session->flashdata('boss_page')):?>
										<div class="row" style = "margin-top:20px;">
											<div style="margin:0 auto; float:none;">
											<?php foreach($users as $user):?>
												<a class="userimage" id = "<?php echo $user['id'];?>" style="padding:0px 15px;display:inline;">
												    <img class="img-bordered-sm" src="<?php echo base_url();?>assets/img/account/<?php echo $user['picture'];?>"
													 style="width:60px;height:60px;border-radius:50%;">                  
												</a>		
											<? endforeach;?>
											<a class="userimage" id = "" style="padding:0px 15px;display:inline;">
												<button class="img-bordered-sm" style = "background-color:#f4f4f4;vertical-align:middle;width:60px;height:60px; border-radius:50%;" value="total">전체</button>
											</a>	
											</div>

										</div>
										<? endif;?>
									</div>
								</div>
							</div>
						</div>
						<div class="today-rep-view">
							<div class = "box box-primary">
								<div class = "box-header">
									<i class="ion ion-compose"></i>
									<h3 class = "box-title">일보열람</h3>
									<a class = "pull-right create-report" data-toggle="modal" data-target="#modal-create-report">
										<i class="ion ion-paintbrush"></i>
									</a>
								</div>
								<div class="modal modal-default fade" id="modal-create-report">
						          <div class="modal-dialog">
						            <div class="modal-content">
						              <div class="modal-header">
						                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						                  <span aria-hidden="true">&times;</span></button>
						                <h4 class="modal-title">일보작성</h4>
						              </div>
						              <div class="modal-body">
						              	<?php echo form_open('dailyrep/create',array('id' => 'create-report'));?>
		                                  	<input type = "hidden" name = "user_id" value = "<?php echo $this->session->userdata('user_id');?>">
		                                  	<div class="form-group">
		                                  		<div class="content-header">
		                                  			<h3 class="c-font-bold c-font-20 panel-title">
		                                  				일보날자
		                                  			</h3>
		                                  		</div>
		                                  		<div class="content-body">
		                                  			<input type="text" class="form-control" id="report-date-picker" name="report-date-picker">
		                                  			<input type="hidden" name="report_date">
		                                  		</div>
		                                  	</div>
		                                  	<div class="form-group">
			                                  	<div class = "businessreport">
			                                  		<div class="content-header">
					                                <h3 class = "c-font-bold c-font-20 panel-title">
					                                  사업내용
					                                </h3>
					                            	</div>
					                            	<div class="content-body">
					                                <textarea id = "businessrep" class = "form-control" name = "businessrep"></textarea>
					                            	</div>
				                            	</div>	
			                            	</div>
			                            	<hr>
			                            	
				                            <div class="projectreport">	
					                            <?php if(sizeof($progress_projects) > 0):?>
					                            	<div class="content-header">
						                                <h3 class = "c-font-bold c-font-20 panel-title">
						                                  프로젝트별 일보
						                                </h3>
						                            </div>
						                            <br>
						                            <div class="row">
						                            	<div class="col-md-3">
														<div class="c-color-view c-bg-green-2 c-bg-green-2-font c-font-14 c-font-bold c-font-uppercase" style="display:inline;	margin-right:5;padding:5 20"></div>
														<span class="c-font-15">고정액과제</span>
														</div>
														<div class="col-md-5">
						                            	<div class="c-color-view c-bg-blue-3 c-bg-blue-3-font c-font-14 c-font-bold c-font-uppercase" style="display:inline; margin-right:5;padding:5 20"></div>
														<span class="c-font-15">시간과제</span>
														</div>
						                        	</div>
						                        	<br>
						                            <div class="content-body">
						                                <?php foreach($progress_projects as $project):?>
						                                	<?php if($project['project_owner'] == $this->session->userdata('user_id')):?>
						                                	<?php if($project['project_type'] == FIXED_PRICE):?>
						                                	<div class = "box box-default box-fixed collapsed-box box-solid box-project">
						                                	<? endif;?>
						                                	<?php if($project['project_type'] == HOURLY_PRICE):?>
						                                	<div class = "box box-default box-hourly collapsed-box box-solid box-project">
						                                	<? endif;?>
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
																		<span class = "c-font-15">진척률(작업시간):</span>
																		<?php 
																			echo "<input type ='text' class='form-control' style = 'width:20%;display:inline;' name='rate_".$project['id']."' id ='rate_".$project['id']."'>";
																			echo $project['project_type'] == FIXED_PRICE?"%":"시간";
																		?>
																	</div>
																	<div class = "form-group">
																		<span class = "c-font-15">작업내용:</span>
																		<?php echo "<textarea id='editor' class='form-control' name='projectrep_".$project['id']."' id='projectrep_".$project['id']."'></textarea>";?>
																	</div>
																</div>
															</div>
															<? endif;?>
														<? endforeach;?>
													</div>
												<? endif;?>
											</div>
											<hr>
											<div class="form-group">
												<div class="suggestionreport">
													<div class="content-header">
					                                <h3 class = "c-font-bold c-font-20 panel-title">
					                                  제기할 내용
					                                </h3>
					                            	</div>
					                            	<div class="content-body">
						                           		<textarea id = "suggestion" class = "form-control" name = "suggestion"></textarea>
						                        	</div>
					                           	</div>
					                        </div>
				                           	<hr>
				                           	<div class="button-group" style = "text-align:center;">
					                           	<button type="button" class="btn btn-default" data-dismiss="modal">취 소</button>
					                           	<button type="submit" class="btn btn-default">확 인</button>
				                           	</div>
		                                </form>  
						              </div>
						            </div>
						            <!-- /.modal-content -->	
						          </div>
						          <!-- /.modal-dialog -->
							    </div>
						        <!-- /.modal -->
								<div class = "box-body">
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
									<div class="report-content" style = "padding:25 15;">
										<div class = "businessreport">
				          					<h3 class="box-title">사업내용</h3>
								          	<?php echo $last_report['businessrep'];?>
							          	</div>	
							          	<hr>
							          	<div class="projectreport">
						      				<?php if(sizeof($project_logs) > 0):?>
										  		<h3 class="box-title">프로젝트별 진행정형</h3>
									        	<ul class = "todo-list">
										        <?php foreach($project_logs as $project_log):?>
										        	<?php if($project_log['bus_at_pro']):?>
										        	<li>
										        		<div class = "project_panel_head">
											        		<span class = "handle">
											        			<i class = "fa fa-ellipsis-v"></i>
											        			<i class = "fa fa-ellipsis-v"></i>
											        		</span>
											        		<span class = "text"><?php echo $project_log['project']['project_title'];?></span>
										        		</div>
										        		<div class = "project_panel_body" style= "padding:0 30">
										        			<?php 
										        				$prev_rate = $project_log['prev_rate'];
										        				$current_rate = $project_log['pro_rate_change'];
										        				if($project_log['project']['project_type'] == HOURLY_PRICE)
										        				{
										        					$prev_rate = ($prev_rate * 100) / $project_log['project']['hour_week'];
										        					$current_rate = ($current_rate * 100) / $project_log['project']['hour_week'];
										        				}
										        			?>
										        			<p style = "margin:15 0"><?php echo $prev_rate."% - ".$current_rate."%";?></p>
										        			<p><?php echo $project_log['bus_at_pro'];?></p>
										        		</div>
										        	</li>
										        	<? endif;?>
										        <? endforeach;?>
									      		</ul>
									      		<hr>
											<? endif;?>
										</div>
										<div class="suggestion">
											<h3 class="box-title">제기할 내용</h3>
											<?php echo $last_report['suggestion'];?>
										</div>
									</div>
									<? endif;?>
								</div>
							</div>
						</div>

					</div>
					<div class = "col-md-5">
						<div class="progress-project-view">
							<div class = "box box-primary">
								<div class = "box-header">
									<i class="ion ion-clipboard"></i>
									<h3 class = "box-title">진행중인 프로젝트</h3>
								</div>
								<?php if(sizeof($progress_projects) > 0):?>
								<div class = "box-body c-page-faq-2">
									<div class="tab-content">
										<div class = "tab-pane active" id="all">
											<div class = "c-content-accordion-1">
												<div class = "panel-group" id="accordion" role="tablist">
													<?php foreach($progress_projects as $project):?>
														<?php
															$label_color = "#5dc09c";
															$rate = $project['progress_rate'];
															$current_date = new DateTime();
															$contract_start = DateTime::createFromFormat('Y-m-d H:i:s',$project['start_at']);
															$contract_end = DateTime::createFromFormat('Y-m-d H:i:s',$project['end_at']);
															$elapsed_time = $current_date->diff($contract_start);
															if($project['project_type'] == FIXED_PRICE)
															{
																
																$period = $contract_end->diff($contract_start);
																if((($elapsed_time->days) * 100 / ($period->days)) > $rate)
																	$label_color = "#eb5d68";
															}
															else
															{
																if((($elapsed_time->days) * $project['hour_week'] / 7) > $rate)
																	$label_color = "#eb5d68";
																$rate = (int)($rate * 100 / $project['hour_week']);
															}
														?>
														<div class = "panel">
															<div class="panel-heading" role="tab" id="heading" style = "border-radius:0!important;border-left:8px solid <?php echo $label_color;?>;">
																<div class = "panel-title" style= "padding:15 0">
																	<?php echo "<a class='c-font-bold collapsed' data-toggle='collapse' data-parent='#accordion' href='#collapse".$project['id']."' aria-expanded='false' aria-controls='collapse' style='display:inline'>";?>
																		<i class = "c-theme-font fa fa-check-circle-o c-theme-font" style="color:<?php echo $label_color;?>!important;"></i>
																		<?php
																			$title = $project['project_title'];
																			if(strlen($title) > 20){
																				$title = substr($title,0,20).'...';
																			}
																			echo $title
																		?>
																		<?php
																			echo "<span class = 'badge".($this->session->flashdata('boss_page')?"'":" pull-right'")." style='font-size:24px;'>".$rate."%</span>";
																		?>
																		<?php if($this->session->flashdata('boss_page')):?>
																		<div class="pull-right" style="margin-top:-14px;">
																		<?php if($is_changed[$project['id']]):?>
												                            <?php echo "<a data-toggle='modal' data-target='#modal-change".$project['id']."' style='padding-right:15px;'>";?>
												                            	<button class="c-font-15 badge bg-gray">사양변경요청</button>
												                            </a>
											                          	<?endif;?>
																		<?php
																			$image_name = "account.jpeg";
																			if($project_owner_images[$project['id']])
																				$image_name = $project_owner_images[$project['id']];
																			echo "<img class='img-bordered-sm' src='".base_url()."assets/img/account/".$image_name."' style='width:60px;height:60px;border-radius:50%;'>";
																		?>
																		</div>
																		<? endif;?>
																	</a>
				
																</div>
										          			</div>
										          			<?php echo "<div class='modal modal-default fade' id='modal-change".$project['id']."'>";?>
								                              <div class="modal-dialog">
								                                <div class="modal-content">
								                                  <div class="modal-header">
								                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								                                      <span aria-hidden="true">&times;</span></button>
								                                    <h4 class="modal-title">프로젝트변경</h4>
								                                  </div>
								                                  <div class="modal-body">
								                                    <?php echo form_open('project/update_project');?>
								                                      <input type = "hidden" name = "id" value = "<?php echo $project['id'];?>">
								                                      <div class = "form-group">
								                                        <div class = "row">
								                                          <div class = "col-md-6">
								                                            <label class="c-font-15">프로젝트명</label>
								                                            <div>
								                                            <?php echo "<input type='text class='form-control' name='project-title' value='".$is_changed[$project['id']]['title']."'>";?>
								                                            </div>
								                                          </div>
								                                        </div>
								                                      </div>
								                                      <div class = "form-group">
								                                        <label class="c-font-15">프로젝트서술</label>
								                                        <div>
								                                        <textarea id = "editor1" class = "form-control" name="project-description"><?php echo $is_changed[$project['id']]['description'];?></textarea>
								                                        </div>
								                                      </div>
								                                      <div class="form-group">
								                                        <div class="row">
								                                          <div class="col-md-6">
								                                            <label class="c-font-15">계약가격</label>
								                                            <div>
								                                              <div class="input-group">
								                                                <span class="input-group-addon">
								                                                  <i class="fa fa-dollar"></i>
								                                                </span>
								                                                <?php echo "<input type='text id='fixed-price' name='contract-price' style='width:30%;' value='".$is_changed[$project['id']]['price']."' >";?>
								                                              </div>
								                                            </div>
								                                          </div>
								                                          <div class="col-md-6">
								                                            <label class="c-font-15"><?php 
								                                            if($is_changed[$project['id']]['project_type'] == FIXED_PRICE){
								                                              echo "계약마감기일</label>";
								                                              $pro_end_date = DateTime::createFromFormat('Y-m-d H:i:s',$is_changed[$project['id']]['end_at']);
								                                              echo "<input type='text' name = 'pro_end_date' id='pro_end_date' value='".$pro_end_date->format('Y년m월d일')."'/>";
								                                            }
								                                            else
								                                            {
								                                              echo "주간당 시간수</label>";
								                                              echo "<input type='text' class='form-control' name='hour_week' value='".$is_changed[$project['id']]['hour_week']."'/>";
								                                            }?>
								                                          </div>
								                                        </div>
								                                      </div>
								                                      <hr>
								                                      <div class="button-group" style = "text-align:center;">
								                                        <button type="button" class="btn btn-default" data-dismiss="modal">취 소</button>
								                                        <button type="submit" class="btn btn-default">확 인</button>
								                                      </div>    
								                                    </form>  
								                                  </div>
								                                </div>
								                                <!-- /.modal-content -->  
								                              </div>
								                              <!-- /.modal-dialog -->
								                            </div>
										          			<?php echo "<div id='collapse".$project['id']."' class='panel-collapse collapse' role='tabpanel' aria-labelledby='heading' aria-expanded='false' style='height:0px;'>";?>
										          				<div class="panel-body">
										          					<div class = "c-content-title-3 c-theme-border" style = "border-color:<?php echo $label_color;?>!important;">
										          						<div class = "c-line c-dot c-dot-left"></div>
										          						<?php echo "<p>".$project['project_title']."</p><br>";?>
										          						<p class = "project-period">
										  
										          							<?php 
										          							if($project['project_type']=='fixed'){
											          							$start_date = DateTime::createFromFormat('Y-m-d H:i:s',$project['start_at']);
											          							echo $start_date->format('Y년m월d일 - ');
											          							$end_date = DateTime::createFromFormat('Y-m-d H:i:s',$project['end_at']);
											          							echo $end_date->format('Y년m월d일');
											          						}
											          						else
											          						{
											          							echo $project['hour_week']."시간/주";
											          						}
										          							?>
										          						</p>
										          						<p class = "project-detail-info">
										          							$<?php echo $project['contract_price'];?>
										          							<?php
										          							 if($project['project_type']=='hourly')
										          							 	echo "/시간";
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
						<?php if($this->session->flashdata('boss_page')):?>
						<div class="pending-project-view">
							<div class = "box box-primary">
								<div class = "box-header">
									<i class="ion ion-clipboard"></i>
									<h3 class = "box-title">대기중인 프로젝트</h3>
								</div>
								<?php if(sizeof($pending_projects) > 0):?>
								<div class = "box-body c-page-faq-2">
									<div class="tab-content">
										<div class = "tab-pane active" id="all">
											<div class = "c-content-accordion-1">
												<div class = "panel-group" id="accordion" role="tablist">
													<?php foreach($pending_projects as $project):?>
														<?php
															$label_color = "#5dc09c";
															$rate = $project['progress_rate'];
															$current_date = new DateTime();
															$contract_start = DateTime::createFromFormat('Y-m-d H:i:s',$project['start_at']);
															$contract_end = DateTime::createFromFormat('Y-m-d H:i:s',$project['end_at']);
															$elapsed_time = $current_date->diff($contract_start);
															if($project['project_type'] == FIXED_PRICE)
															{
																
																$period = $contract_end->diff($contract_start);
																if((($elapsed_time->days) * 100 / ($period->days)) > $rate)
																	$label_color = "#eb5d68";
															}
															else
															{
																if((($elapsed_time->days) * $project['hour_week'] / 7) > $rate)
																	$label_color = "#eb5d68";
																$rate = (int)($rate * 100 / $project['hour_week']);
															}
														?>
														<div class = "panel">
															<div class="panel-heading" role="tab" id="heading" style = "border-radius:0!important;">
																<div class = "panel-title" style= "padding:15 0">
																	<?php echo "<a class='c-font-bold collapsed' data-toggle='collapse' data-parent='#accordion' href='#pending-collapse".$project['id']."' aria-expanded='false' aria-controls='collapse' style='display:inline'>";?>
																		<i class = "c-theme-font fa fa-check-circle-o c-theme-font"></i>
																		<?php
																			$title = $project['project_title'];
																			if(strlen($title) > 20){
																				$title = substr($title,0,20	).'...';
																			}
																			echo $title;
																		?>
																	</a>
																	<div class="pull-right" style = "margin-top:-14px;">
																		<a data-toggle="modal" data-target="#modal-finish<?php echo $project['id'];?>" style="padding-right:15px;">
												                            <button class="c-font-15 badge bg-gray">결제상태로 이행</button>
												                        </a>
												                        <?php
																			$image_name = "account.jpeg";
																			if($project_owner_images[$project['id']])
																				$image_name = $project_owner_images[$project['id']];
																		
																			echo "<img class='img-bordered-sm' src='".base_url()."assets/img/account/".$image_name."' style='width:55px;height:55px;border-radius:50%;'>";
																		?>
											                    	</div>
																</div>

										          			</div>
										          			<div class="modal modal-default fade" id="modal-finish<?php echo $project['id'];?>">
									                            <div class="modal-dialog">
										                            <div class="modal-content">
										                                <div class="modal-header">
										                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										                                    <span aria-hidden="true">&times;</span></button>
										                                  <h4 class="modal-title">일보작성</h4>
										                                </div>	
										                                <div class="modal-body">
										                                  <?php echo form_open('project/moveTotaxed');?>
										                                    <input type = "text" name = "id" value = "<?php echo $project['id'];?>"> 
										                                    <div class="form-group text-center">
										                                      <label>결제액수 : </label>
										                                      <input type="text" name="taxed-price">
										                                    </div>
										                                    <div class="form-group text-center">
										                                    	<label>결제날자 : </label>
										                                    	<input type = "text" name="tax_date_picker" >
										                                    	<input type = "hidden" name = "taxed_date">
										                                    </div>
										                                    <br>
										                                    <div class="button-group" style = "text-align:center;">
										                                      <button type="button" class="btn btn-default" data-dismiss="modal">취 소</button>
										                                      <button type="submit" class="btn btn-default">확 인</button>
										                                    </div>
										                                  </form>
										                                </div>
										                            </div>
									                            </div>
									         				</div>	
										          			<?php echo "<div id='pending-collapse".$project['id']."' class='panel-collapse collapse' role='tabpanel' aria-labelledby='heading' aria-expanded='false' style='height:0px;'>";?>
										          				<div class="panel-body">
										          					<div class = "c-content-title-3 c-theme-border">
										          						<div class = "c-line c-dot c-dot-left"></div>
										          						<?php echo "<p>".$project['project_title']."</p><br>";?>
										          						<p class = "project-period">
										          							<?php 
										          							if($project['project_type']=='fixed'){
											          							$start_date = DateTime::createFromFormat('Y-m-d H:i:s',$project['start_at']);
											          							echo $start_date->format('Y년m월d일 - ');
											          							$end_date = DateTime::createFromFormat('Y-m-d H:i:s',$project['end_at']);
											          							echo $end_date->format('Y년m월d일');
											          						}
											          						else
											          						{
											          							echo $project['hour_week']."시간/주";
											          						}
										          							?>
										          						</p>
										          						<p class = "project-detail-info">
										          							$<?php echo $project['contract_price'];?>
										          							<?php
										          							 if($project['project_type']=='hourly')
										          							 	echo "/시간";
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
						<? endif;?>

					</div>
				</div>
			</div>	
		</div>
	</div>
	<script>
		
		$('#create-report').submit(function(e){
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
						$('#modal-create-report').removeClass('in');
						$('.modal-backdrop').remove();
						randoem();
					}
					else
					{
						$.each(response.messages,function(key,value){
							if(value.length > 0){
								var element = $('#' + key);
								element.closest('div.form-group')
								.addClass('has-error')
								.find('.text-danger').remove();
								element.after(value);
							}	
						});
					}
				}
			});
		});
		var randoem = function(){
			location.reload();
		}
		$(".userimage").click(function(){
			window.location.href = "<?php echo base_url();?>" + $(this).attr('id');
		});

	    $("input[name='report-date-picker']").daterangepicker({
	      singleDatePicker: true,
	      showDropdowns: true,
	      minYear: 1930,
	      maxYear: parseInt(moment().format('YYYY'),10) + 10
	    }, function(start, end, label) {
	      $("input[name='report_date']").val(start.format('YYYY-MM-DD 00:00:00'));
	    });
		Morris.Line({
			element : 'chart',
			data:[<?php echo $chart_data;?>],
			xkey:'date',
			ykeys:['profit'],
			labels:['실적'],
			hideHover:'auto',
			lineColors:['#ffffff'],
			pointFillColors:['#ffffff'],
			pointStrokeColors:['#ffffff'],
			xLabelFormat:function(x){return (x.getMonth()+1).toString()+"월";},
			gridTextColor:['#ffffff'],
			gridLineColor:['#ffffff'],
			yLabelFormat:function(y){ return '$' + y.toString();}
		});
	</script>