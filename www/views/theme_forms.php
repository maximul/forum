<div>Открыть новую тему:</div>
<form action="<?=$_SERVER["PHP_SELF"]."?start=$start"?>" method="post">
    <input type="hidden" name="uid" value="<?=$uid?>" />
    <input type="hidden" name="start" value="<?=$start?>" />
	<div><textarea name="new_theme" cols="80" rows="3"></textarea></div>
    <input type="submit" value="Новая тема" />
    <input type="reset" value="Отменить" />
    <input type="button" value="Выйти из форума" onclick="javascript:document.location.href='index.php'" />
</form>