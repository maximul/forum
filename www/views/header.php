<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title><?=$header?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/style.css"/>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript">
        $(function(){
            var pathname = window.location.pathname;
            var i = 0;
            if (pathname == '/')
            	pathname = '/index.php';
            while($("ul li a").eq(i).attr('href') != null){
                if ($("ul li a").eq(i).attr('href') == pathname.replace('/','')) {
                    $("ul li a").eq(i).addClass("active");
                    $("ul li a").eq(i).parent().addClass("active");
                }
                i++;
            }         
        });
    </script>
</head>
<body>
    <div id="header-new">
        <div class="header-content">
            <div class="navigation"><?php drawMenu($topMenu)?></div>
        </div>
    </div>
    <div>            
        <div class="container" align="center">