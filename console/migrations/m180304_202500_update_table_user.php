<?php

use yii\db\Migration;

/**
 * Class m180304_202500_update_table_user
 */
class m180304_202500_update_table_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('{{%user}}', 'about', $this->text());
        $this->addColumn('{{%user}}', 'type', $this->integer(3));
        $this->addColumn('{{%user}}', 'nickname', $this->string(70));
        $this->addColumn('{{%user}}', 'picture', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
       $this->dropColumn('{{%user}}', 'picture');
       $this->dropColumn('{{%user}}', 'nickname');
       $this->dropColumn('{{%user}}', 'type');
       $this->dropColumn('{{%user}}', 'about');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180304_202500_update_table_user cannot be reverted.\n";

        return false;
    }
    */
}
