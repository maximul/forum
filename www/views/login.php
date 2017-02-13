<?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
    <?php if (isset($error)): ?>
    	<p style="color: red;"><b><?=$error?></b></p>
    <?php endif ?>
<?php endif ?>
<div align="center">
<form action="login.php" method="post">
	<table border="0" width="650" align="center">
		<tr>
			<td align="right"><b>e-mail:</b></td>
			<td><input type="text" name="email" autofocus required/></td>
		</tr>
		<tr>
			<td align="right"><b>Пароль:</b></td>
			<td><input type="password" name="u_psw" required /></td>
		</tr>
        <tr>
			<td align="right"><b>Запомнить на месяц:</b></td>
            <td><input type="checkbox" name="u_check" /></td>
        </tr>
	</table>
    <input type="submit" value="Вход" />
    <input type="reset" value="Очистить" />
    <input type="button" value="Выйти" onclick="javascript:document.location.href='index.php'" />   
</form>
<p>Если вы не зарегистрированы, то вам необходимо пройти <a href="registration.php">регистрацию</a>.</p>
</div>