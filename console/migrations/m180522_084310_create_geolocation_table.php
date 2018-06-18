<?php

use yii\db\Migration;

/**
 * Handles the creation of table `geolocation`.
 */
class m180522_084310_create_geolocation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('geolocation', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer()->notNull(),
            'latLng' => $this->string(),
            'time' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('geolocation');
    }
}
