<?php
/* @var $this yii\web\View */
use yii\widgets\ListView;
use yii\helpers\Html;

use app\models\Tag;
use app\controllers\TagController;

$this->title = 'Новости сервиса';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
if(Yii::$app->user->identity->isAdminCRM=='1'){

?>
<p>
    <?= Html::a('Добавить запись', ['create'], ['class' => 'btn btn-success']) ?>

</p>
<?php
}
?>
    Показать: <br>
    <a class="btn btn-default btn-xs" href="?id_tag=" class="btn btn-default btn-xs">Все</a>

<?php
    $categories = Tag::find()->all();
    foreach($categories as $cat){
        ?>
        <a class="btn btn-default btn-xs" href="?id_tag=<?=$cat->id_tag?>" class="btn btn-default btn-xs"><?=$cat->title?></a>

<?php
    }

?>

<div class="row">
    <?= ListView::widget([
        'options' => [
            'tag' => 'div',
        ],
        'dataProvider' => $listDataProvider,
        'itemView' => function ($model, $key, $index, $widget) {
            $itemContent = $this->render('_list_item',['model' => $model]);


            return $itemContent;

            /* Or if you just want to display the list only: */
            // return render('_list_item',['model' => $model]);
        },
        'itemOptions' => [
            'tag' => false,
        ],
        'summary' => '',
        'layout' => '{items}{pager}',

        'pager' => [
            'firstPageLabel' => 'Первая',
            'lastPageLabel' => 'Последняя',
            'maxButtonCount' => 4,
            'options' => [
                'class' => 'pagination col-xs-12'
            ]
        ],

    ]);
    ?>
</div>