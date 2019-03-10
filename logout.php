<?php

// Cikis sayfasi

// Guvenlik
define("rs", true);


// oturum baslat
session_start();


// oturumu sil
session_destroy();


//print "You've been logged out";
header("Location: http://megam.cf/index.php");




