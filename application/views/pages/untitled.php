<span class = "text"><?php echo $project['project_title'];?></span>
<?php
$label_color = null;
if($project['progress_rate'] <25){
  $label_color = "bg-red";
}
elseif($project['progress_rate'] < 50){
  $label_color = "bg-yellow";
}
elseif($project['progress_rate'] < 75){
  $label_color = "bg-green";
}
elseif($project['progress_rate' < 100]){
  $label_color = "bg-blue";
}
echo "<span class = 'badge ".$label_color."'>".$project['progress_rate']."%</span>";
?>
<div class="tools">
	<a href = "<?php echo site_url('/project/edit/'.$project['id']);?>">
		<i class="fa fa-edit"></i>
	</a>
	<a href = "<?php echo site_url('/project/delete/'.$project['id']);?>">
		<i class="fa fa-trash-o"></i>
	</a>
</div>