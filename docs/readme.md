Создать в папке config 2 файла

db.local.php

    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=nameDB',
        'username' => '',
        'password' => '',
        'charset' => 'utf8',
    ]

params_local.php

    return [
        
    ];