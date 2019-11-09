<?php 
if (is_numeric($arg2)) {
	
		list($id, $fname, $lname, $bio, $img, $board) = $oDb->get_row("SELECT * FROM students WHERE id = $arg2");
		list($studentBoardName) = $oDb->get_row("SELECT board_name FROM boards WHERE id = $board");
		?>
			
		<h5 class="text-right"><?=ucfirst($fname).' '.ucfirst($lname);?></h5>
		<hr/>
		<h2>Student Profile</h2>
		<img src="<?=SITE_URL;?>/img/<?=$img;?>" class="img-thumbnail float-right" width="200" alt="Student <?=ucfirst($fname).' '.ucfirst($lname);?>"/>
		<p><?=$bio;?></p>
		<p><strong>BOARD:</strong> <?=$studentBoardName;?></p>
		<p><strong>GRADES</strong></p>
		<?php
			$sql = "SELECT * FROM grades WHERE grade_board = $board";
			$grades = $oDb->get_results($sql);
			
			foreach($grades as $grade){
				$gradeId = $grade['id'];
				$gradeName = $grade['grade_name'];
				list($gradeValue) = $oDb->get_row("SELECT grade_value FROM sg_values WHERE student_id = $id AND grade_id = $gradeId");
				echo "<strong>".$gradeName.":</strong> ".$gradeValue."<br/>";
			}
			?>
			<hr/>
			<p><strong>STATUS</strong></p>			
			<?php
			if ($board == 1){
				$sql = "SELECT AVG(grade_value) FROM sg_values WHERE student_id = $id";
				list ($averageGrade) = $oDb->get_row($sql);
				if ($averageGrade >= 7) {
					echo "PASSED (".$averageGrade.")";
				} else {
					echo "FAILED (".$averageGrade.")";
				}
			} else if($board == 2){
				$sql = "SELECT * FROM sg_values WHERE student_id = $id";
				$numRows = $oDb->num_rows($sql);
				if ($numRows > 1) {
					$sql = "SELECT MAX(grade_value) FROM sg_values WHERE student_id = $id";
					list ($maxGrade) = $oDb->get_row($sql);
					if ($maxGrade >= 8) {
						echo "PASSED (".$maxGrade.")";
					} else {
						echo "FAILED (".$maxGrade.")";
					}
				} else if ($numRows == 1){
					list($curentGrade) = $oDb->get_row("SELECT grade_value FROM sg_values WHERE student_id = $id");
					if ($curentGrade >= 8) {
						echo "PASSED (".$curentGrade.")";
					} else {
						echo "FAILED (".$curentGrade.")";
					}
				} else if($numRows < 1){
					echo "FAILED (No Grades)";
				}
				
			}
			
			

  } else {
	  include("error.php");
  }
?>
<hr/>
