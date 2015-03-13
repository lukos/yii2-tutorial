<?php

namespace app\components;

use yii\i18n\MissingTranslationEvent;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TranslationEventHandler
{
    public static function handleMissingTranslation(MissingTranslationEvent $event) {
        if (YII_ENV_DEV) {
            $event->translatedMessage = "@MISSING: {$event->category}.{$event->message} FOR LANGUAGE {$event->language} @";
        }
    }
}