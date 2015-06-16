<?php
/**
 * ---------------------------------------------------
 * Created by Jason de Ridder <mail@deargonauten.com>.
 * ---------------------------------------------------
 * File: default.inc.php                                
 * Date: 16-06-15                                      
 * Time: 12:35
 */
session_start();

$config = include_once 'config.inc.php';

class Load {
	public static function Mollie()
	{
		require_once 'libs/Mollie/API/Autoloader.php';
		return new Mollie_API_Client;
	}

	public static function PDO()
	{
		// Start a new PDO connection
	}
}