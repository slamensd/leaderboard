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
    	header('location: filter_users.php');
        exit;

	}
    $user_id = $del_id;
    $db->where('id', $user_id);
	$details = $db->getOne($table_filter_users);
	$db->where('id', $user_id);
    $status = $db->delete($table_filter_users);
    
    if ($status) 
    {
        $_SESSION['info'] = str_replace("{s}",$details['email'],$lang['filter-users-log-delete-success']);
        header('location: filter_users.php');
        exit;
    }
    else
    {
    	$_SESSION['failure'] = $lang['filter-users-log-delete-fail'];
    	header('location: filter_users.php');
        exit;

    }
    
}