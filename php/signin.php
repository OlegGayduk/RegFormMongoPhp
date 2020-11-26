<?php

require_once("db.php");

if(isset($_POST['login']) && isset($_POST['pass'])) {
	if(strlen($_POST['login']) > 0 && strlen($_POST['login']) <= 40) {
	    if(strlen($_POST['pass']) > 0 && strlen($_POST['pass']) <= 40) {

	        $login = htmlspecialchars($_POST['login']);
	        $pass = htmlspecialchars($_POST['pass']);

	        $res = $collection->findOne(['login' => $login]);

	        if($res != NULL) {

	        	if(password_verify($pass, $res['pass'])) {

	        		$id = $res['_id'];

	        		$options = ['cost' => 12,];

	                $pass = password_hash($pass,PASSWORD_BCRYPT,$options);

                    $res = $collection->updateOne(['_id' => $id],['$set' => ['pass' => $pass]]);

                    if($res != false && $res->getMatchedCount() > 0 && $res->getModifiedCount() > 0) {

                        setcookie("id", $id, time() + 36000);
                        setcookie("pass", $pass, time() + 36000);
    
	        	        header("Location:welcome.php");
	        	    } else {
	        	    	echo "Something went wrong... <a href='../index.php'>Please return to main page and try again!</a>";
	        	    }
	        	} else {
	        		echo "No such user found! <a href='../index.php'>Please check your credentials and try again!</a>";
	        	}
	        } else {
	        	echo "No such user found! <a href='../index.php'>Please check your credentials and try again!</a>";
	        }
	    } else {
	    	echo "Password length is incorrect! <a href='../index.php'>Please return to main page and try again!</a>";
	    }
	} else {
		echo "Email length is incorrect! <a href='../index.php'>Please return to main page and try again!</a>";
	}
} else {
	header("Location:../index.php");
}

?>