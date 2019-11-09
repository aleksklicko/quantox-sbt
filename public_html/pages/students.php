<?php ?>
<h5 class="text-right">Students List</h5>
<hr/>
		<table class="table table-sm table-striped small">
		  <thead>
			<tr>
			  <th scope="col" width="5%">#</th>
			  <th scope="col">Full Name</th>
			  <th scope="col">Board</th>
			  <th scope="col">Bio</th>
			  <th scope="col" width="15%">Options</th>
			</tr>
		  </thead>
		  <tbody>
		  
			<?php 
			$sql = "SELECT * FROM students WHERE id > 0";
			$students = $oDb->get_results($sql);
			foreach ($students as $student){
				$id = $student['id'];
				$firstName = $student['student_fname'];
				$lastName = $student['student_lname'];
				$studentBio = $student['student_bio'];
				$studentImg = $student['student_img'];
				$studentBoard = $student['student_board'];
				list($studentBoardName) = $oDb->get_row("SELECT board_name FROM boards WHERE id = $studentBoard");
				$studentBioExcerpt = (strlen($studentBio) > 80) ? substr($studentBio,0,80).'...' : $studentBio;
			?>
			<tr>
			  <th scope="row" class="text-right"><?=$id;?>.</th>
			  <td class="text-left"><strong><?=ucfirst($firstName).' '.ucfirst($lastName);?></strong></td>
			  <td class="text-left"><?=$studentBoardName;?></a></td>
			  <td class="text-left"><?=$studentBioExcerpt;?></td>
			  <td><a href="<?=SITE_URL?>/student/<?=$id;?>" class="btn btn-sm btn-primary btn-block">View</a></td>
			</tr>
			<?php }?>
		  </tbody>
		</table>