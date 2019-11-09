<?php 
$izmena = $izmenapass = 0;
if (isset($_POST['izmena'])){
	$uIme = $oDb->filter($_POST['firstname']);
	$uPrezime = $oDb->filter($_POST['lastname']);	
	$izmenaEmail = $oDb->filter($uEmail);
	$uPhone = $oDb->filter($_POST['phone']);
	
	$update = array( 
		'ime' => $uIme, 
		'prezime' => $uPrezime,
		'telefon' => $uPhone
	);
    $update_where = array( 
		'email' => $izmenaEmail 
	);
    $izmena = $oDb->update( 'user', $update, $update_where, 1 );
	if($izmena){
		$izmena = 1;
	} else {
		$izmena = 2;
	}
	
}
if (isset($_POST['izmenapass'])){
	$newPass = $oDb->filter($_POST['lozinka']);
	$checkPass = $oDb->filter($_POST['lozinka2']);

	if ($newPass === $checkPass){
		$userEmail = $oDb->filter($uEmail);
		$mdPass = md5($newPass);	
	
		$update = array( 
			'password' => $mdPass
		);
		$update_where = array( 
			'email' => $userEmail 
		);
		$izmenaPass = $oDb->update( 'user', $update, $update_where, 1 );
		if($izmenaPass){
			$to = $uEmail;
            $subject = "Uspesno ste promenili lozinku";
            $headers = "From: [LVT Klub] <info@leadervisionteam.com> \r\n";
            $headers .= "Reply-To: info@petsq.me\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=utf-8\r\n";
			$headers .= "Bcc: aleksandar.klickovic@gmail.com\r\n";
            $message = '<html><body>';            
            $message .= '<h2>Pozdrav, uspešno ste promenili lozinku u LVT Klubu!</h2>';
            $message .= '<p><strong>Vaši detalji za logovanje</strong></p>';
            $message .= '<p>Email: ' . $uEmail . '<br/>';
            $message .= 'Lozinka: ' . $newPass . '</p>';
            $message .= '<p>Ulogujte se ovde : ' . SITE_URL . '/members</p>';
            $message .= '<p>Srdačno,<br/>Leader Vision Tim</p>';
            $message .= '<p style="color:#ccc"><small>--<br/>
			This email and any files transmitted with it are confidential and intended solely for the use of the individual or entity to whom they are addressed. If you have received this email in error please notify the system manager. Please note that any views or opinions presented in this email are solely those of the author and do not necessarily represent those of the company. Finally, the recipient should check this email and any attachments for the presence of viruses. The company accepts no liability for any damage caused by any virus transmitted by this email.<small></p>';
			$message .= '</body></html>';

            mail($to, $subject, $message, $headers);
			$izmenapass = 1;
		} else {
			$izmenapass = 2;
		}
	} else {
		$izmenapass = 3;
	}
}
?>

<h4>Korisnička podešavanja</h4>
<p class="small">Popunite polja, promenite lozinku (ukoliko želite) i aktiviraćete sve funkcionalnosti Vaše kancelarije</p>
<hr/>
<div class="row">
	<div class="col-lg-6 col-12 mb-3">
		<form method="POST" action="<?=SITE_URL;?>/members/settings">
			<div class="form-group">
				<p class="small text-left">Moj pristupni kod: <strong><?=$uAccessCode;?></strong>
				<?php if($izmena == 1){ echo "<span class='float-right badge badge-success'><i class='fas fa-check-square'></i> Uspešno</span>";} else if($izmena == 2) {echo "<span class='float-right badge badge-danger'><i class='fas fa-times-circle'></i> Neuspešno</span>" ;}else if($izmena == 3) {echo "<span class='float-right badge badge-danger'><i class='fas fa-times-circle'></i> Lozinke se ne poklapaju</span>" ;}?></p>
			</div>
		  <div class="form-group">
			<input type="email" class="form-control form-control-sm" style="text-align:center;" name="emailaddress" id="emailaddress" aria-describedby="emailHelp" placeholder="<?=$uEmail;?>" disabled>
			
		  </div>
		  <div class="form-group">
			<div class="row">
				<div class="col">
					<input type="text" class="form-control form-control-sm" name="firstname" id="firstname" aria-describedby="fnHelp" placeholder="Vaše Ime" value="<?=$uIme;?>" required>
				</div>
				<div class="col">
					<input type="text" class="form-control form-control-sm" name="lastname" id="lastname" aria-describedby="fnHelp" placeholder="Vaše Prezime" value="<?=$uPrezime;?>" required>
				</div>
			
			</div>
		  </div>
		  <div class="form-group">
			<div class="row">
				<div class="col">				
					
					<input type="text" class="form-control form-control-sm" name="phone" id="phone" placeholder="Telefon" value="<?=$uPhone;?>">
				</div>
				<div class="col">
					<button type="submit" name="izmena" id="izmena" class="btn btn-block btn-primary btn-sm">Sačuvaj Profil</button>
				</div>
			</div>
		  </div>
		</form>
	</div>
	<div class="col-lg-6 col-12 mb-3">
		<form method="POST" action="<?=SITE_URL;?>/members/settings">
			<div class="form-group">
				<p class="small text-left">Promena Lozinke:
				<?php if($izmenapass == 1){ echo "<span class='float-right badge badge-success'><i class='fas fa-check-square'></i> Uspešno</span>";} else if($izmenapass == 2) {echo "<span class='float-right badge badge-danger'><i class='fas fa-times-circle'></i> Neuspešno</span>" ;}?></p>
			</div>
		  <div class="form-group">			
					<input type="password" class="form-control form-control-sm" name="lozinka" id="lozinka" aria-describedby="fnHelp" placeholder="Nova Lozinka" required>
		  </div>
		  <div class="form-group">
					<input type="password" class="form-control form-control-sm" name="lozinka2" id="lozinka2" aria-describedby="fnHelp" placeholder="Ponovi Lozinku" required>
		  </div>
		  <div class="form-group">
			<button type="submit" name="izmenapass" id="izmenapass" class="btn btn-success btn-sm float-right">Promeni Lozinku</button>
		  </div>
		</form>
	</div>
</div>

