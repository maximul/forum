<?php
	if(isset($_COOKIE['email'])&&isset($_COOKIE['psw'])) {
       setcookie('email', '', time() - 3600);
       setcookie('psw', '', time() - 3600);
       header("Location: index.php");
       exit;
    } else {
       header("Location: index.php");
       exit;
    }
?>