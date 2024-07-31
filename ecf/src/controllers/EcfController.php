<?php

namespace brandgage\ecf\controllers;

use brandgage\ecf\ExpoContactForm;

use Craft;
use craft\web\Controller;
use craft\web\UploadedFile;
use craft\elements\User;
use craft\elements\Entry;
use craft\web\View;
use c10d\craftrecaptcha\CraftRecaptcha;
use brandgage\ecf\models\ContactFormModel;

class EcfController extends Controller{

	protected array|bool|int $allowAnonymous = true;

	public function actionContactSubmit(){
		$this->requirePostRequest();
		$model = new ContactFormModel();
		$model->load(Craft::$app->request->getBodyParams(), '');

		if(!$model->validate()){
			Craft::$app->getUrlManager()->setRouteParams([
				'entry' => $model,
			]);
			return null;
		}

		$success = ExpoContactForm::getInstance()->ecf->saveContact($model);

		if(!$success){
			$this->setFailFlash(Craft::t('ecf', 'Failed to Save'));
			return null;
		}

		$marketingEmails = User::find()
		->group('marketingRecipient')
		->all();
		$to = [];
		foreach($marketingEmails as $email){
			array_push($to, $email);
		}
		$subject = 'Expo Scheduler Marketing interest Request';

		$form = Entry::find()->section('contactForm')->orderBy('postDate DESC')->one();

		Craft::$app->view->setTemplateMode(View::TEMPLATE_MODE_CP);
		$html = Craft::$app->view->renderTemplate('ecf/_email/form_submit', ['model'=>$form]);

		$emailSent = ExpoContactForm::getInstance()->email->_sendEmail($to, $subject, $html);
		if(!$emailSent){
            $this->setFailFlash(Craft::t('ecf', 'Failed to Save'));
            return null;
        }

		return null;
	}
}