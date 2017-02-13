<div align="center">
<form action="registration.php" method="post">
	<table border="0" width="650" align="center">
		<?php drawReg($registration, $user, $mail, $res)?>
	</table>
    <input type="submit" value="Вход" />
    <input type="reset" value="Очистить" />
    <input type="button" value="Выйти" onclick="javascript:document.location.href='index.php'" />
</form></div>
<?php if ($resultat): ?>
    <script type="text/javascript">
        alert('Регистрация прошла успешно!');
        document.location.href='themes.php';
    </script>
<?php endif ?>