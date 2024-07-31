<?php

namespace brandgage\ecf\models;

use brandgage\ecf\ExpoContactForm;

use Craft;
use craft\base\Model;
use craft\web\UploadedFile;

class ContactFormModel extends Model 
{
    public $fullName;
    public $companyName;
    public $businessEmail;
    public $businessPhoneNumber;
    public $jobTitle;
    public $showsPerYear;
    public $numberOfClients;
    public $contactCountry;
    public $comments;

    protected function defineRules(): array
    {
        $rules = parent::defineRules();
        $rules[] = [['fullName', 'companyName', 'businessEmail', 'businessPhoneNumber', 'jobTitle', 'showsPerYear', 'numberOfClients', 'contactCountry'], 'required'];
        $rules[] = ['comments', 'safe']; 
        return $rules;
    }
}