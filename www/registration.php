<?php
	require_once('config/database.php');
    require_once('config/cookie.php');
    require_once('libraries/lib.php');
    require_once('libraries/validation.php');
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $link = db_connect();
        
        $u_name = clearStr($_POST['u_name']);
        $email = clearStr($_POST['email']);
        $u_psw = $_POST['u_psw'];
        $family = clearStr($_POST['family']);
        $name = clearStr($_POST['name']);
        $sec_name = clearStr($_POST['sec_name']);
        
        $res = valid($email);
        
        $user = u_name($link, $u_name);
        
        $mail = email($link, $email);
        
        if (!$user && !$mail && !$res) {
                
            $u_psw = md5($u_psw);
                
            set_cookie($email, $u_psw);
            
            if ($u_name&&$email&&$u_psw&&$family&&$name&&$sec_name) {
                
                $sql = "INSERT INTO users (u_name, email, u_psw, family, name, sec_name) 
                                    VALUES ('%s', '%s', '%s', '%s', '%s', '%s')";
                $query = sprintf($sql, mysqli_real_escape_string($link, $u_name), 
                                     mysqli_real_escape_string($link, $email),
                                     mysqli_real_escape_string($link, $u_psw),
                                     mysqli_real_escape_string($link, $family),
                                     mysqli_real_escape_string($link, $name),
                                     mysqli_real_escape_string($link, $sec_name));
                
                $resultat = mysqli_query($link, $query);            
            } 
        }
    }
    
    $registration = array(
                        array('item' => 'Имя пользователя', 'type' => 'text', 'name' => 'u_name', 'value' => $u_name),
                        array('item' => 'e-mail', 'type' => 'text', 'name' => 'email', 'value' => $email),
                        array('item' => 'Пароль', 'type' => 'password', 'name' => 'u_psw', 'value' => $u_psw),
                        array('item' => 'Фамилия', 'type' => 'text', 'name' => 'family', 'value' => $family),
                        array('item' => 'Имя', 'type' => 'text', 'name' => 'name', 'value' => $name),
                        array('item' => 'Отчество', 'type' => 'text', 'name' => 'sec_name', 'value' => $sec_name),
                        array('item' => 'Запомнить на месяц', 'type' => 'checkbox', 'name' => 'u_check', 'value' => 'Yes'),
                    );
                    
    $header = 'Регистрация';   
    include('views/header.php');
    include('views/registration.php');
    include('views/footer.php');
?>