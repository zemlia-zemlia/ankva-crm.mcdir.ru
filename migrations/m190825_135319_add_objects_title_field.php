<?php

use yii\db\Migration;

/**
 * Class m190825_135319_add_objects_title_field
 */
class m190825_135319_add_objects_title_field extends Migration
{
    public function up()
    {
        $this->addColumn('{{%objects}}', 'title', $this->string()->after('vk'));
    }

    public function down()
    {
        $this->dropColumn('{{%objects}}', 'title');
    }
}
