<?php
    function getConnection() {
    	$dbhost="localhost";
    	$dbuser="root";
    	$dbpass="Toda#Facil%";
    	$dbname="school_db";

    	$dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    	$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	return $dbConnection;
    }
?>
