<?php
session_start();
require_once './config/config.php';
require_once './language/language.php';
require_once 'includes/auth_validate.php';

if($_SESSION['admin_type']!='super'){
	$_SESSION['failure'] = $lang['permission-denied-log'];
	header('location: filter_scores.php');
	exit;
}

// Sanitize if you want
$score_id = filter_input(INPUT_GET, 'score_id', FILTER_VALIDATE_INT);
$operation = filter_input(INPUT_GET, 'operation',FILTER_SANITIZE_STRING); 
($operation == 'edit') ? $edit = true : $edit = false;
//Handle update request 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $score_id = filter_input(INPUT_GET, 'score_id', FILTER_VALIDATE_INT);

    $data_to_update = filter_input_array(INPUT_POST);
    
    $db->where('id',$score_id);
	$stat = $db->update($table_filter_scores, $data_to_update);
	$db->where('id',$score_id);
	$details = $db->getOne($table_filter_scores);
	
    if($stat)
    {
        $_SESSION['success'] = str_replace("{s}",$details['game'],$lang['filter-scores-log-update-success']);
        header('location: filter_scores.php');
        exit();
    }
}



if($edit)
{
    $db->where('id', $score_id);
    $filterScores = $db->getOne($table_filter_scores);

}

require_once 'includes/header.php';
?>

<main>
	<div class="container-fluid">
		<h1 class="mt-4"><?php echo $lang['filter-scores-edit']; ?></h1>
		<ol class="breadcrumb mb-4">
			<li class="breadcrumb-item"><a href="index.php"><?php echo $lang['nav-dashboard']; ?></a></li>
			<li class="breadcrumb-item"><a href="filter_scores.php"><?php echo $lang['nav-filter-scores']; ?></a></li>
			<li class="breadcrumb-item active"><?php echo $lang['filter-scores-edit']; ?></li>
		</ol>
		
		<div class="card mb-4">
			<div class="card-header">
				<span class="fa fa-user-edit fa-fw"></span> <?php echo $lang['filter-scores-details']; ?>
			</div>
			<div class="card-body">
				 <?php
				include('./includes/flash_messages.php')
				?>
				<form class="" action="" method="post" enctype="multipart/form-data" id="filter_scores_form">
					<?php  include_once('./includes/forms/filter_scores_form.php'); ?>
				</form>
			</div>
		</div>
	</div>
</main>

<?php include_once 'includes/footer.php'; ?>