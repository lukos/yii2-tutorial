<?php

namespace app\controllers;

use yii\filters\auth\HttpBasicAuth;

class TunnelController extends \yii\rest\Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
        ];
        return $behaviors;
    }

    public function actionGetMeta()
    {
            return [['name'=>'Rebecca RDP','gatewayport'=>7888,'gatewayip'=>'82.69.172.225', 'tunnelip'=>'10.1.26.92', 'tunnelport'=>3389],
                   ['name'=>'Ellie RDP','gatewayport'=>7888,'gatewayip'=>'82.69.172.225', 'tunnelip'=>'10.1.26.93', 'tunnelport'=>3389]];
    }
    
    
    
}