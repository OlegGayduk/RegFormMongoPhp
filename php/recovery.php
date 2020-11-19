<?php

if(isset($_COOKIE['id']) && isset($_COOKIE['pass'])) header('Location: welcome.php');

?>

<!DOCTYPE html>
<html>
<head>
	<title>Восстановление</title>
	<link rel='stylesheet' type='text/css' href='../css/index.css'/>
</head>
<body>

	<div class="recover-container">
        <p class='come'>Recovery</p>
        <form class="main-form" method="POST" action="restoration.php"> 
            <p><label class="login-text">Ваш Email: </label>
            <input class="login-field" name="login" type="email" size="40" maxlength="40" /></p> 
            <p><input class="recover-btn" type="submit" value="Выслать новый пароль"></p> 
            <p><a class="recover-index" href='../index.php'>На главную</a></p>
        </form>
	</div>

</body>
</html>