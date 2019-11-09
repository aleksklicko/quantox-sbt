<?php ?>
<h5 class="text-right">Grades List</h5>
<hr/>
<div class="row mb-2">
	<?php
	$sql = "SELECT * FROM boards WHERE id > 0";
	$boards = $oDb->get_results($sql);
	foreach ($boards as $board){
		$id = $board['id'];
		$boardName = $board['board_name'];
	?>
		<div class="col-lg-6 col-sm-12 mb-2">
			<div class="card">
			  <div class="card-header">
				<strong><?=$boardName;?></strong>
			  </div>
			  <ul class="list-group list-group-flush">
			  <?php 
				  $sql = "SELECT * FROM grades WHERE grade_board = $id";
				  $boardGrades = $oDb->get_results($sql);
				  foreach ($boardGrades as $boardGrade){
					  ?>					  
					<li class="list-group-item"><?=$boardGrade['id'].". ".$boardGrade['grade_name'];?></li>
					 <?php
				  }			  
			  ?>
			</div>
		</div>
	<?php
	} ?>
</div>