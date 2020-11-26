<?php

require_once("db.php");

if(isset($_POST['login'])) {
	if(strlen($_POST['login']) > 0 && strlen($_POST['login']) <= 40) {
		if(preg_match("/[0-9a-z]+@[a-z]/",$_POST['login'])) {

			$login = htmlspecialchars($_POST['login']);

			$res = $collection->findOne(['login' => $login]);

			if($res != NULL) {

				if(isset($_COOKIE['recovery_code']) && isset($_COOKIE['email'])) exit("Letter has already been sent to this email! Please, try again later!");

				$code = '';

                $arr = array(
                	'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 
                	'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 
                	'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 
                	'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 
                	'1', '2', '3', '4', '5', '6', '7', '8', '9', '0'
                );
 
	            for ($i = 0; $i < 16; $i++) {
	            	$code .= $arr[random_int(0, count($arr) - 1)];
	            }

	            $res = mail($_POST['login'], "Password recovery request", "To recover your password, follow the link localhost:81/lab2MySql/php/restoration_check.php?code=$code&mail=".$_POST['login']);

	            if($res != false) {

	               $options = ['cost' => 12,];

	               $hashed_code = password_hash($code,PASSWORD_BCRYPT,$options);
	               $hashed_mail = password_hash($_POST['login'],PASSWORD_BCRYPT,$options);

	               setcookie("email", $hashed_mail, time() + 1800);
	               setcookie("recovery_code", $hashed_code, time() + 1800);

	               echo "A letter has been sent to the mailbox!";
	            } else {
	            	echo "There was an error sending your email! <a href='recovery.php'>Please return to recovery page and try again!</a>";
	            }
			} else {
				echo "No such user found! <a href='recovery.php'>Please return to recovery page and try again!</a>";
			}

		} else {
			echo "Email format is incorrect! <a href='recovery.php'>Please return to recovery page and try again!</a>";
		}
	} else {
		echo "Email length is incorrect! <a href='recovery.php'>Please return to recovery page and try again!</a>";
	}
} else {
	header("Location:recovery.php");
}

?>