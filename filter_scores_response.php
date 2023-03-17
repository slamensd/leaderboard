<?php
	session_start();
	require_once './config/config.php';
	
	$params = $columns = $totalRecords = $data = array();
	$params = $_REQUEST;

	$where_condition = $sqlTot = $sqlRec = "";

	$columns = array('id', 'game', 'type', 'score_min', 'score_max', 'status', 'date');

	if( !empty($params['search']['value']) ) {
		$db->where('game', '%' . $params['search']['value'] . '%', 'like');
		$db->orwhere('type', '%' . $params['search']['value'] . '%', 'like');
		$db->orwhere('score_min', '%' . $params['search']['value'] . '%', 'like');
		$db->orwhere('score_max', '%' . $params['search']['value'] . '%', 'like');
	}

	$columnsOrder = array('', 'id', 'game', 'type', 'score_min', 'score_max', 'status', 'date');
	
	$db->orderBy($columnsOrder[$params['order'][0]['column']], $params['order'][0]['dir']);
	$limit = Array ($params['start'], $params['length']);
	if($params['length'] == -1){
		$limit = null;	
	}

	$records = $db->withTotalCount()->get($table_filter_scores, $limit, $columns);
	$totalRecords = $db->totalCount;
	
	foreach ($records as $row){
		$data[] = $row;
	}

	$json_data = array(
		"draw"            => intval( $params['draw'] ),   
		"recordsTotal"    => intval( $totalRecords ),  
		"recordsFiltered" => intval($totalRecords),
		"data"            => $data
	);

	echo json_encode($json_data);
?>
	