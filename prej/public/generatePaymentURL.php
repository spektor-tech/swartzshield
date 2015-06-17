<?php
/**
 * ---------------------------------------------------
 * Created by Jason de Ridder <mail@deargonauten.com>.
 * ---------------------------------------------------
 * File: generatePaymentURL.php                                
 * Date: 17-06-15                                      
 * Time: 11:28
 */

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['amount']) && isset($_POST['method']))
{
	if(!is_numeric($_POST['amount']) || $_POST['amount'] < 5)
		endRequest(false, 'amount');

	$method = strtolower($_POST['method']);
	$allowed_methods = ['creditcard', 'bitcoin', 'ideal', 'paypal'];

	if(!in_array($method, $allowed_methods))
		endRequest(false, 'method');

	require_once '../includes/config/default.inc.php';
	$mollie = Load::Mollie();

	if($method == 'ideal')
	{
		if( !isset($_POST['issuer']) )
			endRequest(false, 'issuer');

		$issuerId = $_POST['issuer'] - 1;

		// Get list
		$issuers = $mollie->issuers->all();
		if($issuerId < 0 || $issuerId >= count($issuers))
		endRequest(false, 'issuer');

	}

	// All checks are done. On this point we can generate URL
	$pdo = Load::PDO();
	$email_id = false;


	// Check for email
	if(isset($_POST['emailaddress']))
	{
		$res = $pdo->prepare("SELECT id FROM email WHERE emailaddress = ?");
		$res->execute([$_POST['emailaddress']]);
		$res = $res->fetchAll(PDO::FETCH_ASSOC);
		if(count($res) > 0) {
			$email_id = $res[0]['id'];
		} else {
			$q = $pdo->prepare("INSERT INTO email (emailaddress, added) VALUES (?, NOW())");
			$q->execute([$_POST['emailaddress']]);

			$email_id = $pdo->lastInsertId();
		}
	}

	$q = $pdo->prepare("INSERT INTO payments (email_id, amount, method, issuer, description, created, modified) VALUES (:email_id, :amount, :method, :issuer, :description, NOW(), NOW())");
	$q->bindValue(':email_id', (!$email_id ? null : $email_id), (!$email_id ? PDO::PARAM_NULL : PDO::PARAM_INT));

	$amount = floatval($_POST['amount'] . '.00');
	$q->bindValue(':amount', $amount);

	$q->bindValue(':method', $_POST['method']);
	$q->bindValue(':issuer', isset($_POST['issuer']) ? $issuers[$issuerId]->name : null, isset($_POST['issuer']) ? PDO::PARAM_STR : PDO::PARAM_NULL);

	$q->bindValue(':description', 'Supporting the Swartzshield cause');

	$q->execute();

	$lID = $pdo->lastInsertId();

	$data = [
		'amount' => $amount,
		'description' => 'Supporting the Swartzshield cause',
		'redirectUrl' => 'http://' . $_SERVER['HTTP_HOST'] . '/prej/public/payment.php?order_id=' . $lID,
		//'webhookUrl' => 'http://' . $_SERVER['HTTP_HOST'] . '/updatePayment.php',
		'metadata'	=> [
			'order_id' => $lID
		],
		'method' => $method
	];

	if(isset($_POST['issuer']))
		$data['issuer'] = $issuers[$issuerId]->id;


	$p = $mollie->payments->create($data);

	$q = $pdo->prepare("UPDATE payments SET
								mode = :mode,
								mollie_id = :mollie_id,
								status = :status,
								modified = NOW(),
								expiry = :expiry");
	$q->bindParam(':mode', $p->mode);
	$q->bindParam(':mollie_id', $p->id);
	$q->bindParam(':status', $p->status);
	$q->bindParam(':expiry', $p->expiredDatetime);

	$q->execute();

	// All saved!
	endRequest(true, $p->getPaymentUrl());
}
endRequest();


function endRequest($result = false, $reason = '')
{
	header('Content-Type: application/json');
	die(json_encode(['result' => $result, 'reason' => $reason]));
}