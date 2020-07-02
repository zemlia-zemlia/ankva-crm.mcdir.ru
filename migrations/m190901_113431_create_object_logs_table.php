<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%object_logs}}`.
 */
class m190901_113431_create_object_logs_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{object_logs}}', [
            'log_id' => $this->primaryKey(),
            'log_type' => $this->integer()->notNull(),
            'log_user_id' => $this->integer()->notNull(),
            'log_object_id' => $this->integer()->notNull(),
            'log_description' => $this->string()->notNull(),
            'log_old_value' => $this->integer(),
            'log_new_value' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{object_logs_type_index}}', '{{object_logs}}', 'log_type');
        $this->createIndex('{{object_logs_object_index}}', '{{object_logs}}', 'log_object_id');
        $this->createIndex('{{object_logs_user_index}}', '{{object_logs}}', 'log_user_id');

        $this->addForeignKey('{{object_logs_object_fk}}', '{{object_logs}}', 'log_object_id', '{{objects}}', 'id', 'CASCADE');
        $this->addForeignKey('{{object_logs_user_fk}}', '{{object_logs}}', 'log_user_id', '{{user}}', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{object_logs}}');
    }
}
