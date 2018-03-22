<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post`.
 */
class m180319_104154_create_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('post', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'caption' => $this->string(100),
            'content' => $this->text(),
            'photo' => $this->string(100),
            'created_at' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            
        ]);
     
          
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('post');
    }
}
