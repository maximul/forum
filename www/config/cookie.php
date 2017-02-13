<?php
    $email = trim(strip_tags($_COOKIE['email']));
    $u_psw = $_COOKIE['psw'];
    
	if (!empty($email)&&!empty($u_psw)) {        
        $href = 'logout.php';
        $link_name = 'Выход';
    } elseif ($login) {
        $href = 'registration.php';
        $link_name = 'Регистрация';
    } else {
        $href = 'login.php';
        $link_name = 'Вход';
    }
    
    function set_cookie($email, $u_psw) {
        if (isset($_POST['u_check'])) {
            setcookie('email', $email, time() + 600);
            setcookie('psw', $u_psw, time() + 600);
        } else {
            setcookie('email', $email);
            setcookie('psw', $u_psw);
        }
    }
?>