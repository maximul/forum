<?php
    $login = true;    
    require_once('config/database.php');
    require_once('config/cookie.php');
    require_once('libraries/lib.php');
        
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = trim(strip_tags($_POST['email']));
        $u_psw = md5($_POST['u_psw']);
        
        $link = db_connect();
        
        if (!empty($email)&&!empty($u_psw)) {
            
            $uid = inspect($link, $email, $u_psw);
            
            if (!$uid) {
                $error = 'Не верный e-mail или пароль';
                mysqli_close($link);
            } else {
                set_cookie($email, $u_psw);
                header("Location: index.php");
                exit;
            }             
        }
    }
    $header = 'Вход';    
    include('views/header.php');
    include('views/login.php');
	include('views/footer.php');
?>