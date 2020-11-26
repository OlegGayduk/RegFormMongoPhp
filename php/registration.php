<?php 

require_once("db.php");

if(isset($_POST['login']) && isset($_POST['pass']) && isset($_POST['alias'])) {
	if(strlen($_POST['login']) > 0 && strlen($_POST['login']) <= 40) {

		if(preg_match("/[0-9a-z]+@[a-z]/",$_POST['login'])) {

	        $login = htmlspecialchars($_POST['login']);

	        $res = $collection->findOne(['login' => $login]);

	        if($res != NULL) exit("This login is already taken! <a href='registr.php'>Please come up with new login, return to registration page and try again!</a>");

	        if(strlen($_POST['pass']) >= 8 && strlen($_POST['pass']) <= 40) {
	        	if(strlen($_POST['alias']) > 0 && strlen($_POST['alias']) <= 12) {
	        		
	                $pass = htmlspecialchars($_POST['pass']);

	                $alias = htmlspecialchars($_POST['alias']);

	                $options = ['cost' => 12,];

	                $pass = password_hash($pass,PASSWORD_BCRYPT,$options);

                    $res = $collection->insertOne(['login' => $login,'pass' => $pass,'alias' => $alias]);

                    if($res != false) {

                        $res = $collection->findOne(['login' => $login,'pass' => $pass]);

                        if($res != NULL) {

                            $id = $res['id'];

                            setcookie("id", $id, time() + 36000);
                            setcookie("pass", $pass, time() + 36000);

                            header("Location:welcome.php");

                        } else {
                        	echo "Ошибка при записи! <a href='registr.php'>Please return to registration page and try again!</a>";
                        }
                    } else {
                    	echo "Ошибка при записи! <a href='registr.php'>Please return to registration page and try again!</a>";
                    }
	        	} else {
	        		echo "Alias length is incorrect! <a href='registr.php'>Please return to registration page and try again!</a>";
	        	}
	        } else {
	        	echo "Password length is incorrect! <a href='registr.php'>Please return to registration page and try again!</a>";
	        }
	    } else {
	    	echo "Email format is incorrect! <a href='registr.php'>Please return to registration page and try again!</a>";
	    }
	} else {
		echo "Email length is incorrect! <a href='registr.php'>Please return to registration page and try again!</a>";
	}
} else {
	header("Location:registr.php");
}

?>