<?php
    function clearInt($data) {
        return abs((int)$data);
    }
    
	function clearStr($data) {
        global $link;
        return mysqli_real_escape_string($link, trim(strip_tags($data)));
    }
    
    function stripTags($document) {
        
        $search = array ("'([\r\n])[\s]+'",                 // Вырезается пустое пространство
                         "'&(quot|#34);'i",                 // Замещаются html-элементы
                         "'&(amp|#38);'i",
                         "'&(lt|#60);'i",
                         "'&(gt|#62);'i",
                         "'&(nbsp|#160);'i",
                         "'&(copy|#169);'i",
                         "'\\\(left|right)\\\'",             
                         "'\\\[q]?quad'",
                         "'\\\geqslant\s'",
                         "'\\\leqslant\s'",
                         "'\\\in\s\\\'",
                         "'\\\!'");
        
        $replace = array ("\\1",
                          "\"",
                          "&",
                          "<",
                          ">",
                          " ",
                          iconv("Windows-1251", "UTF-8", chr(169)),
                          "",
                          "",                          
                          ">=",
                          "<=",
                          iconv("Windows-1251", "UTF-8", chr(170)),
                          "");
        
        $text = preg_replace ($search, $replace, strip_tags($document, '<a><b><i><u><p><img>'));
        
        return base64_encode(trim($text));
    }
    
    // Menu
    $topMenu = array(
                    array('link_name' => 'Главная', 'href' => 'index.php'),
                    array('link_name' => 'Темы', 'href' => 'themes.php'),
                    array('link_name' => $link_name, 'href' => $href)
                );
    
    function drawMenu($menu) {
        if(!is_array($menu))
            return false;
        echo '<ul>';
        foreach ($menu as $value) {
            $id = '';
            $style = '';
            if ($value['link_name'] == 'Главная') {
                $id = ' id="menu_li_first"';
                $style = ' style="margin-left:12px;"';
            }
            echo "<li$id$style>";
            echo "<a href='{$value['href']}'>{$value['link_name']}</a>";
            echo "</li>";
        }
        echo '</ul>';
        return true;
    }
    
    function drawReg($registr, $user, $mail, $res) {
        if(!is_array($registr))
            return false;
        foreach ($registr as $val) {
            $style = ' align="right"';
            $autofocus = '';
            $required = '';
            if ($val['item'] == 'Имя пользователя')
                $autofocus = 'autofocus';
            if ($val['item'] != 'Запомнить на месяц')
                $required = 'required';
            echo "<tr>
        			<td$style><b>{$val['item']}:</b></td>
        			<td><input type='{$val['type']}' name='{$val['name']}' value='{$val['value']}' $autofocus $required /></td>";
            if ($user and $val['item'] == 'Имя пользователя') {
                echo '<td>
        	           <b style="color: red;">Такой пользователь уже существует</b>
                    </td>';
            }
            if ($val['item'] == 'e-mail') {
                if ($mail)
                    echo '<td>
            	           <b style="color: red;">Такой '.$val['item'].' уже существует</b>
                        </td>';
                echo $res;
            }
        	echo "</tr>";
        }
        return true; 
    }
    
    function drawSettings($settings, $user, $mail, $res) {
        if(!is_array($settings))
            return false;
        foreach ($settings as $val) {
            $style = ' align="right"';
            $autofocus = '';
            if ($val['item'] == 'Имя админа')
                $autofocus = 'autofocus';
            echo "<tr>
        			<td$style><b>{$val['item']}:</b></td>
        			<td><input type='{$val['type']}' name='{$val['name']}' value='{$val['value']}' $autofocus /></td>";
            if ($user and $val['item'] == 'Имя админа') {
                echo '<td>
        	           <b style="color: red;">С таким именем уже существует пользователь</b>
                    </td>';
            }
            if ($val['item'] == 'e-mail') {
                if ($mail)
                    echo '<td>
            	           <b style="color: red;">Такой '.$val['item'].' уже существует</b>
                        </td>';
                echo $res;
            }
        	echo "</tr>";
        }
        return true; 
    }
    
    function inspect($link, $email, $u_psw) {
        
        $sql = "SELECT uid FROM users WHERE email = '$email'
                                            AND u_psw = '$u_psw'";
                                            
        $result = mysqli_query($link, $sql);
        if (!$result) {
            echo 'Ошибка получения данных';
            mysqli_close($link);
            exit;
        } else {
            $row = mysqli_fetch_object($result);
            $uid = $row->uid;
            mysqli_free_result($result);
        }
        return $uid;
    }
    
    function start($limit, $all) {
        $pages = ceil( $all / $limit );
        $lastStart = ($pages - 1) * $limit;
        if (isset($_GET['start'])) {
            $start = intval($_GET['start']);
            if ($start < 0 or !is_numeric($start))
                $start = 0;
            elseif ($start > $lastStart)
                $start = $lastStart;
        } else {
            $start = 0;
        }
        return $start;
    }
    
    function u_name($link, $u_name) {
        
        $sql = "SELECT u_name FROM users WHERE u_name = '%s'";
        $query = sprintf($sql, $u_name);
                                    
        $result = mysqli_query($link, $query);
        if (!$result) {
            echo 'Ошибка получения данных';
            mysqli_close($link);
            exit;
        } else {
            $row = mysqli_fetch_object($result);
            $user = $row->u_name;
            mysqli_free_result($result);
        }
        return $user;
    }
    
    function email($link, $email) {
        
        $sql = "SELECT email FROM users WHERE email = '%s'";
        $query = sprintf($sql, $email);
                                    
        $result = mysqli_query($link, $query);
        if (!$result) {
            echo 'Ошибка получения данных';
            mysqli_close($link);
            exit;
        } else {
            $row = mysqli_fetch_object($result);
            $mail = $row->email;
            mysqli_free_result($result);
        }
        return $mail;
    }
    
    function settings($link) {
        
        $sql = "SELECT * FROM settings";
                            
        $result = mysqli_query($link, $sql);
        if (!$result) {
            echo 'Ошибка получения данных';
            mysqli_close($link);
            exit;
        } else {
            $row = mysqli_fetch_object($result);
            mysqli_free_result($result);
        }
        return $row;
    }
    
    function role($link, $uid, $menu) {
        
        $sql = "SELECT role FROM users WHERE uid = %d";
        $query = sprintf($sql, $uid);
                            
        $result = mysqli_query($link, $query);
        if (!$result) {
            echo 'Ошибка получения данных';
            mysqli_close($link);
            exit;
        } else {
            $row = mysqli_fetch_object($result);
            $role = $row->role;
            mysqli_free_result($result);
            //Проверка роли
            if ($role == 2) {
                array_splice($menu, 2, 0, array(array('link_name' => 'Настройки', 'href' => 'settings.php')));        
            }
        }
        return $menu;
    }
?>