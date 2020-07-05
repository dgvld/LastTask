<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%city}}`.
 */
class m200705_190554_create_city_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%city}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->defaultValue(0),
            'date_create' => $this->date()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%city}}');
    }
}