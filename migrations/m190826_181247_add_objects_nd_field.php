<?php

use yii\db\Migration;

/**
 * Class m190826_181247_add_objects_nd_field
 */
class m190826_181247_add_objects_nd_field extends Migration
{
    public function up()
    {
        $this->addColumn('{{%objects}}', 'nd', $this->boolean()->after('email')->defaultValue(false));
    }

    public function down()
    {
        $this->dropColumn('{{%objects}}', 'nd');
    }
}
