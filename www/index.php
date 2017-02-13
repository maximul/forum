<?php
    require_once('config/database.php');
    require_once('config/cookie.php');
    require_once('libraries/lib.php');
    
    $link = db_connect();
    
    if (!empty($email)&&!empty($u_psw)) {  
        $uid = inspect($link, $email, $u_psw);
        $topMenu = role($link, $uid, $topMenu);
    }
    
    $header = 'Форум на любую тему';     
    include('views/header.php');
    include('views/content.php');
    include('views/footer.php');
?>