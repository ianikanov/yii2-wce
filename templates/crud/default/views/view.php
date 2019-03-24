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
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-widget-view">

    <h2><?= "<?= " ?>Html::encode($model-><?= $generator->getNameAttribute() ?>) ?></h2>

    <?= "<?= " ?><?= $generator->controllerClass ?>::widget(['action' => 'update', 'params'=>[<?= $urlParams ?>]]) ?>
    <?= "<?= " ?><?= $generator->controllerClass ?>::widget(['action' => 'delete', 'params'=>[<?= $urlParams ?>]]) ?>

    <br/><br/>
    <?= "<?= " ?>DetailView::widget([
        'model' => $model,
        'attributes' => [
<?php
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        echo "            '" . $name . "',\n";
    }
} else {
    foreach ($generator->getTableSchema()->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
    }
}
?>
        ],
    ]) ?>

</div>
