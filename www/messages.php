<?php
    require_once('config/database.php');
    require_once('config/cookie.php');
    require_once('libraries/lib.php');
    require_once('libraries/SimPageNav.php');
        
	$uid = $_GET['uid'];
    $tid = $_GET['tid'];
    
    $uid = clearInt($uid);
    $tid = clearInt($tid);
    
    // Проверка
    if ($tid == 0) {
        return false;
    }
        
    $link = db_connect();
    
    $sql = "SELECT themes . them_content AS t_content 
                FROM themes WHERE themes . them_id = $tid";
    
    $result = mysqli_query($link, $sql);
    
    if (!$result) {
        echo 'Ошибка выполнения запроса';
        mysqli_close($link);
        exit;
    }
    
    $res = mysqli_fetch_object($result);
    
    $t_content = $res->t_content;
    
    $sql = "SELECT messages . msg_date AS msg_d,
                users . u_name AS msg_u_name,
                messages . msg_content AS msg_c 
                FROM messages, users WHERE (messages . msg_uid = users . uid) 
                AND (messages . msg_tid = $tid) ORDER BY msg_d";
    
    $result = mysqli_query($link, $sql);
    
    if (!$result) {
        echo 'Ошибка выполнения запроса';
        mysqli_close($link);
        exit;
    }
    
    $res = settings($link);
    
    $limit = $res->per_page_msg;;
    $linkLimit = $res->per_chunk_links;
    $all = mysqli_num_rows($result);
    $start = start($limit, $all);
    
    if (!empty($email)&&!empty($u_psw)) {
        include('inc/addmsg.php');
        $topMenu = role($link, $uid, $topMenu);
    }  
    
    $header = $t_content;
    include('views/header.php');
    
    echo "<h2>Сообщения по теме <b><a href='messages.php?tid=$tid&uid=$uid&start=$start'>\"$t_content\"</a></b></h2>
            <div align='left'><b>Список сообщений:</b></div>";

    $message = 'Сообщение';
    include('views/tshapka.php');
    
    $i = 1;
	while($row = mysqli_fetch_object($result)) {
	   if ($i > $start and $i <= ($start + $limit)) {
	       echo '<tr>
            		<td align="center">'.$row->msg_u_name.'</td>
            		<td align="justify">'.base64_decode($row->msg_c).'</td>
                </tr>
                <tr>
                    <td align="center">Дата:</td>
            		<td align="center">'.$row->msg_d.'</td>
            	</tr>';
	   }
	   $i++;
	}
    
    echo '</table><br />';

    if (!empty($email)&&!empty($u_psw)) {
        include('views/msg_forms.php'); 
    } else {
        echo '<input type="button" value="Выйти из форума" onclick="javascript:document.location.href=\'index.php\'" />';
    }
 
    $pageNav = new SimPageNav();
     
    echo $pageNav->getLinks( $all, $limit, $start, $linkLimit, 'start' );
    
	mysqli_free_result($result);
    mysqli_close($link);
    include('views/footer.php');
?>