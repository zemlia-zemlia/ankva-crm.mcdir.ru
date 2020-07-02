<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%objects_favorites}}`.
 */
class m190826_135849_create_favorite_objects_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%favorite_objects}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'ads' => $this->text(),
        ], $tableOptions);

        $this->createIndex('{{%favorite_objects_user_index}}', '{{%favorite_objects}}', 'user_id');
    }

    public function down()
    {
        $this->dropTable('{{%favorite_objects}}');
    }
}
