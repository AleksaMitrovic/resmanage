
<div class = "body-content">
  <br><br><br><br>
  <div class = "c-layout-page">
    <div class = "c-layout-breadcrumbs-1 c-fonts-bold">
      <div class = "container">
        <div class = "c-page-title c-pull-left">
          <h2 class = "c-font-30">일보종합</h2>
          <h4 class = "c-font-dark c-font-slim">
            개발성원들의 일보를 종합합니다.
          </h4>
        </div>
      </div>
    </div>
    <div class = "c-content-box c-size-md">
      <div class="container">
        <span>일보날자</span>
        <input type = "text" class="form-control" name="report_date_picker" value="<?php echo $today_time;?>" style = "width:20%;">
        <br>
        <?php if(sizeof($repinfos) > 0):?>
        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">일보종합</h3>
          </div>
          <div class="box-body">
            <?php foreach($repinfos as $repinfo):?>
            <div class="report" style ="padding:40 40;">
              <div class="report-owner" style="float:left; width:150px;">
                <?php
                  $user_image = "account.jpeg";
                  if($repinfo['user_image'])
                    $user_image = $repinfo['user_image'];
                ?>
                <img class="img-circle img-bordered-sm" src="../../assets/img/account/<?php echo $user_image;?>" style="width:100%;" alt="userimage">
                <h3 style="text-align:center;"><?php echo $repinfo['username'];?></h3>
              </div>
                <!--
                <span class="username">
                  <a>Ninja</a>
                </span>
                <span class="description">abcdefg</span>
                -->
              <div class="report-body" style="margin-left:150; padding-left:40;">
                <h3 class="c-font-bold c-font-20 panel-title" style="padding:7 0;">사업내용</h3>
                <p><?php echo $repinfo['businessrep'];?></p>
                <h3 class="c-font-bold c-font-20 panel-title" style="padding:7 0;">제기할 내용</h3>
                <p><?php echo $repinfo['suggestion'];?></p>
                <?php if(sizeof($repinfo['prologs']) > 0):?>
                  <h3 class = "c-font-bold c-font-20 panel-title" style="padding:7 0;">
                    프로젝트별 진행정형
                  </h3>
                  <div class = "panel-body">
                    <?php foreach($repinfo['prologs'] as $prologs):?>
                      <?if($prologs['bus_at_pro']):?>
                      <div class = "prolog_heading">
                        <span class = "c-font-bold" style="float:left; margin-right:15;"><?php echo "--- ".$prologs['project']['project_title'];?></span>
                        <div class = "rate_log" style = "margin:10 0;">

                          <?php 
                            $prev_rate = $prologs['prev_rate'];
                            $current_rate = $prologs['pro_rate_change'];
                            if($prologs['project']['project_type'] == HOURLY_PRICE)
                            {
                              $prev_rate = (int)(($prev_rate * 100) / $prologs['project']['hour_week']);
                              $current_rate = (int)(($current_rate * 100) / $prologs['project']['hour_week']);
                            }
                          ?>
                          <p style = "margin:15 0"><?php echo $prev_rate."% - ".$current_rate."%";?></p>
                        </div>
                      </div>
                      <div class = "prolog_body" style="padding-left:19px;">
                        <div class = "project_log">
                          <?php echo $prologs['bus_at_pro'];?>
                        </div>
                      </div>
                      <hr>
                      <? endif;?>
                    <? endforeach;?>
                  </div>   
                <? endif;?>
              </div>
            </div>
            <? endforeach;?>
          </div>
        </div>
        <? endif;?>
        <?php if(sizeof($repinfos) == 0):?>
          <p>종합된 일보가 없습니다.</p>
        <? endif;?>
      </div>
    </div>
  </div>