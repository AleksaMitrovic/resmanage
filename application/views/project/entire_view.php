
<div class = "body-content">
  <br><br><br><br>
  <div class = "c-layout-page">
    <div class = "c-layout-breadcrumbs-1 c-fonts-bold">
      <div class = "container">
        <div class = "c-page-title c-pull-left">
          <h2 class = "c-font-30">프로젝트종합</h2>
          <h4 class = "c-font-dark c-font-slim">
            완성된 프로젝트들을 종합합니다.
          </h4>
        </div>
      </div>
    </div>
    <div class = "c-content-box c-size-md">
      <div class="container">
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
	                <th>담당자</th>
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
	                  <td>
	                  	<a style="padding:0px 15px;display:inline;">
						   	<img class="img-bordered-sm" src="<?php echo base_url();?>assets/img/account/<?php echo $project_owner_images[$project['id']];?>"
							 style="width:50px;height:50px;border-radius:50%;">                  
						</a>	
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

      </div>
    </div>
  </div>