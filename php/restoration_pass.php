<?php

require_once("db.php");

if(isset($_GET['code']) && isset($_GET['mail'])) {
    if(isset($_COOKIE['recovery_code']) && isset($_COOKIE['mail'])) {

        $code = htmlspecialchars($_GET['code']);
        $mail = htmlspecialchars($_GET['mail']);

        if(password_verify($code, $_COOKIE['recovery_code']) && password_verify($mail, $_COOKIE['mail'])) {

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
        
                            	setcookie("recovery_code", "", time() - 1800);
                            	setcookie("email", "", time() - 1800);
        
                            	setcookie("id", $res['_id'], time() + 36000);
                                setcookie("pass", $pass, time() + 36000);
        
                                header("Location:welcome.php");
                            } else {
                                echo "Something went wrong... <a href='restoration_check.php?code=$code&mail=$mail'> Please, return back and try again!</a>";
                            }
                        } else {
                            echo "Something went wrong... <a href='restoration_check.php?code=$code&mail=$mail'> Please, return back and try again!</a>";
                        }
                    } else {
                        echo "Password don't match! <a href='restoration_check.php?code=$code&mail=$mail'> Please, return back and try again!</a>";
                    }
                } else {
                    echo "Incorrect passwords lengths! <a href='restoration_check.php?code=$code&mail=$mail'> Please, return back and try again!</a>";
                }
            } else {
            	header("Location: recovery.php");
            }
        } else {
            echo "The link is incorrect! <a href='restoration_check.php?code=$code&mail=$mail'> Please, return back and try again!</a>";
        }
    } else {
        header("Location: recovery.php");
    }
} else {
	header("Location: recovery.php");
}

?>