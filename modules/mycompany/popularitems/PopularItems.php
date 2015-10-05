<?php

namespace app\modules\mycompany\popularitems;

class PopularItems extends \yii\base\Module
{
    public function init()
    {
        parent::init();
        \Yii::configure($this, require(__DIR__ . '/config.php'));
    }
}