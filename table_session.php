<?php 
session_start();
require_once './config/config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $tableIndex = filter_input(INPUT_POST, 'tableIndex');
  
    $_SESSION['table_index'] = $tableIndex;
}