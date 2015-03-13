<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Author */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Author',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Authors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
