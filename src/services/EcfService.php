<?php
/**
 * Expo Contact Form plugin for Craft CMS 5.x
 *
 *
 * @link      brandgage.com
 * @copyright Copyright (c) 2022 lreid@brandgage.com
 */

namespace brandgage\ecf\services;

use brandgage\ecf\ExpoContactForm;

use Craft;
use craft\base\Component;
use craft\models\Site;
use craft\elements\Entry;
use craft\elements\Sections;
use craft\elements\MatrixBlock;
use craft\elements\User;
use craft\helpers\ElementHelper;
use craft\web\UploadedFile;
use craft\elements\Asset;
use craft\helpers\Assets;
/**
 * @author    lreid@brandgage.com
 * @package   ExpoContactForm
 * @since     1.0.0
 */
class EcfService extends Component
{   
    public function saveContact($model){
        $elementService = Craft::$app->getElements();

        $entry = new Entry();
        $entry->sectionId = Craft::$app->entries->getSectionByHandle('contactForm')->id;
        $entry->title=$model->fullName;
        $entry->setFieldValues([
            'fullName' => $model['fullName'],
            'companyName' => $model['companyName'],
            'businessEmail' => $model['businessEmail'],
            'businessPhoneNumber' => $model['businessPhoneNumber'],
            'jobTitle' => $model['jobTitle'],
            'showsPerYear' => $model['showsPerYear'],
            'numberOfClients' => $model['numberOfClients'],
            'contactCountry' => $model['contactCountry'],
            'comments' => $model['comments'],
        ]);

        if(!$elementService->saveElement($entry)){
            return false;
        }
        
        return true;
    }
}