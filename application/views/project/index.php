<div class = "body-content"> 
  <div class="c-layout-page">
    <div class = "c-layout-breadcrumbs-1 c-fonts-bold c-bg-img-center c-bgimage-full project">
      <div class="c-breadcrumbs-wrapper">
        <div class="container">
          <div class="c-page-title c-pull-left">
            <h3 class="c-font-bold c-font-white c-font-20 c-font-slim c-opacity-09">프로젝트관리</h3>
            <h4 class="c-font-white c-font-thin c-opacity-08">프로젝트등록 및 관리를 진행합니다.</h4>
          </div>
        </div>
      </div>
    </div>
    <div class ="c-content-box c-size-md">
      <div class="container">
        <?php if(sizeof($progress_projects) > 0):?>
        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title c-font-25"><?php echo "진행중인 프로젝트";?></h3>
          </div>
          <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
              <thead>
                <th class="hidden-xs">번호</th>
                <th>프로젝트명</th>
                <th>프로젝트형태</th>
                <th>프로젝트서술</th>
          
                <th>계약기간(주당 시간수)</th>
              
                <th>계약가격</th>  
                <th>프로젝트진척률</th>
                <th><em class="fa fa-cog"></em></th>
              </thead>
              <tbody>
                <?php 
                $id = 1;
                foreach($progress_projects as $project):?>
                <tr>
                  <td class="hidden-xs"><?php echo $id++?></td>
                  <td><?php echo $project['project_title'];?></td>
                  <td><?php echo ($project['project_type']=='hourly')?"시간과제":"고정액과제";?></td>
                  <td><?php echo character_limiter($project['project_description'],10);?></td>
                  <td>
                    <?php
                      if($project['project_type'] == FIXED_PRICE){
                        $st_date = DateTime::createFromFormat('Y-m-d H:i:s', $project['start_at']);
                        $en_date = DateTime::createFromFormat('Y-m-d H:i:s', $project['end_at']);
                        echo $st_date->format('Y년 m월 d일')." - ".$en_date->format('Y년 m월 d일');
                      }
                      else
                        echo $project['hour_week']."시간/주";
                    ?>
                  </td>
                  <td class="hidden-xs"><?php echo ($project['contract_price'])."$".(($project['project_type']=='hourly')?" / 시간":"");?></td>
                  <td>
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
                      $rate = $rate * 100 / $project['hour_week'];
                    }
                  ?>
                  <span class = "badge" style="font-size:24px;"><?php echo $rate;?>%</span>
                  </td>
                  <td align="center">
                    <?php echo "<a data-toggle='modal' data-target='#modal-contract-change".$project['id']."' style='padding-right:15px;'>";?>
                          <i class="fa fa-exchange"></i>
                        </a>
                    <?php echo "<a data-toggle='modal' data-target='#modal-status-change".$project['id']."'>";?>
                        <i class="fa fa-hand-stop-o"></i>
                    </a>
                  </td>
                </tr> 
                <?php echo "<div class='modal modal-default fade' id='modal-contract-change".$project['id']."'>";?>
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">프로젝트사양변경</h4>
                      </div>
                      <div class="modal-body">
                        <?php echo form_open('project/regist_pro_change');?>
                          <input type = "hidden" class="form-control" name = "id" value = "<?php echo $project['id'];?>">
                          <input type = "hidden" class="form-control" name = "project-type" value = "<?php echo $project['project_type'];?>">
                          <div class = "form-group">
                            <div class = "row">
                              <div class = "col-md-6">
                                <label class="c-font-15">프로젝트명</label>
                                <div>
                                <?php echo "<input type='text class='form-control' name='project-title' value='".$project['project_title']."'>";?>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class = "form-group">
                            <label class="c-font-15">프로젝트서술</label>
                            <div>
                            <textarea id = "editor1" class = "form-control" name="project-description"><?php echo $project['project_description'];?></textarea>
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
                                    <input type="text" class="form-control" name="contract_price" value="<?php echo $project['contract_price'];?>">
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <label class="c-font-15"><?php 
                                  if($project['project_type'] == FIXED_PRICE){
                                    echo "계약마감기일</label>";
                                    $pro_end_date = DateTime::createFromFormat('Y-m-d H:i:s',$project['end_at']);
                                    echo "<input type='text' class='form-control' name='date_end_picker' value='".$pro_end_date->format('m/d/Y')."'/>";
                                    echo "<input type='hidden' name='pro_end_date' value='".$pro_end_date->format('Y-m-d H:i:s')."'/>";
                                  }
                                  else
                                  {
                                    echo "주간당 시간수</label>";
                                    echo "<input type='text' class='form-control' name='hour_week' value='".$project['hour_week']."'/>";
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
                <?php echo "<div class='modal modal-default fade' id='modal-status-change".$project['id']."'>";?>
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">프로젝트상태변경</h4>
                      </div>
                      <div class="modal-body">
                        <?php echo form_open('project/moveTopending');?>
                          <input type = "hidden" name = "id" value = "<?php echo $project['id'];?>">
                          <div class="form-group">
                            <div class = "row">
                              <div class="col-md-8 offset-md-2" style="width:250px;margin:0 auto; float:none;">
                                <div class = "radio-status" style = "padding-left:30px;">
                                  <label>
                                    <input type="radio" name="status-type" value="Fully pending" checked/>
                                    프로젝트 완료
                                  </label>
                                  <br><br>
                                  <label>
                                    <input type="radio" name="status-type" value="Partly pending"/>
                                    프로젝트 부분완료
                                  </label>
                                  <br><br>
                                  <label>
                                    <input type="radio" name="status-type" value="Interrupted"/>
                                    프로젝트 중단
                                  </label>
                                </div>                         
                            </div>
                          </div>
                          <br>
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
                <?php endforeach;?>  
              </tbody>
            </table>
          </div>
        </div>
        <? endif;?>
        <br><br>
        <?php if(sizeof($taxed_projects) > 0):?>
        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title c-font-25"><?php echo "완성된 프로젝트";?></h3>
          </div>
          <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
              <thead>
                <th class="hidden-xs">번호</th>
                <th>프로젝트명</th>
                <th>프로젝트서술</th>
          
                <th>계약기간(주간당 시간수)</th>
              
                <th>계약가격</th>  
                <th>결제액수</th>
                <th>결제날자</th>
                <th>상태</th>
              </thead>  
              <tbody>
                <?php 
                $id = 1;
                foreach($taxed_projects as $project):?>
                <tr>
                  <td class="hidden-xs"><?php echo $id++?></td>
                  <td><?php echo $project['project_title'];?></td>
                  <td><?php echo character_limiter($project['project_description'],10);?></td>
                  <td>
                    <?php
                      if($project['project_type'] == FIXED_PRICE){
                        $st_date = DateTime::createFromFormat('Y-m-d H:i:s', $project['start_at']);
                        $en_date = DateTime::createFromFormat('Y-m-d H:i:s', $project['end_at']);
                        echo $st_date->format('Y년 m월 d일')." - ".$en_date->format('Y년 m월 d일');
                      }
                      else
                        echo $project['hour_week']."시간/주";
                    ?>
                  </td>
                  <td class="hidden-xs"><?php echo $project['contract_price']?>$</td>
                  <td class="hidden-xs"><?php echo $project['taxed_price'];?>$</td>
                  <td>
                    <?php
                      $taxed_date = DateTime::createFromFormat('Y-m-d H:i:s',$project['taxed_date']);
                      if($project['taxed_price'] == 0)
                        echo "결제된 금액이 없습니다.";
                      else
                        echo $taxed_date->format('Y년 m월 d일');
                    ?>
                  </td>
                  <td>
                  <p class="c-font-20"><span class = "label label-warning"><?php
                  if($project['taxed_status'] == 'Fully taxed')
                    echo '완료';
                  elseif($project['taxed_status'] == 'Interrupt finished')
                    echo '중단';
                  elseif($project['taxed_status'] == 'Partly taxed')
                    echo '부분완료';
                  ?></span></p>
                  </td>
                </tr> 
                <?php endforeach; ?>  
              </tbody>
            </table>
          </div>
        </div>
        <div class = "pagination-link">
          <?php echo $this->pagination->create_links();?>
        </div>
        <? endif;?>
        <br>
        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title c-font-25"><?php echo "프로젝트 등록";?></h3>
          </div>
          <div class="box-body table-responsive no-padding">
            <div class="contract-content" style="padding:0 100">
              <?php echo form_open('project/create',array('id' => 'create-project'));?>
                <input type = "hidden" name = "user_id" value = "<?php echo $this->session->userdata('user_id');?>">
                <div class = "project-form-group">
                  <br>
                  <h3 style = "text-align:center;">계약정보</h3><br>
                  <div class = "form-group">
                    <div class = "row">
                      <div class = "col-md-6 offset-md-3" style="margin:0 auto; float:none;">
                        <div class="input-group" style = "width:100%;">
                          <input type = "text" id ="project-title" class = "form-control" name="project-title" placeholder="프로젝트명">
                        </div>  
                      </div>
                    </div>
                  </div>
                  <div class = "form-group">
                    <div class="input-group" style = "width:100%!important;">
                      <textarea id = "project-description" class = "form-control" name="project-description" placeholder="프로젝트에 대한 간단한 서술을 적습니다."></textarea>
                    </div>
                  </div>
                  <br>
                  <div class="project-info">
                    <div class="row">
                      <div class = "col-md-6 offset-md-3" style="margin:0 auto; float:none;">
                        <br>
                        <div class="row">
                          <div class = "col-md-6">
                            <div class = "radio-price-type col-md-10 offset-md-1">
                              <label>
                                <input type="radio" name="project-type" id="fixed-type" value="fixed" checked>
                                고정과제
                              </label>
                            </div>
                          </div>
                          <div class = "col-md-6">
                            <div class="form-group">
                              <div class = "input-group col-md-10 offset-md-1">
                                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                <input type="text" id="fixed-price" class="form-control" name="fixed-price" placeholder = "계약액수">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-6 offset-md-6" style="margin:0 0 0 auto; float:none;">
                        <div class="rangepicker" id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                          <i class="fa fa-calendar"></i>&nbsp;
                          <span></span> <i class="fa fa-caret-down"></i>
                        </div>
                        <input type = "hidden" name="start_at">
                        <input type = "hidden" name="end_at">
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class = "col-md-6 offset-md-3" style="margin:0 auto; float:none;">
                        <div class="row">
                          <div class = "col-md-6">
                            <div class="form-group">
                              <div class = "radio-price-type col-md-10 offset-md-1">
                                <label>
                                  <input type="radio" name="project-type" id="hourly-type" value="hourly">
                                  시간과제
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class = "col-md-6">
                            <div class="form-group">
                              <div class="input-group col-md-10 offset-md-1">
                                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                <input type="text" id="hourly-price" class="form-control" name="hourly-price" placeholder = "시간당 액수" style="display:inline;">
                              </div>  
                            </div>
                          </div>
                        </div>
                        <br>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3" style="margin:0 0 0 50%; float:none;">
                        <div class="form-group">
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-hourglass-o"></i></span>
                            <input type = "text" class="form-control" id = "hours-per-week" name="hours-per-week" placeholder="주간 시간수"/>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <br><hr><br>
                <div class = "client-form-group">
                  <h3 style = "text-align:center;">대방정보</h3><br>
                  <div class = "row">
                    <div class = "col-md-6 offset-md-3" style="margin:0 auto; float:none;">
                      <div class = "form-group">
                        <div class = "radio-company-type">
                          <div class = "row">
                            <div class = "col-md-6">
                              <div class = "col-md-10 offset-md-1">
                                <label>
                                  <input type="radio" name="client-company" id="fixed-company" value="fixed" checked>
                                  고정대방
                                </label>
                              </div>
                            </div>
                            <div class = "col-md-6">
                              <div class = "col-md-10 offset-md-1">
                                <label>
                                  <input type="radio" name="client-company" id="site-company" value="site">
                                  싸이트대방
                                </label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class = "form-group">
                        <div class="input-group">
                          <span class="input-group-addon">@</i></span>
                          <input type="text" id="client-name" name="client-name" class="form-control" placeholder="대방이름">
                        </div>
                        <h5 style="color:#b4b4b4!important;">대방종류에 따라 고정대방인 경우 대방이름 싸이트대방인 경우 싸이트 이름을 씁니다.</h5>
                      </div>
                    </div>
                  </div>
                </div>
                <div class = "button-group" style = "text-align:center">
                  <button type = "submit" class = "btn btn-primary">등  록</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>  
  </div>
  <script>
    $('#create-project').submit(function(e){
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
            location.reload();
          }
          else
          {
            $('.has-error').removeClass('has-error');
            $('.text-danger').remove();
            $.each(response.messages,function(key,value){
              if(value.length > 0){
                var element = $('#' + key);
                element.closest('div.form-group')
                .addClass('has-error')
                .find('.text-danger').remove();
                element.closest('div.input-group').after(value);
              } 
            });
          }
        }
      });
    });
  </script>