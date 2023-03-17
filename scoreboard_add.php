<?php
session_start();
require_once './config/config.php';
require_once './language/language.php';
require_once './includes/auth_validate.php';

if($_SESSION['admin_type']!='super'){
	$_SESSION['failure'] = $lang['permission-denied-log'];
	header('location: scoreboard.php');
	exit;
}

//serve POST method, After successful insert, redirect to customers.php page.
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
    $data_to_store = filter_input_array(INPUT_POST);
    $last_id = $db->insert ($table_scoreboards[$_SESSION['table_index']]['table'], $data_to_store);
    
    if($last_id)
    {
    	$_SESSION['success'] = $lang['scoreboard-log-add-success'];
    	header('location: scoreboard.php');
    	exit();
    }  
}

//We are using same form for adding and editing. This is a create form so declare $edit = false.
$edit = false;

require_once 'includes/header.php'; 
?>
<main>
	<div class="container-fluid">
		<h1 class="mt-4"><?php echo $lang['scoreboard-add']; ?></h1>
		<ol class="breadcrumb mb-4">
			<li class="breadcrumb-item"><a href="index.php"><?php echo $lang['nav-dashboard']; ?></a></li>
			<li class="breadcrumb-item"><a href="scoreboard.php"><?php echo $lang['nav-scoreboard']; ?></a></li>
			<li class="breadcrumb-item active"><?php echo $lang['scoreboard-add']; ?></li>
		</ol>
		
		<div class="card mb-4">
			<div class="card-header">
				<span class="fa fa-user-plus fa-fw"></span> <?php echo $lang['scoreboard-details']; ?>
			</div>
			<div class="card-body">
				<form class="form" action="" method="post"  id="scoreboard_form" enctype="multipart/form-data">
				   <?php  include_once('./includes/forms/scoreboard_form.php'); ?>
				</form>
			</div>
		</div>
	</div>
</main>

<?php include_once 'includes/footer.php'; ?>