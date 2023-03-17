<?php 
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
require_once './language/language.php';
$score_id = filter_input(INPUT_POST, 'score_id');
if ($score_id && $_SERVER['REQUEST_METHOD'] == 'POST') 
{

	if($_SESSION['admin_type']!='super'){
		$_SESSION['failure'] = $lang['permission-denied-log'];
    	header('location: scoreboard.php');
        exit;

	}
    $score_id = $score_id;
    $db->where('id', $score_id);
	$details = $db->getOne($table_scoreboards[$_SESSION['table_index']]['table']);

    $data_to_store['game'] = $table_scoreboards[$_SESSION['table_index']]['id'];
    $data_to_store['type'] = $details['type'];
    $data_to_store['email'] = $details['email'];

    $status = $db->insert ($table_filter_users, $data_to_store);
    
    if ($status) 
    {
        $_SESSION['info'] = str_replace("{s}",$details['email'],$lang['scoreboard-log-add-success']);
        header('location: scoreboard.php');
        exit;
    }
    else
    {
    	$_SESSION['failure'] = $lang['scoreboard-log-add-fail'];
    	header('location: scoreboard.php');
        exit;

    }
    
}