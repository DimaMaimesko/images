<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "session".
 *
 * @property string $id
 * @property resource $data
 * @property int $user_id
 * @property int $last_write
 * @property int $expire
 */
class Session extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'session';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'last_write'], 'required'],
            [['data'], 'string'],
            [['user_id', 'last_write', 'expire'], 'integer'],
            [['id'], 'string'],
            [['id'], 'unique'],
        ];
    }

    
}
