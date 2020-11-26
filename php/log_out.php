<?php

setcookie("id", "", time() - 36000);
setcookie("pass", "" , time() - 36000);

header("Location: ../index.php");

?>