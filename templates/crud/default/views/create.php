<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $embeddedController string Route to embedded controller */

?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-widget-create">
    
    <?= "<?php\n" ?>
    Modal::begin([
        'header' => '<h2>'.Html::encode('Create <?= StringHelper::basename($generator->modelClass) ?>').'</h2>',
        'toggleButton' => ['tag' => 'a', 'label' => 'Create <?= StringHelper::basename($generator->modelClass) ?>', 'class' => 'btn btn-success'],
    ]);

    echo $this->render('_form', [
        'model' => $model,
        'action' => [$embeddedController, 'action' => '<?= $generator->controllerID ?>/create'],
    ]);
    
    Modal::end();
    
    <?= "?>\n" ?>

</div>
