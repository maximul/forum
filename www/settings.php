<?php
    require_once('config/database.php');
    require_once('config/cookie.php');
    require_once('libraries/lib.php');
    require_once('libraries/validation.php');
    
    $link = db_connect();
            
    $query = sprintf("SELECT u_name, email, u_psw FROM users WHERE role = '%d'", 2);
                            
    $result = mysqli_query($link, $query);
    if (!$result) {
        echo 'Ошибка получения данных';
        mysqli_close($link);
        exit;
    } else {
        $row = mysqli_fetch_object($result);
        $admin_name = $row->u_name;
        $admin_email = $row->email;
        $admin_psw = $row->u_psw;
        mysqli_free_result($result);
    }
    
    $row = settings($link);
    
    $per_page_themes = $row->per_page_themes;
    $per_page_msg = $row->per_page_msg;
    $per_chunk_links = $row->per_chunk_links;
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $new_admin_name = clearStr($_POST['admin_name']);
        $new_admin_email = clearStr($_POST['admin_email']);
        $new_admin_psw = $_POST['admin_psw'];
        $per_page_themes = clearInt($_POST['per_page_themes']);
        $per_page_msg = clearInt($_POST['per_page_msg']);
        $per_chunk_links = clearInt($_POST['per_chunk_links']);
        
        $res = valid();
            
        //Запрос
        $sql = "UPDATE settings SET per_page_themes='%d', per_page_msg='%d', per_chunk_links='%d'"; 
        $query = sprintf($sql, (int)$per_page_themes, 
                             (int)$per_page_msg,
                             (int)$per_chunk_links);
        
        $result = mysqli_query($link, $query);
        
        if (!$result){
            echo 'Ошибка получения данных';
            mysqli_close($link);
            exit;
        }
        
        mysqli_affected_rows($link);
                
        $arr_post = array($new_admin_name, $new_admin_email, $new_admin_psw);
        $arr_set = array($admin_name, $admin_email, $admin_psw);
            
        if ($arr_post != $arr_set or isset($_POST['admin_check'])) {
            
            $user = u_name($link, $new_admin_name);
            
            $mail = email($link, $new_admin_email);
            
            if (!$user and !$mail and $r != 0) {
            
                if ($new_admin_psw != $admin_psw)
                    $new_admin_psw = md5($new_admin_psw);
                
                if (isset($_COOKIE['email'])&&isset($_COOKIE['psw'])) {
                    setcookie('email', '', time() - 3600);
                    setcookie('psw', '', time() - 3600);
                }
                
                set_cookie($email, $u_psw);
                
                //Запрос
                $sql = "UPDATE users SET u_name='%s', email='%s', u_psw='%s' WHERE role = '%d'"; 
                $query = sprintf($sql, $new_admin_name, 
                                     $new_admin_email,
                                     $new_admin_psw, 2);
                
                $result = mysqli_query($link, $query);
                
                if (!$result)
                    die(mysqli_error($link));
                
                return mysqli_affected_rows($link);
            } 
        }
        header("Location: ".$_SERVER["PHP_SELF"]);
        exit;
    }
    
    $settings = array(
                        array('item' => 'Имя админа', 'type' => 'text', 'name' => 'admin_name', 'value' => $admin_name),
                        array('item' => 'e-mail', 'type' => 'text', 'name' => 'admin_email', 'value' => $admin_email),
                        array('item' => 'Пароль', 'type' => 'password', 'name' => 'admin_psw', 'value' => $admin_psw),
                        array('item' => 'Записей на страницу с темами', 'type' => 'text', 'name' => 'per_page_themes', 'value' => $per_page_themes),
                        array('item' => 'Записей на страницу с сообщениями', 'type' => 'text', 'name' => 'per_page_msg', 'value' => $per_page_msg),
                        array('item' => 'Количество ссылок на странице', 'type' => 'text', 'name' => 'per_chunk_links', 'value' => $per_chunk_links),
                        array('item' => 'Запомнить на месяц', 'type' => 'checkbox', 'name' => 'admin_check', 'value' => 'Yes'),
                    );
    
    if (!empty($email)&&!empty($u_psw)) {  
        $uid = inspect($link, $admin_email, $admin_psw);
        $topMenu = role($link, $uid, $topMenu);
    }
                    
    $header = 'Настройки';     
    include('views/header.php');
    include('views/settings.php');
    include('views/footer.php');