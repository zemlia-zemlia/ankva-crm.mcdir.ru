<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Role */
/* @var $permit app\models\Role */

$this->title = 'Редактировать разрешения: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Роли пользователей', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = 'Редактировать разрешения';




?>

<div class="role-update">

    <form method="post" action="/client/role/update?id=<?=$model->name?>">
        <div class="col-lg-6">
<?php foreach($permit as $pm) {
    $check = \app\models\client\Permit::find()->where(['parent' => $model->name])
        ->andWhere(['child' => $pm->name])->exists();
    if ($pm->name != 'accessByTime' && $pm->name != 'accessByIp'){

    ?>

    <div class="form-group field-<?=$pm->name?>_checkbox">
        <div class="checkbox">
            <label for="<?=$pm->name?>_checkbox">
                <input type="hidden" name="<?=$pm->name?>" value="0"><input type="checkbox" id="<?=$pm->name?>_checkbox" name="<?=$pm->name?>" <?=($check)? 'checked="checked"':''?> value="1" uncheckvalue="0">
                <?=$pm->description?>
            </label>
            <p class="help-block help-block-error"></p>

        </div>
    </div>





<?php } }?>
        </div>
        <div class="col-lg-6">

        <div class="form-group">
            <p>Разрешенное время входа</p>
            <label for="accessFrom">С </label>
            <input type="text" size="3" value="<?= $model->accessFrom ?>" name="accessFrom"/>
            <label for="accessTo" >По </label>
            <input type="text"  size="3"  value="<?= $model->accessTo ?>" name="accessTo"/>
            </div>
        <div class="form-group">
            <label for="accessRemoteIp">Диапазон разрешенных IP </label><br>

            <input type="text" size="60" value="<?= $model->accessRemoteIp ?>" name="accessRemoteIp"/>

        </div>

    <div class="form-group"><br>
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
            </div>
    </form>
</div>
