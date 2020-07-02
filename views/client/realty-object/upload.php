<?php

use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;
?>

<?php $form = ActiveForm::begin();

echo $form->field($model, 'imageFile[]')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*',
        'multiple'=>true
    ],
//    'pluginOptions' => [
//    'uploadUrl' => Url::to(['/client/realty-object/upload']),
//        ]
]);




 ?>



<?php ActiveForm::end() ?>

