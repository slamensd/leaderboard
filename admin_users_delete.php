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
    	header('location: admin_users.php');
        exit;

	}
    $member_id = $del_id;
    $db->where('id', $member_id);
	$details = $db->getOne($table_admin);
	$db->where('id', $member_id);
    $status = $db->delete($table_admin);
    
    if ($status) 
    {
        $_SESSION['info'] = str_replace("{s}",$details['user_name'],$lang['admin-log-delete-success']);
        header('location: admin_users.php');
        exit;
    }
    else
    {
    	$_SESSION['failure'] = $lang['admin-log-delete-fail'];
    	header('location: admin_users.php');
        exit;

    }
    
}