<?php

use yii\db\Migration;

/**
 * Handles the creation of table `session`.
 */
class m180502_110419_create_session_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('session', [
            'id' => $this->primaryKey()->notNull(),
'data' => $this->string()->defaultValue(null),
'user_id' => $this->integer(11)->defaultValue(null),
'last_write' => $this->integer(11)->notNull(),
'expire' => $this->integer(11)->defaultValue(null),


		
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('session');
    }
}
