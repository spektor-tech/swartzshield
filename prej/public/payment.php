<?php
if(!isset($_GET['order_id']))
{
	header('Location: outro.php');
	die();
}
?>
<?php require_once '../includes/config/default.inc.php'; ?>
<?php require_once '../includes/templates/blocks/header.php'; ?>

<div class="header">
	<img class="shield animate" onload="this.style.opacity='1';" src="img/s_shield-big.png">
	<img class="logo" onload="this.style.opacity='1';" src="img/s_logo-big.png">
</div>

<div class="textbox">
	<div class="wrap">
		<div class="type-wrap">
			<span id="typed" style="white-space:pre;"></span>
			<form action="#" id="formEmailaddress">
				<input type="text" name="emailaddress" id="emailaddress" autocomplete="off">
			</form>
		</div>
	</div>
</div>

<?php
$pdo = Load::PDO();
$q = $pdo->prepare("SELECT mollie_id FROM payments WHERE id = ?");
$q->execute([$_GET['order_id']]);
$res = current($q->fetchAll(PDO::FETCH_ASSOC));

// Update the DB
$mollie = Load::Mollie();
$payment = $mollie->payments->get($res['mollie_id']);

$q = $pdo->prepare("UPDATE payments SET
					modified = NOW(),
					status = ?,
					details = ?
					WHERE id = ?");
$q->execute([
	$payment->status,
	json_encode($payment->details),
	$_GET['order_id']
]);

$q = $pdo->prepare("SELECT * FROM payments WHERE id = ?");
$q->execute([$_GET['order_id']]);
$res = current($q->fetchAll(PDO::FETCH_ASSOC));

if(!is_null($res['email_id']) && ($res['status'] == 'paid' || $res['status'] == 'pending'))
{
	// Send the mail!
	$q = $pdo->prepare("SELECT emailaddress FROM email WHERE id = ?");
	$q->execute([$res['email_id']]);
	$email = current($q->fetchAll(PDO::FETCH_ASSOC));

	Load::SendMail('Payment details',
					$email['emailaddress'],
					'<p>We received your payment!</p>
						<p>This is your payment id, store it safe in a save place. You\'ll need it when you want to contact regarding the payment.<br>'
						. $res['id'] . '/' . $res['mollie_id'] .'</p>
						<p>Thanks again and all the best,<br>S.</p>',
					'A big warm THANK YOU!',
					'This email contains your payment info, keep it safe!');
}
?>

<!-- jQuery -->
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="js/typed.min.js"></script>
<script>
	var payedstatus = '<?php echo $res['status']; ?>';
	var withEmail = <?php echo (is_null($res['email_id']) ? 'false' : 'true'); ?>;
	var paymentId = '<?php echo $res['id'] . '/' . $res['mollie_id']; ?>';
</script>
<script src="js/payment.js"></script>

</body>
</html>