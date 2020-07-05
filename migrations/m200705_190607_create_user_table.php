<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m200705_190607_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'fio' => $this->string()->defaultValue(0),
            'email' => $this->string()->defaultValue(0),
            'phone' => $this->string(20)->defaultValue(0),
            'date_create' => $this->integer()->defaultValue(0),
            'password' => $this->string()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
