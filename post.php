<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
session_start();
$db = mysql_connect("localhost", "root", "106") or die(mysql_error());
//$db = mysql_connect("database", "andik128", "Ttm7mZj9") or die(mysql_error());
//mysql_select_db("andik128",$db) or die(mysql_error());
mysql_select_db("blog",$db) or die(mysql_error());

$label_login="Введите логин";

if(isset($_POST["Submit"])){
	$result = mysql_query("SELECT u.id, u.pass FROM blog_users u WHERE u.name='".$_POST["Login"]."'") or die(mysql_error());
	$row=mysql_fetch_array($result);
	if(($_POST["pass"]==$row["pass"])&(trim($_POST["pass"])!='')){
		$_SESSION["name"]=$_POST["Login"];
		$_SESSION["id"]=$row["id"];
	}
	else{
    	$label_login="неправильный логин или пароль";
	}
}
if(isset($_POST["Logout"])){
	unset($_SESSION["name"]);
	unset($_SESSION["id"]);
}

if(isset($_POST["com_submit"])){
	$resultm=mysql_query("SELECT messages FROM blog_users WHERE id=".$_SESSION["id"]);
	$rowm=mysql_fetch_array($resultm);
	$mes=$rowm["messages"];
	$mes=$mes+1;
	$resultm=mysql_query("UPDATE blog_users SET messages=".$mes." WHERE id=".$_SESSION["id"]);
	$q="INSERT INTO blog_comment SET comment='".trim($_POST["comment"])."', user_id=".$_SESSION["id"].", post_id=".$_POST["post_id"];
	$resultU=mysql_query($q) or die(mysql_error());
	unset($_POST["com_submit"]);
}

if(isset($_POST["post_submit"])){
	$q="INSERT INTO blog_posts SET post='".trim($_POST["post"]."'");
	$resultP=mysql_query($q) or die(mysql_error());
	unset($_POST["post_submit"]);
}
?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Мир через видоискатель</title>
<link rel="stylesheet" type="text/css" href="styles/styles.css" />
</head>
<body>
<div class="wrapper">
	<div class="header">
    	<div class="regist_form">
        	<form action="" method="post" name="registration"><?php if(!isset($_SESSION["name"])){ ?>
        	<ul class="first">
            	<li>
                	<label>
                    	Name
                    	<input type="text" name="Login" value="<?php echo $label_login;?>" /> 
                    </label>    
                </li>
                <li>
                	<label>
                    	Password
                    	<input type="password" name="pass" /> 
                    </label>    
                </li>
                <li class="buttons">
               		<a href="signin.php">Регистрация</a>
                	<input type="submit" name="Submit" value="Вход" />
                </li>
                <?php } else {?>
                <li class="buttons">
                	<p>Hello <span><?php echo $_SESSION["name"]; ?></span></p>
                    <input type="submit" name="Logout" value="Выход" />
                </li>
                <?php } ?>
            </ul>
            </form>    
        </div>
    </div>
    
    
    <div class="content">
    <?php if($_SESSION["name"]=='root'){ ?>
    	<div class="new_post">
        	<form action="" method="post" name="post">
        		<textarea name="post" rows="1" cols="1"></textarea>
                <input type="submit" name="post_submit" value="Опубликовать" />
            </form>    
        </div>  
    <?php } ?>
 <?php 
$result = mysql_query("SELECT p.post FROM blog_posts p WHERE p.id=".$_GET["id"]) or die(mysql_error());

$row=mysql_fetch_array($result);
	?>       
        
        <ul class="old_post">
        	<li>
            	<p>
                   <?php echo $row["post"]; ?>
                </p>

                <ul class="comentu">
					<?php 
						$resultc = mysql_query("SELECT c.user_id, c.id, c.comment FROM blog_comment c WHERE post_id=".$_GET["id"]) or die(mysql_error());
						while ($rowc=mysql_fetch_array($resultc)){
							$resultn=mysql_query("SELECT name FROM blog_users WHERE id=".$rowc["user_id"]);
							$rown=mysql_fetch_array($resultn);
							$result_m=mysql_query("SELECT messages FROM blog_users WHERE id=".$rowc["user_id"]);
							$row_m=mysql_fetch_array($result_m);
							$mes_u=$row_m["messages"];
					?>
                	<li>
                    	<p class="name"><?php echo $rown["name"];?>(<?php echo $mes_u;?>)</p>
                    	<p class="sam_coment">
                        	<?php echo $rowc["comment"]; ?>
                        </p>
                    </li>
                		<?php } ?>
                </ul>
               <?php if(isset($_SESSION["name"])){?>
               <div class="send_coment">
               <form action="" method="post" name="comment">
               		<textarea name="comment" rows="1" cols="1"></textarea>
               		<input type="hidden" name="post_id" value="<?php echo $_GET['id'];?>" />
                    <input type="submit" name="com_submit" value="Комментировать" class="" />
               </form>	
               </div>
               <?php }?>
               <a href="index.php" class="back">на главную страницу</a>
            </li>
            
        </ul>

        
        
        
    </div>
    <div class="footer">
		<p class="f_l f_f">ANDIK1212 blog </p>
		<p class="f_r f_f">Andik ©2012</p>
	</div>
</div>
</body>
</html>
