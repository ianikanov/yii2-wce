<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $embeddedController string Route to embedded controller */

\yii\web\YiiAsset::register($this);
?>
<span class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-widget-delete">

    <?= "<?= " ?>Html::a(<?= $generator->generateString('Delete') ?>, [$embeddedController, 'action' => '<?= $generator->controllerID ?>/delete', <?= $urlParams ?>, 'callback' => \Yii::$app->request->url], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => <?= $generator->generateString('Are you sure you want to delete this item?') ?>,
            'method' => 'post',
        ],
    ]) ?>

</span>
