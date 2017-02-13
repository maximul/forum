<div>Добавить новое сообщение:</div>
<form action="<?=$_SERVER["PHP_SELF"]."?tid=$tid&uid=$uid&start=$start"?>" method="post">
    <input type="hidden" name="uid" value="<?=$uid?>" />
    <input type="hidden" name="tid" value="<?=$tid?>" />
    <input type="hidden" name="start" value="<?=$start?>" />
	<div><textarea name="new_msg" cols="80" rows="10"></textarea></div>
    <input type="submit" value="Новое сообщение" />
    <input type="reset" value="Отменить" />
    <input type="button" value="Выйти из форума" onclick="javascript:document.location.href='index.php'" />
</form>