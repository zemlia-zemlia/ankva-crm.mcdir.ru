<?php

use yii\db\Migration;

/**
 * Class m190825_132850_add_rooms_nd_field
 */
class m190825_132850_add_rooms_nd_field extends Migration
{
    public function up()
    {
        $this->addColumn('{{%rooms}}', 'nd', $this->string()->after('yandex_id'));
    }

    public function down()
    {
        $this->dropColumn('{{%rooms}}', 'nd');
    }
}
