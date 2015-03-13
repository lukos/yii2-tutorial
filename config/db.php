<?php


/* Note that this configuration is for a local VM on my development machine which will not
  work for you. You need to set these to something that will work for you. If you use sqlite in
 * php, you can use the given sqlite connection string which doesn't require username or password but
 * make sure to comment out the mysql connection */

/* Note that sqlite doesn't support foreign keys so using it means you will not be able to
 * automatically generate relationships between models as you can with mysql or sql server */
return [
    'class' => 'yii\db\Connection',
    //'dsn' => 'sqlite:d:\projects\basic\local.sqlite',
    'dsn'=>'mysql:host=192.168.56.101;dbname=basictest',
    'username'=>'basictest',
    'password'=>'localpassword',
    'charset' => 'utf8',
];
