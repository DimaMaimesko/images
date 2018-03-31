<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comments`.
 */
class m180327_101650_create_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('comments', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer(11)->notNull(),
            'user_id' => $this->integer(11)->notNull(),
            'content' => $this->text(),
            'created_at' => $this->integer(11),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('comments');
    }
}
