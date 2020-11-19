<?php

setcookie("id", "", time() - 50000);
setcookie("pass", "" , time() - 50000);

header("Location: ../index.php");

?>