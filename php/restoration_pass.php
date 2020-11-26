<?php

require_once("db.php");

if(isset($_COOKIE['recovery_code']) && isset($_COOKIE['email'])) {
	
    $code = $_COOKIE['recovery_code'];
	$mail = $_COOKIE['email'];

    if(isset($_POST['pass']) && isset($_POST['pass_repeat'])) {
    	if((strlen($_POST['pass']) >= 8 && strlen($_POST['pass']) <= 40) && (strlen($_POST['pass_repeat']) >= 8 && strlen($_POST['pass_repeat']) <= 40)) {
            if($_POST['pass'] == $_POST['pass_repeat']) {
	          	$pass = htmlspecialchars($_POST['pass']);

	          	$options = ['cost' => 12,];

	            $pass = password_hash($pass,PASSWORD_BCRYPT,$options);

                $res = $collection->updateOne(['login' => $mail],['$set' => ['pass' => $pass]]);

                if($res != NULL) {

                    $res = $collection->findOne(['login' => $mail]);
                    
                    if($res != NULL) {

                    	setcookie("recovery_code", "", time() - 600);
                    	setcookie("email", "", time() - 600);

                    	setcookie("id", $res['_id'], time() + 36000);
                        setcookie("pass", $pass, time() + 36000);

                        header("Location:welcome.php");
                    } else {
                    	echo "Что то пошло не так... <a href='restoration_check.php?code=$code'> Вернитесь назад и повторите попытку!</a>";
                    }
                } else {
                	echo "Что то пошло не так... <a href='restoration_check.php?code=$code'> Вернитесь назад и повторите попытку!</a>";
                }
            } else {
            	echo "Пароли не совпадают! <a href='restoration_check.php?code=$code'> Вернитесь назад и повторите попытку!</a>";
            }
        } else {
        	echo "Неверные длины паролей! <a href='restoration_check.php?code=$code'> Вернитесь назад и повторите попытку!</a>";
        }
    } else {
    	header("Location: recovery.php");
    }
} else {
	header("Location: recovery.php");
}

?>