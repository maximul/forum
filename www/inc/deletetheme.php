<?php
    $uid = $_GET['uid'];
    $tid = $_GET['tid'];
    
    $uid = clearInt($uid);
    $tid = clearInt($tid);
    
    // Проверка
    if ($uid == 0 or $tid == 0) {
        return false;
    }
    
    //Запрос
    $query = sprintf("DELETE FROM themes WHERE them_uid='%d' AND them_id='%d'", $uid, $tid);
    $result = mysqli_query($link, $query);
    
    if (!$result)
        die('Ошибка выполнения запроса');
    
    mysqli_affected_rows($link);
    
    //Запрос
    $query = sprintf("DELETE FROM messages WHERE msg_tid='%d'", $tid);
    $result = mysqli_query($link, $query);
    
    if (!$result)
        die('Ошибка выполнения запроса');
    
    mysqli_affected_rows($link);
    
    header("Location: {$_SERVER["PHP_SELF"]}?&start=$start");
    exit;
?>