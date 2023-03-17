<?php
	
	require_once './config/config.php';
	
	$params = $columns = $totalRecords = $data = array();
	$params = $_REQUEST;

	$where_condition = $sqlTot = $sqlRec = "";

	$columns = array('id', 'user_name', 'admin_type');

	if( !empty($params['search']['value']) ) {
		$db->where('user_name', '%' . $params['search']['value'] . '%', 'like');
		$db->orwhere('admin_type', '%' . $params['search']['value'] . '%', 'like');
	}
	
	$db->orderBy($columns[$params['order'][0]['column']], $params['order'][0]['dir']);

	$limit = Array ($params['start'], $params['length']);
	if($params['length'] == -1){
		$limit = null;	
	}

	$records = $db->withTotalCount()->get($table_admin, $limit, $columns);
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
	