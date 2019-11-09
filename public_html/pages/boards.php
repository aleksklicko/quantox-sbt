<?php ?>
<h5 class="text-right">Boards List</h5>
<hr/>
		<table class="table table-sm table-striped small">
		  <thead>
			<tr>
			  <th scope="col" width="5%">#</th>
			  <th scope="col">Board Name</th>
			  <th scope="col">Grades List</th>
			  <th scope="col" width="8%">Options</th>
			</tr>
		  </thead>
		  <tbody>
		  
			<?php 
			$sql = "SELECT * FROM boards WHERE id > 0";
			$boards = $oDb->get_results($sql);
			foreach ($boards as $board){
				$id = $board['id'];
				$boardName = $board['board_name'];
			?>
			<tr>
			  <th scope="row" class="text-right"><?=$id;?>.</th>
			  <td class="text-left"><?=$boardName;?></td>
			  <td class="text-left">
				<?php 
				  $sql = "SELECT * FROM grades WHERE grade_board = $id";
				  $boardGrades = $oDb->get_results($sql);
				  foreach ($boardGrades as $boardGrade){
					  echo $boardGrade['grade_name'].", ";
				  }
				?>
			  </td>
			  <td><a href="<?=SITE_URL?>/grades" class="btn btn-sm btn-primary btn-block">View</a></td>
			</tr>
			<?php }?>
		  </tbody>
		</table>