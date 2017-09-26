<?php
    $msg_date = date('Y-m-d');
    
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	   
        $uid = $_POST['uid'];
        $tid = $_POST['tid'];
        $start = $_POST['start'];
        $msg_content = $_POST['new_msg'];
        
        $msg_c = stripTags($msg_content);
        
        if ($msg_c) {
            
            $sql = "INSERT INTO messages (msg_tid, msg_uid, msg_date, msg_content) VALUES ('%d', '%d', '%s', '%s')";
            $query = sprintf($sql, (int)$tid,
                                (int)$uid,
                                mysqli_real_escape_string($link, $msg_date),
                                mysqli_real_escape_string($link, $msg_c));
            
            $result = mysqli_query($link, $query);
        }
        
        header("Location: ".$_SERVER["PHP_SELF"]."?tid=$tid&uid=$uid&start=$start");
        exit;
    }
?>