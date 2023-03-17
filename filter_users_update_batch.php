<?php 
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
require_once './language/language.php';
$batch_id = filter_input(INPUT_POST, 'batch_id');
$update_status = filter_input(INPUT_POST, 'update_status');

if ($batch_id && $_SERVER['REQUEST_METHOD'] == 'POST') 
{

	if($_SESSION['admin_type']!='super'){
		$_SESSION['failure'] = $lang['permission-denied-log'];
    	header('location: filter_users.php');
        exit;
	}
	
	$batch_id = explode (",", $batch_id);
	$totalRecord = 0;
	$completeRecord = 0;
	$status_message = '';
	
	if($update_status == 'remove'){
		$status_message = $lang['filter-users-log-batch-remove-success'];
		foreach ($batch_id as &$filter_id) {
			$db->where('id', $filter_id);
			$status = $db->delete($table_filter_users);
			if($status){
				$completeRecord++;	
			}
			
			$totalRecord++;
		}
	}else if($update_status == 'active'){
		$status_message = $lang['filter-users-log-batch-active-success'];
		foreach ($batch_id as &$filter_id) {
			$data_to_store['status'] = 1;
			$db->where('id', $filter_id);
			$status = $db->update ($table_filter_users, $data_to_store);

			if($status){
				$completeRecord++;	
			}
			$totalRecord++;
		}
	}else if($update_status == 'inactive'){
		$status_message = $lang['filter-users-log-batch-inactive-success'];
		foreach ($batch_id as &$filter_id) {
			$data_to_store['status'] = 0;
			$db->where('id', $filter_id);
			$status = $db->update ($table_filter_users, $data_to_store);

			if($status){
				$completeRecord++;	
			}
			$totalRecord++;
		}
	}
	
	$_SESSION['info'] = $completeRecord.$lang['filter-users-log-batch-of'].$totalRecord.$status_message;
	header('location: filter_users.php');
	exit;
}