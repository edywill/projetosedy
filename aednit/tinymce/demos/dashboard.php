<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript" src="tinymce/nicEdit.js"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>
</head>

<body>
<?php require("conect.php"); 
    $sqlMsg = "SELECT * FROM dashboard WHERE id=1";
    $queryMsg = mysql_query($sqlMsg) or die(mysql_error());
	$consDash = mysql_fetch_array($queryMsg);
?>
<form action="dashUp.php" method="post" name="dash">
  <h1>Dashboard DECO - CPB </h1>
  <input name="atualizar" type="submit" value="Atualizar Quadros" /><br />
  <textarea name="dash" id="dash" cols="70" rows="30"><?php echo mb_convert_encoding($consDash['msg1'], "UTF-8"); ?></textarea>
  <textarea name="dash2" cols="70" rows="30"><?php echo mb_convert_encoding($consDash['msg2'], "UTF-8"); ?></textarea>
</form>
</body>
</html>