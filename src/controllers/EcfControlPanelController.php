<?php
/**
 * ecf plugin for Craft CMS 5.x
 *
 * Expo Contact Form
 *
 * @link      brandgage.com
 * @copyright Copyright (c) 2022 lreid@brandgage.com
 */

namespace brandgage\ecf\controllers;

use Craft;
use craft\elements\Entry;
use craft\web\Controller;
use craft\services\Fields;
use craft\helpers\Json;
use craft\helpers\App;

class EcfControlPanelController extends Controller
{
    public function actionIndex()
	{
		#TODO RUN CONFIG TEST / LOOKUPS
		$mandrilKey = App::env('MANDRILL_API_KEY') ?? '';
		$mandrilSubAccount = App::env('MANDRILL_SUB_ACCOUNT') ?? '';
		$mailer = craft\helpers\App::mailSettings()->transportType;

		$params= [
			'mailKey' => $mandrilKey,
			'subAccount' => $mandrilSubAccount,
			'mailer'=> $mailer,
		];

		return $this->renderTemplate('ecf/pages/home', $params);
	}
}