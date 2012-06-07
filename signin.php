<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Мир через видоискатель</title>
<link rel="stylesheet" type="text/css" href="styles/styles.css" />
</head>
<?php
session_start();
$db = mysql_connect("localhost", "root", "106") or die(mysql_error());
//$db = mysql_connect("database", "andik128", "Ttm7mZj9") or die(mysql_error());
//mysql_select_db("andik128",$db) or die(mysql_error());
mysql_select_db("blog",$db) or die(mysql_error());
?>
<body>

<div class="wrapper">
<div class="header"></div>

<div class="content">
	<form action="" method="post" name="signin">
		<ul class="registration">
			<li>
            	<label> Login <input type="text" name="Login" value="Введите логин" />
				</label>
            </li>
			<li>
            	<label> Password <input type="password" name="pass" /> </label>
            </li>
			<li class="button_reg">
            	<input type="submit" name="Submit" value="Регистрация" />
            </li>
    		<li>
            	<a href="index.php"> Вернуться на гланвную страницу </a>
             </li>
 		</ul>
	</form>
<?php if(isset($_POST["Submit"])) {
	if((trim($_POST["Login"])!="")&(trim($_POST["pass"])!='')){
		$result = mysql_query("SELECT u.id, u.name FROM blog_users u ") or die(mysql_error());
		$exist=false;
		while ($row = mysql_fetch_array($result)){
			if($row["name"]==trim($_POST["Login"])){
				$exist=true;
				breack;
			}
		}
		if($exist==true){
			echo "Логин занят другим пользователем.";
		}
		else{
			mysql_query("INSERT INTO blog_users SET name='".trim($_POST["Login"])."', pass='".$_POST["pass"]."', messages=0") or die(mysql_error());
			$_SESSION["name"]=trim($_POST["Login"]);
			$result = mysql_query("SELECT u.id FROM blog_users u WHERE u.name='".$_POST["Login"]."'") or die(mysql_error());
			$row=mysql_fetch_array($result);
			$_SESSION["id"]=$row["id"];
			echo " Вы успешно зарегестрированы<br />";
		}
	}
}?>

</div>








<div class="footer"></div>
</div>
</body>
</html>
