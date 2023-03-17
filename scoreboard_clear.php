<?php 
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
require_once './language/language.php';
$update_status = filter_input(INPUT_POST, 'update_status');

if ($update_status && $_SERVER['REQUEST_METHOD'] == 'POST') 
{

	if($_SESSION['admin_type']!='super'){
		$_SESSION['failure'] = $lang['permission-denied-log'];
    	header('location: scoreboard.php');
        exit;
	}
	
	$status_message = '';
	
	if($update_status == 'clear'){
		$status_message = $lang['scoreboard-log-clear-success'];
		$status = $db->query('TRUNCATE TABLE '.$table_scoreboards[$_SESSION['table_index']]['table']);
	}
	
	$_SESSION['info'] = $status_message;
	header('location: scoreboard.php');
	exit;
}