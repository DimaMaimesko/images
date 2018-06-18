<?php

use yii\db\Migration;

/**
 * Handles the creation of table `geotags`.
 */
class m180520_161807_create_geotags_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('geotags', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer()->notNull(),
            'lat' => $this->float(),
            'lng' => $this->float(),
            'created_at' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('geotags');
    }
}
