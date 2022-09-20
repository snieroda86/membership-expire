<?php 
require_once('db.php');
require_once('app/controllers/User.php');
if(!isset($_SESSION['member'])){
	header('Location:login.php');
}
$user = new User();

?>

<?php include('includes/header.php'); ?>

<div class="container pt-5 pb-5">
	<div class="row">
		<div class="col-12 d-block">
			<h1>Moje konto</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-8 d-flex align-items-center">
			<p class="mb-0 ">
				Witaj <?php echo $_SESSION['member']; ?>
			</p>
		</div>
		<div class="col-4 text-right">
			<a class="btn btn-secondary mt-2" href="logout.php">Wyloguj się</a>
		</div>

	</div>
	<div class="row">
		<div class="col-12">
			<?php $expiry_date = $user->getExpireDate($_SESSION['user_id']); ?>
			<?php if( strtotime("now") >= strtotime($expiry_date) ): ?>
			  <div class="alert alert-danger">Twoje konto wygasło</div>
			<?php else: ?>
				<p>Twoje konto jest aktywne do <span><?php echo $expiry_date; ?></span> </p>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php include('includes/footer.php'); ?>