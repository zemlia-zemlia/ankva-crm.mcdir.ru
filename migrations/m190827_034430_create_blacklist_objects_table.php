<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blacklist_objects}}`.
 */
class m190827_034430_create_blacklist_objects_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%blacklist_objects}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'phone' => $this->string(),
            'date' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('{{%blacklist_objects_user_index}}', '{{%blacklist_objects}}', 'user_id');
    }

    public function down()
    {
        $this->dropTable('{{%blacklist_objects}}');
    }
}
