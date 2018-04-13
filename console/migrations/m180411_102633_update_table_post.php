<?php

use yii\db\Migration;

/**
 * Class m180411_102633_update_table_post
 */
class m180411_102633_update_table_post extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->addColumn('{{%post}}', 'report', $this->integer(3));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180411_102633_update_table_post cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180411_102633_update_table_post cannot be reverted.\n";

        return false;
    }
    */
}
