<?php
/**
 * ---------------------------------------------------
 * Created by Jason de Ridder <mail@deargonauten.com>.
 * ---------------------------------------------------
 * File: saveEmailaddress.php                                
 * Date: 16-06-15                                      
 * Time: 14:54
 */

if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['ea']))
{
	require_once '../includes/config/default.inc.php';

	// Check validity of emailaddress
	if(!filter_var($_GET['ea'], FILTER_VALIDATE_EMAIL))
	{
		header('Content-Type: application/json');
		die(json_encode('false'));
	}

	// Check for MX
	$domain = explode('@', $_GET['ea']);
	$domain = end($domain);
	if(!checkdnsrr($domain, 'MX'))
	{
		header('Content-Type: application/json');
		die(json_encode('false'));
	}

	// Emailaddress okay. Save to DB
	$PDO = Load::PDO();
	$q = $PDO->prepare("INSERT INTO email (emailaddress, added) VALUES (:email, NOW())");
	$q->bindParam(':email', $_GET['ea']);
	$q->execute();

	// Assuming correct email - to let the app go further
	header('Content-Type: application/json');
	die(json_encode('true'));
} else {
	header('Content-Type: text/html', 404);
	die('<h1>404 - Page not found</h1>');
}