<?php

use yii\db\Migration;

/**
 * Class m190826_072334_rename_objects_floors_column
 */
class m190826_072334_rename_objects_floors_column extends Migration
{
    public function up()
    {
        $this->renameColumn('objects', 'floors', 'total_floor');
    }

    public function down()
    {
        $this->renameColumn('objects', 'total_floor', 'floors');
    }
}
