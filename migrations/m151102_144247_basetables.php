<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * IMPORTANT. No guarantees are provided that this works exactly correct because I have created it
 * manually after the tables already exist in the database. It has been added to make it easier for
 * people following the tutorials.
 */
class m151102_144247_basetables extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%author}}', [
            'id' => Schema::TYPE_PK,
            'firstname' => Schema::TYPE_STRING . '(32) NOT NULL',
            'surname' => Schema::TYPE_STRING . '(64) NOT NULL',
            'biography' => Schema::TYPE_STRING . '(2048)',
        ], $tableOptions);
        
        $this->createTable('{{%book}}', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(64) NOT NULL',
            'description' => Schema::TYPE_STRING . '(1024) NOT NULL',
            'author_id' => Schema::TYPE_INTEGER ,
            'isbn' => Schema::TYPE_STRING . '(32)',
            'rank' => Schema::TYPE_INTEGER,
        ], $tableOptions);
        
        $this->addForeignKey('FK_BOOK_AUTHOR', '{{%book}}', 'author_id', '{{%author}}', 'id', 'RESTRICT', 'RESTRICT');
        
        $this->createTable('{{%book_user_link}}', [
            'book_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        
        $this->addForeignKey('FK_BOOK_USER_LINK_BOOK', '{{%book_user_link}}', 'book_id', '{{%book}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_BOOK_USER_LINK_USER', '{{%book_user_link}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('{{%author}}');
        $this->dropTable('{{%book}}');
        $this->dropTable('{{%book_user_link}}');
    }
}
