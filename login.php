<?php 


// Check if user alreday logghed in
if(isset($_SESSION['member'])){
	header('Location: account.php');
	exit();
}


$errors = [];
if(isset($_POST['login_user'])){
	$login = $_POST['login'];
	$password = $_POST['password'];

	require_once('db.php');
	require_once('app/controllers/User.php');

	$user = new User();
	
	if(!empty($user->getUserByLogin($login))){
		$user = $user->getUserByLogin($login);
		if(password_verify( $password, $user['password'] )){
			$_SESSION['member'] = $user['name'];
			$_SESSION['user_id'] = $user['id'];

			header('Location: account.php');
			exit();
		}else{
			$errors['wrong_password'] = 'Podane hasło jest niepoprawne'; 
		}
	}else{
		$errors['wrong_login'] = 'Podany login nie istnieje'; 
	}

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
			  <!-- Login -->
			  <div class="form-group">
			    <label>Login</label>
			    <input type="text" name="login" class="form-control" required>
			  </div>

			  <!-- Hasło -->
			  <div class="form-group">
			    <label>Hasło</label>
			    <input type="password" name="password" class="form-control" >
			  </div>

			  <button type="submit" name="login_user" class="btn btn-primary">Zaloguj się</button>
			</form>
		</div>
	</div>
</div>

<div class="container">
	<?php include('includes/footer.php'); ?>	
</div>
