<?php
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ArrayDataProvider */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?= Yii::t('app','Welcome') ?></h1>
        
        <p class="lead"><?=  Yii::$app->formatter->asDate('2015-09-28', 'long') ?></p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2><?php echo Yii::t('app','Top Books')  ?></h2>

                <?php echo ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_book',
                ]); ?>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <?php if ( !Yii::$app->user->isGuest )
                {
                    echo "<h2>Your recent orders</h2>";
                    
                    $dataProvider2 = new ActiveDataProvider([
                        'query' => Yii::$app->user->identity->getBooks(),
                        'pagination' => [
                            'pageSize' => 3,
                        ],
                    ]);
                    
                    echo ListView::widget([
                        'dataProvider' => $dataProvider2,
                        'itemView' => '_book',
                    ]);
                }
                ?>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
