<?php
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        
        <h2>Example routes</h2>
        <p><?= 'Url::to([\'\']) - '.Url::to(['']); ?></p>
        <p><?= 'Url::to([\'about\']) - '.Url::to(['about']); ?></p>
        <p><?= 'Url::to([\'about/details\']) - '.Url::to(['about/details']); ?></p>
        <p><?= 'Url::to([\'/book/view\']) - '.Url::to(['/book/view']); ?></p>
        <p><?= 'Url::to([\'book/view\', \'id\'=>2]) - '.Url::to(['book/view', 'id'=>2]); ?></p>
        <p><?= 'Url::to([\'book/view\', \'id\'=>2, \'#\' => \'content\']) - '.Url::to(['book/view', 'id'=>2, '#' => 'content']); ?></p>
        <p><?= 'Url::to([\'/book/index\'], true) - '.Url::to(['/book/index'], true); ?></p>
        <p><?= 'Url::to([\'/book/index\'], \'https\') - '.Url::to(['/book/index'], 'https'); ?></p>
        <h2>Aliases</h2>
        <?php Yii::setAlias('@books', '/book/index');  ?>
        <p><?= 'Yii::setAlias(\'@books\', \'/book/index\');' ?></p>
        <p><?= 'Url::to([\'@books\']) - '.Url::to(['@books']); ?></p>
    </div>

    <div class="body-content">


    </div>
</div>
