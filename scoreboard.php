<?php
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
require_once './language/language.php';
include_once 'includes/header.php';

$tableIndex = filter_input(INPUT_GET, 'table', FILTER_SANITIZE_URL);
if (isset($tableIndex)) {
	$_SESSION['table_index'] = $tableIndex;
}
?>
<main>
	<div class="container-fluid">
		<h1 class="mt-4"><?php echo $lang['nav-scoreboard']; ?></h1>
		<ol class="breadcrumb mb-4">
			<li class="breadcrumb-item"><a href="index.php"><?php echo $lang['nav-dashboard']; ?></a></li>
			<li class="breadcrumb-item active"><?php echo $lang['nav-scoreboard']; ?></li>
		</ol>
		<?php include('./includes/flash_messages.php') ?>
		<div class="card mb-4">
			<div class="card-header">
				<div class="row">
					<div class="col"><i class="fas fa-table mr-1"></i>
						<?php echo $lang['datatable']; ?>
						<select id="dpTable" class="form-select" aria-label="Default select example">
							<option value=""><?php echo $lang['option-select']; ?></option>
							<?php
							foreach ($table_scoreboards as $key=>$table) {
								$selected = $_SESSION['table_index'] == $key ? 'selected' : '';
								echo '<option value="'.$key.'" '.$selected.'>'.$table['name'].'</option>';	
							}
							?>
						</select>
					</div>
					<div class="col">
						<?php if ($_SESSION['admin_type'] == 'super'){ ?>
						<div class="page-action-links text-right">
							<a href="scoreboard_add.php?operation=create">
								<button class="btn btn-success btn-sm"><span class="fa fa-plus fa-fw"></span> <?php echo $lang['button-add-new']; ?> </button>
							</a>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="card-body">
				<?php if ($_SESSION['admin_type'] == 'super'){ ?>
				<div class="row">
					<div class="col">				
						<form class="form form-inline" action="">
							 <div class="form-group mb-2">
								<select name="update_order"  class="form-control form-control-sm" id="update_order">
									<option value="remove"><?php echo $lang['option-remove']; ?></option>
									<option value="filter"><?php echo $lang['option-spam']; ?></option>
								</select>
							  </div>
							<a href="" class="btn btn-primary btn-sm ml-3 mb-2" data-toggle="modal" data-target="#update-status"><?php echo $lang['button-apply-update']; ?> </a>
						</form>
					</div>
				</div>
				<hr>
				<?php } ?>

				<div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						 <thead>
							<tr>
								<th><input id="check_all_top" name="check_all" class="check_all checkbox" value="" type="checkbox" /></th>
								<th class="header"><?php echo $lang['scoreboard-table-id']; ?></th>
								<th><?php echo $lang['scoreboard-table-name']; ?></th>
								<th><?php echo $lang['scoreboard-table-member']; ?></th>
								<th><?php echo $lang['scoreboard-table-category']; ?></th>
								<th><?php echo $lang['scoreboard-table-score']; ?></th>
								<th><?php echo $lang['scoreboard-table-filters']; ?></th>
								<th><?php echo $lang['scoreboard-table-date']; ?></th>
								<?php if ($_SESSION['admin_type'] == 'super'){ ?>
								<th class="notexport actionColumn"><?php echo $lang['scoreboard-table-action']; ?></th>
								<?php } ?>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th><input id="check_all_top" name="check_all" class="check_all checkbox" value="" type="checkbox" /></th>
								<th class="header"><?php echo $lang['scoreboard-table-id']; ?></th>
								<th><?php echo $lang['scoreboard-table-name']; ?></th>
								<th><?php echo $lang['scoreboard-table-member']; ?></th>
								<th><?php echo $lang['scoreboard-table-category']; ?></th>
								<th><?php echo $lang['scoreboard-table-score']; ?></th>
								<th><?php echo $lang['scoreboard-table-filters']; ?></th>
								<th><?php echo $lang['scoreboard-table-date']; ?></th>
								<?php if ($_SESSION['admin_type'] == 'super'){ ?>
								<th><?php echo $lang['scoreboard-table-action']; ?></th>
								<?php } ?>
							</tr>
						</tfoot>
					</table>
				</div>

				<?php if ($_SESSION['admin_type'] == 'super'){ ?>
				<hr>
				<div class="row">
					<div class="col">				
						<form class="form form-inline" action="">
							<a href="" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#clear-records"><span class="fa fa-fw fa-trash-alt"></span> <?php echo $lang['button-clear']; ?></a>
						</form>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</main>

<!-- Update Status Modal-->
<?php if ($_SESSION['admin_type'] == 'super'){ ?>
<div class="modal fade" id="update-status" role="dialog">
	<div class="modal-dialog modal-dialog-centered">
	  <form action="scoreboard_update_batch.php" method="POST">
	  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <h4 class="modal-title"><?php echo $lang['modal-update-title']; ?></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div id="update-status-confirm">
				<div class="modal-body">
					<input type="hidden" name="batch_id" id = "batch_id" value="">
					<input type="hidden" name="update_status" id = "update_status" value="">
					<p><?php echo $lang['modal-update-desc']; ?></p>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary pull-left"><?php echo $lang['button-confirm']; ?></button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $lang['button-cancel']; ?></button>
				</div>
			 </div>

			 <div id="update-status-error">
				<div class="modal-body">
					<p><?php echo $lang['modal-update-score-checkbox']; ?></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $lang['button-ok']; ?></button>
				</div>
			 </div>
		  </div>
	  </form>
	</div>
</div>

<!-- Clear Status Modal-->
<div class="modal fade" id="clear-records" role="dialog">
	<div class="modal-dialog modal-dialog-centered">
	  <form action="scoreboard_clear.php" method="POST">
	  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <h4 class="modal-title"><?php echo $lang['modal-clear-title']; ?></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<input type="hidden" name="update_status" id = "update_status" value="clear">
				<p><?php echo $lang['modal-clear-desc']; ?></p>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary pull-left"><?php echo $lang['button-confirm']; ?></button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $lang['button-cancel']; ?></button>
			</div>
		  </div>
	  </form>
	</div>
</div>
<?php } ?>
<!--Main container end-->

<?php include_once './includes/footer.php'; ?>

