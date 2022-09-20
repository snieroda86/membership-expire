<?php 
date_default_timezone_set('Europe/Warsaw');
if(isset($_GET['choosen_plan']) && !empty($_GET['choosen_plan']) ){
	$plan = $_GET['choosen_plan'];
	switch ($plan) {
		case 'free':
				$expire_date = null;
			break;
		case 'silver':
				$expire_date = date('Y-m-d h:i:s', strtotime(" +1 months"));
			break;
		case 'gold':
				$expire_date = date('Y-m-d h:i:s', strtotime(" +3 months"));
			break;
		
	}

	require_once('db.php');
	require_once('app/controllers/User.php');

	if(isset($_POST['add_user'])){
		$name = $_POST['name'];
		$surname = $_POST['surname'];
		$login = $_POST['login'];
		$password = $_POST['password'];
		$confirm_password = $_POST['confirm_password'];
		$email = $_POST['email'];
		$plan = $_GET['choosen_plan'];

		$user = new User;
		$errors = array();

		if($user->verify_email($email) > 0){
			$errors['email_exists'] = 'Podany email istnieje juz w bazie';
		}else{

			// Password confirm
			if($user->verify_password( $password , $confirm_password)){
				$password = password_hash($password, PASSWORD_DEFAULT);
				 if(filter_var($email, FILTER_VALIDATE_EMAIL)){
				 	if( $user->verify_login($login) > 0){
				 		$errors['login_verify'] = 'Podany login już istnieje';
				 			
				 	}else{
				 		$user->store($name , $surname , $login , $password , $email , $plan , $expire_date);
				 	}
				 	
				 }else{
				 	$errors['email_verify'] = 'Niepoprawny format adresu email';
				 }   	
			}else{
				$errors['password_confirm'] = 'Podane hasła różnią się';				
			}
		
		}

		
	}
	

}else{
	header('Location: index.php');
}

 ?>


<?php include('includes/header.php'); ?>

<div class="container pt-5 pb-5">
	<div class="row">

		<!-- Errors -->
		<div class="col-md-8 m-auto mb-3">
			<?php 
			if(!empty($errors)){ 
		        echo '<h6 style="color: red">Błąd!</h6>';
		        foreach($errors as $errorMessage){ ?>
		            <div class="alert alert-danger">
		            	<?php echo $errorMessage; ?>
		            </div>
		        <?php }
		    } 
			?>
		</div>
		<!-- End errors -->
		<div class="col-md-8 m-auto">
			<form method="post">
				<!-- Imię -->
			  <div class="form-group">
			    <label >Imię</label>
			    <input type="text" name="name" class="form-control" required>
			  </div>
			  <!-- Nazwisko -->
			  <div class="form-group">
			    <label>Nazwisko</label>
			    <input type="text" name="surname" class="form-control" required>
			  </div>
			  <!-- Login -->
			  <div class="form-group">
			    <label>Login</label>
			    <input type="text" name="login" class="form-control" required>
			  </div>

			  <!-- Email -->
			  <div class="form-group">
			    <label>Adres email</label>
			    <input type="email" name="email" class="form-control" required>
			  </div>

			  <!-- Hasło -->
			  <div class="form-group">
			    <label>Hasło</label>
			    <input type="password" name="password" class="form-control" >
			  </div>

			  <!-- Hasło -->
			  <div class="form-group">
			    <label>Powtórz hasło</label>
			    <input type="password" name="confirm_password" class="form-control" >
			  </div>

			  <button type="submit" name="add_user" class="btn btn-primary">Założ konto</button>
			</form>
		</div>
	</div>
</div>

<div class="container">
	<?php include('includes/footer.php'); ?>	
</div>

