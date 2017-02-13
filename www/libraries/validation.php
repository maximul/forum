<?php
	function valid($email) {
	   
        $r = preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/', $email);
        
        if ($r == 0) {
            $res = '<td><b style="color: red;">Вы ввели не верные символы</b></td>'; 
        } else {
            $res = '';
        }
        return $res;
	}
    
?>