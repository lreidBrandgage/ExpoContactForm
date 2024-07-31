<?php
/**
 * Expo Contact Form for Craft CMS 5
 *
 *
 * @link      brandgage.com
 * @copyright Copyright (c) 2022 lreid@brandgage.com
 */

namespace brandgage\ecf\services;

use brandgage\ecf\ExpoContactForm;

use Craft;
use craft\base\Component;
use craft\elements\User;
use craft\services\ProjectConfig;

/**
 * @author    lreid@brandgage.com
 * @package   ExpoScheduler
 * @since     1.0.0
 */
class EmailService extends Component
{
	public function _sendEmail($to, string $subject, string $html, $attachments = [], $headers = null): bool{
		$mailer = Craft::$app->getMailer();
		// Set X-MC-InlineCss header so Mandrill will convert css to inline as it's neccessary for email
		try {
			$result = $mailer->compose()
				->setTo($to)
				->setSubject($subject)
				->addHeader('X-MC-InlineCss', true)
				->setHtmlBody($html)
				->send();
			return $result;
		}catch(\Mandrill_error $error) {
			throw $error;
		}
	}
}