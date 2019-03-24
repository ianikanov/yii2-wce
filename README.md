Widget as Controller Yii2 Extension
===================================
Ability to generate widgets with interface similar to controller with basic CRUD actions for specific model

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist ianikanov/yii2-wce "dev-master"
```

or add

```
"ianikanov/yii2-wce": "dev-master"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, add new template to your config file :
```php
if (YII_ENV_DEV) {    
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',      
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '192.168.178.20'],  
        'generators' => [ //here
            'widgetCrud' => [
                'class' => '\ianikanov\wce\templates\crud\Generator',
                'templates' => [
                    'WCE' => '@vendor/ianikanov/yii2-wce/templates/crud/default', // template name
                ],
            ],
        ],
    ];
}
```

Then run gii, select "CRUD Controller Widget" fill the form and generate the code.

To use widget in any other form.

To show list of items, for example, the list of Posts related to the current model:
```php
<?= app\widgets\PostControllerWidget::widget([
    'action' => 'index',
    'params' => [
        'query' => $model->getPosts(),
    ],
]) ?>
```

To show a single item details, for example the post
```php
<?= app\widgets\PostControllerWidget::widget([
    'action' => 'view',
    'params' => [
        'id' => $post_id,
    ],
]) ?>
```

To show create button with modal window:
```php
<?= app\widgets\PostControllerWidget::widget(['action' => 'create']) ?>
```

To show update button with modal window:
```php
<?= app\widgets\PostControllerWidget::widget(['action' => 'update', 'params'=>['id' => $model->id]]) ?>
```

To show delete button:
```php
<?= app\widgets\PostControllerWidget::widget(['action' => 'delete', 'params'=>['id' => $model->id]]) ?>
```
