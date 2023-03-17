<?php

define('BASE_PATH', dirname(dirname(__FILE__)));
define('APP_FOLDER','dashboard');


require_once BASE_PATH.'/lib/MysqliDb.php';

$servername = "localhost";
$username = "taktic84_admin";
$password = "BabyJ0816";
$dbname = "taktic84_leaderboard";

//tables
$table_admin = 'admin_accounts';
$table_filter_users = 'filter_users';
$table_filter_scores = 'filter_scores';

$table_scoreboards = array(
    array(
        'id' => 'findme',
        'name' => 'Find Me',
        'table' => 'findme',
        'score' => 'point'
    )
);

//session app
$session_app = 'scoreboardadmin';

// create connection object
$db = new MysqliDb($servername,$username,$password,$dbname);
