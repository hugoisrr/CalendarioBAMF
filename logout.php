<?php

ob_start();

session_start();

session_unset();

session_destroy();

mysql_close();

header('Location: index.php');

exit();

ob_end_flush();

?>