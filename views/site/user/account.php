<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Tabs;
use app\models\Payments;

$this->title = 'Личный кабинет';
if (Yii::$app->user->isGuest) {
   //$this->redirect('site/login', 301);
    $form = ActiveForm::begin([
        'action' => 'site/login'
    ]);
}else{
?>
    <div class="site-error">

        <?php echo Yii::$app->session->getFlash('success'); ?>
        <p>
            Ваш баланс: <?=Yii::$app->user->identity->balance?>
            <br>
            Оплачен до: <?=Yii::$app->formatter->asDate(Yii::$app->user->identity->access_to) ?>

            <?= Html::a('Пополнить', ['site/add-balance', 'new'=>'600']); ?>
        </p>




    </div>

<?
    $payments = Payments::find()->where(['id_user' => Yii::$app->user->identity->id])->all();


echo Tabs::widget([
    'items' => [
        [
            'label' => 'Заголовок вкладки 1',
            'content' => 'Вкладка 1',
            'active' => true // указывает на активность вкладки
        ],
        [
            'label' => 'Заголовок вкладки 2',
            'content'   =>  $this->render('payments',['payments'=>$payments]),
        ],
        [
            'label' => 'Заголовок вкладки 3',
            'content' => 'Вкладка 3',
            'headerOptions' => [
                'id' => 'someId'
            ]
        ],
        [
            'label' => 'Таб с указанием URL',
            'url' => 'http://www.somesite.com',
        ],
        [
            'label' => 'Dropdown',
            'items' => [
                [
                    'label' => '1',
                    'content' => 'Выпадашка 1'
                ],
                [
                    'label' => '2',
                    'content' => 'Выпадашка 2'
                ],
                [
                    'label' => '3',
                    'content' => 'Выпадашка 3'
                ],
            ]
        ]
    ]
]);
?>


<?
    //return $this->redirect('site/login', 301);

} ?>