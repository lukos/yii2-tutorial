<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Module Test';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        This is a module test view:
    </p>

    <code><?= __FILE__ ?></code>
</div>
