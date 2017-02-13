<?php
    $them_date = date('Y-m-d');
        
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $uid = $_POST['uid'];
        $them_content = $_POST['new_theme'];
        
        $t_content = clearStr($them_content);
        
        if ($t_content) {
            
            $sql = "INSERT INTO themes (them_uid, them_date, them_content) VALUES ($uid, '$them_date', '$t_content')";
            
            $result = mysqli_query($link, $sql);
        }        
        
        header("Location: ".$_SERVER["PHP_SELF"]."?start=$start");
        exit;
    } 
?>