<?php
    require_once('config/database.php');
    require_once('config/cookie.php');
    require_once('libraries/lib.php');
    require_once('libraries/SimPageNav.php');
    
    $link = db_connect();
    
    $sql = "SELECT themes . them_id AS tid,
                themes . them_uid AS tuid,
                users . u_name AS t_u_name,
                themes . them_date AS t_date,
                themes . them_content AS t_content 
                FROM themes, users WHERE themes . them_uid = users . uid ORDER BY t_date";
    
    $result = mysqli_query($link, $sql);
    
    if (!$result) {
        echo 'Ошибка выполнения запроса';
        mysqli_close($link);
        exit;
    }
    
    $res = settings($link);
    
    $limit = $res->per_page_themes;
    $linkLimit = $res->per_chunk_links;
    $all = mysqli_num_rows($result);
    $start = start($limit, $all); 
    
    if (!empty($email)&&!empty($u_psw)) {        
        include('inc/addtheme.php');        
        $uid = inspect($link, $email, $u_psw);
        $topMenu = role($link, $uid, $topMenu);
    }
    
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
    } else {
        $action = "";
    }
    
    if ($action == "delete")
        include('inc/deletetheme.php');
        
    $header = 'Список тем форума';      
    include('views/header.php');
    
    echo '<div align="left"><b>Список тем форума:</b></div>';    

    $theme = 'Тема';
    include('views/tshapka.php');
    
    $i = 1;
	while ($row = mysqli_fetch_object($result)) {
       if ($i > $start and $i <= ($start + $limit)) {
	       $style = ' style="padding-left: 5px"'; 	   
    	   echo "<tr>
            		<td$style>{$row->t_u_name}</td>
            		<td$style><a href='messages.php?tid={$row->tid}&uid=$uid'>{$row->t_content}</a></td>
                </tr>
                <tr>
                    <td$style>Дата:</td>         
                    <td$style>{$row->t_date}</td>
                </tr>";
           if (!empty($email)&&!empty($u_psw)) {
                if ($uid == $row->tuid)
                    echo "<tr>
                            <td></td>
                            <td class='delete' align='right' style='padding-right: 5px'><a href='themes.php?action=delete&tid={$row->tid}&uid=$uid&start=$start'>Удалить</a></td>
                         </tr>";
           }  
	   }
	   $i++;  
	}
    
    echo '</table><br />';

    if (!empty($email)&&!empty($u_psw)) {
        include('views/theme_forms.php'); 
    } else {
        echo '<input type="button" value="Выйти из форума" onclick="javascript:document.location.href=\'index.php\'" />';
    }
 
    $pageNav = new SimPageNav();
     
    echo $pageNav->getLinks( $all, $limit, $start, $linkLimit, 'start' );
    
	mysqli_free_result($result);
    mysqli_close($link);
    include('views/footer.php');
?>