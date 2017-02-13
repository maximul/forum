<div align="center">
<form action="settings.php" method="post">
	<table border="0" width="650" align="center">
		<?php drawSettings($settings, $user, $mail, $res)?>
	</table>
    <input type="submit" value="Сохранить" />
    <input type="button" value="Выйти" onclick="javascript:document.location.href='index.php'" />   
</form>
</div>