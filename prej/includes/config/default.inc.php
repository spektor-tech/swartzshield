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
		global $config;
		require_once dirname(__FILE__) . '/../libs/vendor/autoload.php';
		$c = new Mollie_API_Client;


		$c->setApiKey($config['mollie']['key']);
		return $c;

	}

	public static function PDO()
	{
		global $config;
		// Start a new PDO connection
		return new PDO(	$config['pdo']['dsn'],
						$config['pdo']['user'],
						$config['pdo']['pass']);
	}

	public static function SendMail($subject, $to, $body, $title, $pretitle = '')
	{
		global $config;

		if(strlen($pretitle) == 0) $pretitle = $subject;

		$template = file_get_contents(dirname(__FILE__) . '/../templates/email.php');
		$template = str_replace('*|PRETITLE|*', $pretitle, $template);
		$template = str_replace('*|TITLE|*', $title, $template);
		$template = str_replace('*|BODY|*', $body, $template);

		$transport = Swift_SmtpTransport::newInstance($config['mail']['host'], $config['mail']['port'], 'ssl')
			->setUsername($config['mail']['username'])
			->setPassword($config['mail']['password']);
//		$transport = Swift_MailTransport::newInstance();
//		$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');

		$mailer = Swift_Mailer::newInstance($transport);

		$message = Swift_Message::newInstance($subject)
			->setFrom(array('no-reply@swartzshield.com' => 'Swartzshield'))
			->setTo($to)
			->setBody($template, 'text/html')
			->setSender('info@spektor.nl')
			//->setContentType('text/html; charset=utf-8')
			->setReplyTo(['info@spektor.nl' => 'Spektor Storytelling']);

		return $mailer->send($message);
	}
}