<?php 
    session_start();
    if($_SESSION['auth'] && $_SESSION['role'] == 'admin'){
        if($_POST){
        	header('location: admin_labid.php');
        }
    }
?>