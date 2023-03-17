<?php
session_start();
require_once './config/config.php';
require_once './language/language.php';

//If User has already logged in, redirect to dashboard page.
if (isset($_SESSION['user_logged_in'.$session_app]) && $_SESSION['user_logged_in'.$session_app] === TRUE) {
    header('Location:index.php');
}

include_once 'includes/header.php';
?>

<div id="layoutAuthentication">
	<div id="layoutAuthentication_content">
		<main>
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-5">
						<div class="card shadow-lg border-0 rounded-lg mt-5">
							<div class="card-header"><h3 class="text-center font-weight-light my-4"><?php echo $lang['login-title']; ?></h3></div>
							<div class="card-body">
								<form class="form loginform" method="POST" action="authenticate.php">
									<div class="form-group"><label class="small mb-1" for="inputEmailAddress"><?php echo $lang['login-username']; ?></label><input class="form-control py-4" name="username" type="text" placeholder="<?php echo $lang['login-username-placeholder']; ?>" /></div>
									<div class="form-group"><label class="small mb-1" for="inputPassword"><?php echo $lang['login-password']; ?></label><input class="form-control py-4" name="passwd" type="password" placeholder="<?php echo $lang['login-password-placeholder']; ?>" /></div>
									<div class="form-group">
										<div class="custom-control custom-checkbox"><input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" /><label class="custom-control-label" for="rememberPasswordCheck"><?php echo $lang['login-remember']; ?></label></div>
									</div>
									<?php
									if(isset($_SESSION['login_failure'])){ ?>
									<div class="alert alert-danger alert-dismissable fade show">
										<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
										<?php echo $_SESSION['login_failure']; unset($_SESSION['login_failure']);?>
									</div>
									<?php } ?>
									<button type="submit" class="btn btn-success loginField" ><?php echo $lang['button-login']; ?></button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
	</div>
	
	<div id="layoutAuthentication_footer">
		<footer class="py-4 bg-light mt-auto">
			<div class="container-fluid">
				<div class="d-flex align-items-center justify-content-between small">
					<div class="text-muted"><?php echo $lang['footer-mrs']; ?></div>
					<div>
						<?php echo $lang['footer-link']; ?>
					</div>
				</div>
			</div>
		</footer>
	</div>
</div>
<?php include_once 'includes/footer.php'; ?>