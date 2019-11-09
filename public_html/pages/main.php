<?php ?>
<div class="row">
	<div class="col">
		<div class="">
			<a href="<?=SITE_URL;?>"><h1>School Board</h1></a>
		</div>
	</div>	
</div>
<div class="row">
	<div class="col-lg-3 col-md-4 col-sm-12 mt-2">
		<div class="list-group">
			<a href="<?=SITE_URL;?>/" class="py-2 list-group-item list-group-item-action <?php if($p == "") echo "active";?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
			<a href="<?=SITE_URL;?>/students" class="py-2 list-group-item list-group-item-action <?php if($p == "students") echo "active";?>"><i class="fas fa-graduation-cap"></i> Students</a>
			<a href="<?=SITE_URL;?>/boards" class="py-2 list-group-item list-group-item-action  <?php if($p == "boards") echo "active";?>"><i class="fas fa-users"></i> Boards</a>
			<a href="<?=SITE_URL;?>/grades" class="py-2 list-group-item list-group-item-action <?php if($p == "grades") echo "active";?>"><i class="fas fa-cogs"></i> Grades</a>
			<a href="<?=SITE_URL;?>/studentgrades" class="py-2 list-group-item list-group-item-action <?php if($p == "grades") echo "studentgrades";?>"><i class="fas fa-sign-out-alt"></i> Student Grades</a>			
		</div>
	
	</div>
	
	<div class="col-lg-9 col-md-8 col-sm-12 mt-2 rounded bg-white">
	<?php 
		if ($p == ""){
			include("dash.php");
		} else if ($p == "students"){
			include("students.php");
		} else if ($p == "student" AND $arg2 != ""){
			include("student.php");
		} else if ($p == "boards"){
			include("boards.php");
		} else if ($p == "grades"){
			include("grades.php");
		} else if ($p == "studentgrades"){
			include("studentsgrades.php");
		} else {
			include("error.php");
		}
	?>
		
	</div>
	
	
</div>