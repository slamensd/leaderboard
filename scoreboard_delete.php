<?php 
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
require_once './language/language.php';
$del_id = filter_input(INPUT_POST, 'del_id');
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') 
{

	if($_SESSION['admin_type']!='super'){
		$_SESSION['failure'] = $lang['permission-denied-log'];
    	header('location: scoreboard.php');
        exit;

	}
    $score_id = $del_id;
    $db->where('id', $score_id);
	$details = $db->getOne($table_scoreboards[$_SESSION['table_index']]['table']);
	$db->where('id', $score_id);
    $status = $db->delete($table_scoreboards[$_SESSION['table_index']]['table']);
    
    if ($status) 
    {
        $_SESSION['info'] = str_replace("{s}",$details['email'],$lang['scoreboard-log-delete-success']);
        header('location: scoreboard.php');
        exit;
    }
    else
    {
    	$_SESSION['failure'] = $lang['scoreboard-log-delete-fail'];
    	header('location: scoreboard.php');
        exit;

    }
    
}