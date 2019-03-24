<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$modelClassName = Inflector::camel2words(StringHelper::basename($generator->modelClass));
$nameAttributeTemplate = '$model->' . $generator->getNameAttribute();
$titleTemplate = $generator->generateString('Update ' . $modelClassName . ': {name}', ['name' => '{nameAttribute}']);
if ($generator->enableI18N) {
    $title = strtr($titleTemplate, ['\'{nameAttribute}\'' => $nameAttributeTemplate]);
} else {
    $title = strtr($titleTemplate, ['{nameAttribute}\'' => '\' . ' . $nameAttributeTemplate]);
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $embeddedController string Route to embedded controller */

?>
<span class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-widget-update">

    <?= "<?php\n" ?>
    Modal::begin([
        'header' => '<h2>'.Html::encode(<?= $title ?>).'</h2>',
        'toggleButton' => ['tag' => 'a', 'label' => <?= $generator->generateString('Update') ?>, 'class' => 'btn btn-primary'],
    ]);

    echo $this->render('_form', [
        'model' => $model,
        'action' => [$embeddedController, 'action' => '<?= $generator->controllerID ?>/update', 'id'=>$model->id],
    ]);
    
    Modal::end();
    
    ?>

</span>
