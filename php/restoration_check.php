<!DOCTYPE html>
<html>
<head>
	<title>Восстановление пароля</title>
	<link rel='stylesheet' type='text/css' href='../css/index.css'/>
</head>
<body>

    <?php 

    if(isset($_GET['code'])) {
        if(isset($_COOKIE['recovery_code']) && isset($_COOKIE['email'])) {
    
        	$code = htmlspecialchars($_GET['code']);

        	if(password_verify($code, $_COOKIE['recovery_code'])) {
        		echo "<div class='pass-container-recovery'>
    			<p class='come'>Password recovery</p>
     			<form class='main-form' method='POST' action='restoration_pass.php'> 
                    <p><label class='pass-text-recovery'>Новый пароль: </label>
                    <input class='pass-field-recovery' name='pass' type='password' size='40' minlength='8' maxlength='40' /></p> 
                    <p><label class='pass-text-recovery-repeat'>Повторите пароль: </label>
                    <input class='pass-field-recovery-repeat' name='pass_repeat' type='password' size='40' minlength='8' maxlength='40' /></p>
                    <p><input class='pass-btn-recovery' type='submit' value='Восстановить пароль'></p> 
                    <p><a class='pass-index-recovery' href='../index.php'>На главную</a></p>
                </form>
                </div>";
        	} else {
        		echo "Link is not correct! <a href='recovery.php'>Please, try again!</a>";
        	} 
        } else {
        	echo "Link is expired! <a href='recovery.php'>Please, try again!</a>";
        }
    } else {
    	echo "Link is expired! <a href='recovery.php'>Please, try again!</a>";
    }
    
    ?>

</body>
</html>

