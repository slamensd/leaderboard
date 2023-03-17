<?php
session_start();
require_once './config/config.php';
require_once './language/language.php';
require_once 'includes/auth_validate.php';

include_once('includes/header.php');
?>

<main>
	<div class="container-fluid">
		<h1 class="mt-4"><?php echo $lang['nav-dashboard']; ?></h1>
		<ol class="breadcrumb mb-4">
			<li class="breadcrumb-item active"><?php echo $lang['nav-dashboard']; ?></li>
		</ol>
		<div class="row">
			<?php
			foreach ($table_scoreboards as $key=>$table) {
				$db->get($table['table']);
				$numScores = $db->count;
				?>
				<div class="col-xl-3 col-md-6">
					<div class="card bg-primary text-white mb-4">
						<div class="card-body">
							<div class="row">
								<div class="col col-xs-3">
									<i class="fa fa-trophy fa-4x"></i>
								</div>
								<div class="col col-xs-9 text-right">
									<div class="h1"><?php echo $numScores; ?></div>
									<div><?php echo $table['name']; ?></div>
								</div>
							</div>
						</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" href="scoreboard.php?table=<?php echo $key; ?>"><?php echo $lang['button-view-scoreboard']; ?></a>
							<div class="small text-white"><svg class="svg-inline--fa fa-angle-right fa-w-8" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg><!-- <i class="fas fa-angle-right"></i> --></div>
						</div>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</main>

<?php include_once('includes/footer.php'); ?>
