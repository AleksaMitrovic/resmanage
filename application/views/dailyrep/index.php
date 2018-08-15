 <div class = "body-content"> 
  <br><br><br><br>
  <div class = "c-layout-page">
    <div class = "c-layout-breadcrumbs-1 c-fonts-bold c-bg-img-center c-bgimage c-subtitle dailyrep">
      <div class = "container">
        <div class = "c-page-title c-pull-left">
          <h2 class = "c-font-30">일보관리</h2>
          <h4 class = "c-font-dark c-font-slim">
            일보에 대한 열람 및 변경을 진행합니다.
          </h4>
        </div>
      </div>
    </div>
    <div class="c-content-box c-size-md">
      <div class="container">
        <?php if(!$rep_exists):?>
        	<h3>보관된 일보가 없습니다.</h3>
        <?php endif;?>
        <div class = "report-view">
          <?php if($rep_exists):?>

          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title c-font-30">일보리력</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="margin-bottom:500px;">
              <div class="box-group" id="accordion"> 
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <?php foreach($repinfos as $repinfo):?>
                  <div class = "panel box box-primary">
                    <div class = "box-header with-border">
                      <h4 class = "box-title">
                        <?php echo "<a data-toggle='collapse' data-parent='#accordion' href='#collapse".$repinfo['id']."'>";?>
                        <?php
                         $created_at = DateTime::createFromFormat('Y-m-d H:i:s',$repinfo['created_at']);
                         echo $created_at->format('Y년m월d일  일보');?></a>
                      </h4>
                      <div class = "pull-right">
                        <a data-toggle="modal" data-target="#modal-edit-report<?php echo $repinfo['id'];?>">
                          <i class="fa fa-edit"></i>
                        </a>
                      </div>
                    </div>
                    <?php echo "<div id='collapse".$repinfo['id']."' class = 'panel-collapse collapse'>";?>
                      <div class = "box-body">
                        <div class = "row">
                          <?php
                            if(sizeof($repinfo['prologs']) > 0)
                              echo "<div class='col-md-4'>";
                            else if(sizeof($repinfo['prologs']==0))
                              echo "<div class='col-md-6'>";
                          ?>                     
                            <div class = "panel panel-info">
                              <div class = "panel-heading">
                                <h3 class = "c-font-bold c-font-20 panel-title">
                                  사업내용
                                </h3>
                              </div>
                              <div class = "panel-body">
                                <?php echo $repinfo['businessrep'];?>
                              </div>
                            </div>
                          </div>
                          <?php
                            if(sizeof($repinfo['prologs']) >  0){
                              echo "<div class='col-md-4'>";
                            }
                            else if(sizeof($repinfo['prologs']==0))
                              echo "<div class='col-md-6'>";
                          ?> 
                            <div class = "panel panel-info">
                              <div class = "panel-heading">
                                <h3 class = "c-font-bold c-font-20 panel-title">
                                  제기할 내용
                                </h3>
                              </div>
                              <div class = "panel-body">
                                 <?php echo $repinfo['suggestion'];?>
                              </div>
                            </div> 
                          </div>
                          <?php if(sizeof($repinfo['prologs']) > 0):?>
                          <div class = "col-md-4">
                            <div class = "panel panel-info">
                              <div class = "panel-heading">
                                <h3 class = "c-font-bold c-font-20 panel-title">
                                  프로젝트별 진행정형
                                </h3>
                              </div>
                              <div class = "panel-body">
                                <?php foreach($repinfo['prologs'] as $prologs):?>
                                  <?if($prologs['bus_at_pro']):?>
                                  <div class = "prolog_heading">
                                    <span class = "c-font-bold c-font-30"><?php echo $prologs['project']['project_title'];?></span>
                                  </div>
                                  <div class = "prolog_body">
                                    <div class = "rate_log" style = "margin:10 0;">
                                      <?php
                                        $label_color = "#5dc09c";
                                        $rate = $prologs['pro_rate_change'];
                                        $prev_rate = $prologs['prev_rate'];
                                        $current_date = new DateTime();
                                        $contract_start = DateTime::createFromFormat('Y-m-d H:i:s',$prologs['project']['start_at']);
                                        $contract_end = DateTime::createFromFormat('Y-m-d H:i:s',$prologs['project']['end_at']);
                                        $elapsed_time = $current_date->diff($contract_start);
                                        if($prologs['project']['project_type'] == FIXED_PRICE)
                                        {
                                          
                                          $period = $contract_end->diff($contract_start);
                                          if((($elapsed_time->days) * 100 / ($period->days)) > $rate)
                                            $label_color = "#eb5d68";
                                        }
                                        else
                                        {
                                          if((($elapsed_time->days) * $prologs['project']['hour_week'] / 7) > $rate)
                                            $label_color = "#eb5d68";
                                          $rate = $rate * 100 / $prologs['project']['hour_week'];
                                        }
                                        echo "<span class='c-font-20'>".$prev_rate."%"." - ".$rate."%</span>";
                                      ?>
                                    </div>
                                    <div class = "project_log">
                                      <?php echo $prologs['bus_at_pro'];?>
                                    </div>
                                  </div>
                                  <hr>
                                  <? endif;?>
                                <? endforeach;?>
                              </div>
                            </div> 
                          </div>    
                          <? endif;?>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="modal modal-default fade" id="modal-edit-report<?php echo $repinfo['id'];?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title">일보변경</h4>
                        </div>
                        <div class="modal-body">
                          <?php echo form_open('dailyrep/update');?>
                            <input type = "hidden" name = "id" value = "<?php echo $repinfo['id'];?>">
                            <div class = "form-group">
                              <label>사업내용</label>
                              <?php echo "<textarea class='form-control' name='businessrep'>".$repinfo['businessrep']."</textarea>";?>
                            </div>
                            <?php if(sizeof($repinfo['prologs']) > 0):?>
                            <div class = "form-group">
                              <label>프로젝트별 진행내용</label>
                              <?php foreach($repinfo['prologs'] as $prologs):?>
                                <?php if($prologs['project']['project_type'] == FIXED_PRICE):?>
                                <div class = "box box-default box-fixed collapsed-box box-solid box-project">
                                <? endif;?>
                                <?php if($prologs['project']['project_type'] == HOURLY_PRICE):?>
                                <div class = "box box-default box-hourly collapsed-box box-solid box-project">
                                <? endif;?>
                                  <div class = "box-header with-border">
                                    <h3 class = "box-title"><?php echo $prologs['project']['project_title'];?></h3>
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
                                          $rate = $prologs['pro_rate_change'];
                                          if($prologs['project']['project_type'] == HOURLY_PRICE)
                                            $rate -= $prologs['prev_rate'];
                                          if(!$prologs['bus_at_pro'])
                                            $rate = '';
                                          echo "<input type ='text' class='form-control' style = 'width:20%;display:inline;' name='rate_".$prologs['project_id']."' value='".$rate."'>";
                                          echo $prologs['project']['project_type'] == FIXED_PRICE ? "%" : "시간";
                                      ?>
                                    </div>
                                    <div class = "form-group">
                                      <span class = "c-font-15">작업내용:</span>
                                      <?php echo "<textarea id='editor' class='form-control' name='projectrep_".$prologs['project_id']."'>".$prologs['bus_at_pro']."</textarea>";?>
                                    </div>
                                  </div>
                                </div>
                              <? endforeach;?>
                            </div>
                            <? endif;?>
                            <div class = "form-group">
                              <label>제기할 내용</label>
                              <?php echo "<textarea class='form-control' name='suggestion'>".$repinfo['suggestion']."</textarea>";?>
                            </div>
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
                <? endforeach;?>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <div class = "pagination-link">
          	<?php echo $this->pagination->create_links();?>
          </div>
          <?php endif;?>
        </div>
      </div>
    </div>
  </div>
</div>
 