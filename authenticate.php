<?php 
require_once './config/config.php';
require_once './language/language.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $username = filter_input(INPUT_POST, 'username');
    $passwd = filter_input(INPUT_POST, 'passwd');
    $remember = filter_input(INPUT_POST, 'remember');
    $passwd=  md5($passwd);
   	
    // $query = "SELECT * FROM admin_accounts WHERE user_name='$username' AND passwd='$passwd'";
    // $row = $db->query($query);

    $db->where ("user_name", $username);
    $db->where ("passwd", $passwd);
    $row = $db->get('admin_accounts');
     
    if ($db->count >= 1) {
        $_SESSION['user_logged_in'.$session_app] = TRUE;
        $_SESSION['admin_type'] = $row[0]['admin_type'];
		$_SESSION['user_name'] = $row[0]['user_name'];
		$_SESSION['table_index'] = 0;
        
       	if($remember)
       	{
       		setcookie('username',$username , time() + (86400 * 90), "/");
       		setcookie('password',$passwd , time() + (86400 * 90), "/");
       	}
        header('Location:index.php');
        exit;
    } else {
        $_SESSION['login_failure'] = $lang['login-log-invalid'];
        header('Location:login.php');
        exit;
    }
  
}