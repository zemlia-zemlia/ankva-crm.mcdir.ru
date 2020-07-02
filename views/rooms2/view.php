<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Rooms2 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Rooms2s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="rooms2-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'avito_id',
            'title',
            'date_avito',
            'is_company:ntext',
            'price',
            'pledge:ntext',
            'description:ntext',
            'href',
            'seller',
            'phone',
            'city',
            'region',
            'addr',
            'type',
            'type_info',
            'rooms',
            'etazh:ntext',
            'etazhnost:ntext',
            'metr',
            'date_add',
            'actual:ntext',
            'source:ntext',
            'yandex_id:ntext',
            'sale_parametr1:ntext',
            'sale_parametr2:ntext',
            'sale_parametr3',
            'sale_parametr4',
            'sale_parametr5',
            'sale_parametr6',
            'rent_parametr1:ntext',
            'rent_parametr2:ntext',
            'rent_parametr3',
            'rent_parametr4',
            'sale_room_parametr1:ntext',
            'sale_room_parametr2:ntext',
            'sale_room_parametr3',
            'sale_room_parametr4',
            'sale_room_parametr5',
            'sale_room_parametr6:ntext',
            'rent_room_parametr1:ntext',
            'rent_room_parametr2:ntext',
            'rent_room_parametr3:ntext',
            'rent_room_parametr4',
            'rent_room_parametr5',
            'rent_room_parametr6',
            'rent_room_parametr7:ntext',
            'sale_home_parametr1:ntext',
            'sale_home_parametr2:ntext',
            'sale_home_parametr3:ntext',
            'sale_home_parametr4',
            'sale_home_parametr5',
            'sale_home_parametr6',
            'sale_home_parametr7:ntext',
            'rent_home_parametr1:ntext',
            'rent_home_parametr2:ntext',
            'rent_home_parametr3:ntext',
            'rent_home_parametr4',
            'rent_home_parametr5',
            'rent_home_parametr6',
            'rent_home_parametr7:ntext',
            'rent_home_parametr8:ntext',
            'sale_land_parametr1:ntext',
            'sale_land_parametr2:ntext',
            'sale_land_parametr3:ntext',
            'sale_land_parametr4:ntext',
            'rent_land_parametr1:ntext',
            'rent_land_parametr2:ntext',
            'rent_land_parametr3:ntext',
            'rent_land_parametr4:ntext',
            'sale_garage_parametr1:ntext',
            'sale_garage_parametr2:ntext',
            'sale_garage_parametr3:ntext',
            'sale_garage_parametr4:ntext',
            'sale_garage_parametr5:ntext',
            'rent_garage_parametr1:ntext',
            'rent_garage_parametr2:ntext',
            'rent_garage_parametr3:ntext',
            'rent_garage_parametr4:ntext',
            'rent_garage_parametr5:ntext',
            'rent_commerc_parametr1:ntext',
            'rent_commerc_parametr2:ntext',
            'rent_commerc_parametr3:ntext',
            'rent_commerc_parametr4:ntext',
            'rent_commerc_parametr5:ntext',
            'sale_commerc_parametr1:ntext',
            'sale_commerc_parametr2:ntext',
            'sale_commerc_parametr3:ntext',
            'sale_commerc_parametr4:ntext',
            'sale_commerc_parametr5:ntext',
            'dop:ntext',
            'dop2:ntext',
            'category_id:ntext',
            'person_type:ntext',
            'count_ads_same_phone:ntext',
            'blackagent',
            'images:ntext',
            'id_task',
            'id_ads',
        ],
    ]) ?>

</div>
