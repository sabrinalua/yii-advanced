<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "feed_source".
 *
 * @property integer $id
 * @property string $title
 * @property string $link
 * @property string $status
 */
class FeedSource extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feed_source';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'link'], 'required'],
            [['status'], 'string'],
            [['title'], 'string', 'max' => 200],
            [['link'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'link' => 'Link',
            'status' => 'Status',
        ];
    }
}
