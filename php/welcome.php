<?php

require_once("db.php");

if(isset($_COOKIE['id']) && isset($_COOKIE['pass'])) {

	$id = $_COOKIE['id'];

	$res = $collection->findOne(['_id' => new MongoDB\BSON\ObjectID($id)]);

	if($res != NULL) {

		if($res['pass'] == $_COOKIE['pass']) {

	        $res = $collection->findOne(['_id' => new MongoDB\BSON\ObjectID($id)]);
        
	        if($res != NULL) {
        
                echo "<h1> Welcome, ".$res['alias']."!</h1>
                <p><a href='log_out.php'>Выйти</a></p>";
	        } else {
	        	header("Location:../index.php");
	        }
	    } else {
	    	setcookie("id", "", time() - 50000); 				
            setcookie("pass", "", time() - 50000);

            header("Location:../index.php");
	    }
	} else {
		setcookie("id", "", time() - 50000); 				
        setcookie("pass", "", time() - 50000);	

        header("Location:../index.php");
	}
} else {
	header("Location:../index.php");
}

?>