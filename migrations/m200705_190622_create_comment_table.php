<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comment}}`.
 */
class m200705_190622_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'id_city' => $this->integer()->defaultValue(0),
            'title' => $this->string()->defaultValue(0),
            'text' => $this->string()->defaultValue(0),
            'rating' => $this->integer()->defaultValue(0),
            'img' => $this->string()->defaultValue(0),
            'id_autor' => $this->integer()->defaultValue(0),
            'date_create' => $this->date()->defaultValue(0),
        ]);
        // add foreign key for table `city`
        $this->addForeignKey('fk-id-city', 'comment', 'id_city',
            'city', 'id', 'CASCADE');

        // add foreign key for table `user`
        $this->addForeignKey('fk-id-autor', 'comment', 'id_autor',
            'user', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-id-city',
            'comment');
        $this->dropForeignKey('fk-id-autor',
            'comment');
        $this->dropTable('{{%comment}}');
    }
}
