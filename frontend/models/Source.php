<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "source".
 *
 * @property int $id
 * @property string $name
 * @property int $forsort
 * @property string $marker
 */
class Source extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'source';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'forsort', 'marker'], 'required'],
            [['forsort'], 'integer'],
            [['url'], 'string', 'max' => 255],
            [['marker'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'url',
            'forsort' => 'Forsort',
            'marker' => 'Marker',
        ];
    }
}
