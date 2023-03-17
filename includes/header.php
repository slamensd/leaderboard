<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php echo $lang['header-title']; ?></title>

        <!-- Bootstrap Core CSS -->
        <link href="css/dataTables.bootstrap4.min.css" rel="stylesheet" />
        <link href="css/datepicker.css" rel="stylesheet" />
        <script src="js/all.min.js"></script>

        <!-- Custom CSS -->
        <link rel="shortcut icon" href="icon.ico" type="image/x-icon">
		<link href="css/styles.css" rel="stylesheet">

    </head>

    <body class="<?php if(isset($_SESSION['user_logged_in'.$session_app]) && $_SESSION['user_logged_in'.$session_app] == true ) { echo ''; }else{ echo 'bg-secondary'; } ?>">
		<?php if (isset($_SESSION['user_logged_in'.$session_app]) && $_SESSION['user_logged_in'.$session_app] == true ) : ?>
		<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php"><?php echo $lang['header-administrator']; ?></a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><svg class="svg-inline--fa fa-bars fa-w-14" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="bars" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"></path></svg><!-- <i class="fas fa-bars"></i> --></button>
			
			<!-- Navbar-->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg class="svg-inline--fa fa-user fa-w-14 fa-fw" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"></path></svg><!-- <i class="fas fa-user fa-fw"></i> --></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                       <!-- <a class="dropdown-item" href="#">Settings</a><a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>-->
                        <a class="dropdown-item" href="logout.php"><?php echo $lang['header-logout']; ?></a>
                    </div>
                </li>
            </ul>
        </nav>
		
        <div id="layoutSidenav">
            
            <!-- Navigation -->
            
			<div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading"><?php echo $lang['header-side-core']; ?></div>
                            <a class="nav-link" href="index.php"
                                ><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                <?php echo $lang['header-side-dashboard']; ?>
							</a>
                            <div class="sb-sidenav-menu-heading"><?php echo $lang['header-side-scoreboard']; ?></div>
                            <a class="nav-link" href="scoreboard.php">
								<div class="sb-nav-link-icon"><i class="fas fa-trophy"></i></div>
                                <?php echo $lang['header-side-scoreboard']; ?>
							</a>

                            <div class="sb-sidenav-menu-heading"><?php echo $lang['header-side-filters']; ?></div>
                            <a class="nav-link" href="filter_users.php">
								<div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                <?php echo $lang['header-side-users']; ?>
							</a>
                            <a class="nav-link" href="filter_scores.php">
								<div class="sb-nav-link-icon"><i class="fas fa-star"></i></div>
                                <?php echo $lang['header-side-scores']; ?>
							</a>
							
							<?php if ($_SESSION['admin_type'] == 'super'){ ?>
                            <div class="sb-sidenav-menu-heading"><?php echo $lang['header-side-admin']; ?></div>
							<a class="nav-link" href="admin_users.php">
								<div class="sb-nav-link-icon"><i class="fas fa-user-lock"></i></div>
                                <?php echo $lang['header-side-admin-accounts']; ?>
							</a>
							<?php } ?>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small"><?php echo $lang['header-side-login']; ?></div>
                        <?php echo $_SESSION['user_name']; ?>
                    </div>
                </nav>
			</div>
			
			<div id="layoutSidenav_content">
		<?php endif; ?>
            <!-- The End of the Header -->