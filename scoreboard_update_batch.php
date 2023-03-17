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
    	header('location: scoreboard.php');
        exit;
	}
	
	$batch_id = explode (",", $batch_id);
	$totalRecord = 0;
	$completeRecord = 0;
	$status_message = '';
	
	if($update_status == 'remove'){
		$status_message = $lang['scoreboard-log-batch-remove-success'];
		foreach ($batch_id as &$scoreboard_id) {
			$db->where('id', $scoreboard_id);
			$status = $db->delete($table_scoreboards[$_SESSION['table_index']]['table']);
			if($status){
				$completeRecord++;	
			}
			
			$totalRecord++;
		}
	}else if($update_status == 'filter'){
		$status_message = $lang['scoreboard-log-batch-add-success'];
		foreach ($batch_id as &$scoreboard_id) {
			$db->where('id', $scoreboard_id);
			$details = $db->getOne($table_scoreboards[$_SESSION['table_index']]['table']);

			$data_to_store['game'] = $table_scoreboards[$_SESSION['table_index']]['id'];
			$data_to_store['type'] = $details['type'];
			$data_to_store['email'] = $details['email'];
			$status = $db->insert ($table_filter_users, $data_to_store);

			if($status){
				$completeRecord++;	
			}
			
			$totalRecord++;
		}
	}
	
	$_SESSION['info'] = $completeRecord.$lang['scoreboard-log-batch-of'].$totalRecord.$status_message;
	header('location: scoreboard.php');
	exit;
}