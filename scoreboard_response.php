<?php
	session_start();
	require_once './config/config.php';
	
	$params = $columns = $totalRecords = $data = array();
	$params = $_REQUEST;

	$where_condition = $sqlTot = $sqlRec = "";

	$columns = array('id', 'name', 'email', 'type', 'score', 'date');

	if( !empty($params['search']['value']) ) {
		$db->where('name', '%' . $params['search']['value'] . '%', 'like');
		$db->orwhere('email', '%' . $params['search']['value'] . '%', 'like');
		$db->orwhere('type', '%' . $params['search']['value'] . '%', 'like');
		$db->orwhere('score', '%' . $params['search']['value'] . '%', 'like');
	}

	if( !empty($params['columns'][5]['search']['value']) ) {
		if($params['columns'][5]['search']['value'] == 'daily'){
			$db->where('DATE(date) = CURDATE()');
		}else if($params['columns'][5]['search']['value'] == 'weekly'){
			$db->where('YEARWEEK(date)= YEARWEEK(CURDATE())');
		}else if($params['columns'][5]['search']['value'] == 'monthly'){
			$db->where('Year(date)=Year(CURDATE()) AND Month(date)= Month(CURDATE())');
		}
	}
	
	$columnsOrder = array('', 'id', 'name', 'email', 'type','score', '', 'date');

	$db->orderBy($columnsOrder[$params['order'][0]['column']], $params['order'][0]['dir']);
	$limit = Array ($params['start'], $params['length']);
	if($params['length'] == -1){
		$limit = null;	
	}

	$records = $db->withTotalCount()->get($table_scoreboards[$_SESSION['table_index']]['table'], $limit, $columns);
	$totalRecords = $db->totalCount;
	
	foreach ($records as $row){
		//$row['type'] = $params['order'][0]['column'];
		$row['filter_user'] = '';
		$row['filter_score'] = '';

		//filter users
		$db->where ('status', 1);
		$db->where ('email', $row['email']);
		$db->where ('game', $table_scoreboards[$_SESSION['table_index']]['id']);
		$filterUsers = $db->getOne($table_filter_users);

		if ($db->count > 0){
			/*if($filterUsers['type'] != ''){
				if($filterUsers['type'] == $row['type']){
					$row['filter_user'] = 'banned';
				}
			}else{
				$row['filter_user'] = 'banned';
			}*/
			//$row['filter_user'] = $row['type'];
			if($filterUsers['type'] == $row['type']){
				$row['filter_user'] = 'banned';
			}
		}

		//filter scores
		$db->where ('status', 1);
		$db->where ('game', $table_scoreboards[$_SESSION['table_index']]['id']);
		$filterScores = $db->get($table_filter_scores);

		foreach ($filterScores as $filterRow){
			$scoreMin = $filterRow['score_min'];
			$scoreMax = $filterRow['score_max'];

			/*if($filterRow['type'] != ''){
				if($filterRow['type'] == $row['type']){
					if ( !in_array($row['score'], range($scoreMin,$scoreMax)) ) {
						$row['filter_score'] = 'Score Between ( '.$scoreMin.', '.$scoreMax.' )';
					}
				}
			}else{
				if ( !in_array($row['score'], range($scoreMin,$scoreMax)) ) {
					$row['filter_score'] = 'Score Between ( '.$scoreMin.', '.$scoreMax.' )';
				}
			}*/
			if($filterRow['type'] == $row['type']){
				//if ( !in_array($row['score'], range($scoreMin,$scoreMax)) ) {
				if(($scoreMin <= $row['score']) && ($row['score'] <= $scoreMax)){
				
				}else{
					$row['filter_score_min'] = $scoreMin;
					$row['filter_score_max'] = $scoreMax;
					$row['filter_score'] = 'Score Between ( '.$scoreMin.', '.$scoreMax.' )';
				}
			}
		}

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
	