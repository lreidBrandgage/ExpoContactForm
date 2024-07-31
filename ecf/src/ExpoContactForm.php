<?php

namespace brandgage\ecf;

use Craft;
use brandgage\ecf\models\Settings;

use craft\base\Model;
use craft\base\Plugin as BasePlugin;

use craft\services\Plugins;
use craft\events\PluginEvent;

use craft\web\UrlManager;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

use craft\events\RegisterUrlRulesEvent;

use Psr\Log\LogLevel;
use craft\log\MonologTarget;
use Monolog\Formatter\LineFormatter;


use yii\base\Event;
/**
 * photo_activity plugin
 *
 * @method static Plugin getInstance()
 * @method Settings getSettings()
 */
class ExpoContactForm extends BasePlugin
{	
	public string $schemaVersion = '1.0.0';
	public bool $hasCpSection = true;

	public function getName(){
		return Craft::t('Expo Contact Form','');
	}

	public static function config(): array
	{
		return [
			'components' => [
				// Define component configs here...
			],
		];
	}
	public function init(): void
	{
		$this->setComponents([
			'ecf' => \brandgage\ecf\services\EcfService::class,
			'email' => \brandgage\ecf\services\EmailService::class,
		]);

		parent::init();
		// Defer most setup tasks until Craft is fully initialized
		Craft::$app->onInit(function() {
			$this->attachEventHandlers();
			// ...
		});

		Event::on(
			UrlManager::class,
			UrlManager::EVENT_REGISTER_SITE_URL_RULES,
			function (RegisterUrlRulesEvent $event) {
				$event->rules['siteActionTrigger1'] = 'ecf/default';
			}
		);
		Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['ecf/'] = 'ecf/ecf-control-panel';
            }
        );
		Event::on(
			Plugins::class,
			Plugins::EVENT_AFTER_INSTALL_PLUGIN,
			function (PluginEvent $event) {
				if ($event->plugin === $this) {
				}
			}
		);
		Craft::info(
			Craft::t(
				'ecf',
				'{name} plugin loaded',
				['name' => $this->name]
			),
			__METHOD__
		);
	}

	private function attachEventHandlers(): void
	{
		// Register event handlers here ...
		// (see https://craftcms.com/docs/4.x/extend/events.html to get started)
	}

	protected function createSettingsModel(): ?Model
	{
		return Craft::createObject(Settings::class);
	}

	protected function settingsHtml(): ?string
	{
		return Craft::$app->view->renderTemplate('ecf/_settings.twig', [
			'plugin' => $this,
			'settings' => $this->getSettings(),
		]);
	}
}