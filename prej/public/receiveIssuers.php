<?php
/**
 * ---------------------------------------------------
 * Created by Jason de Ridder <mail@deargonauten.com>.
 * ---------------------------------------------------
 * File: receiveIssuers.php                                
 * Date: 16-06-15                                      
 * Time: 23:15
 */

if($_SERVER['REQUEST_METHOD'] == 'GET')
{
	require_once '../includes/config/default.inc.php';
	$mollie = Load::Mollie();
	$issuers = $mollie->issuers->all();

	$i = [];
	foreach($issuers as $k => $v)
	{
		array_push($i, $v);
	}

	header('application/json');
	die(json_encode($i));

}