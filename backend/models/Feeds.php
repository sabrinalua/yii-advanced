<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "feeds".
 *
 * @property integer $id
 * @property integer $source_id
 * @property string $type
 * @property string $uid
 * @property string $title
 * @property string $link
 * @property string $summary
 * @property string $author
 * @property string $date
 * @property string $img_link
 * @property string $img_name
 * @property string $status
 */
class Feeds extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feeds';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source_id', 'type', 'uid', 'title', 'link', 'summary', 'author', 'date', 'img_link', 'img_name'], 'required'],
            [['source_id'], 'integer'],
            [['type', 'status'], 'string'],
            [['date'], 'safe'],
            [['uid', 'link'], 'string', 'max' => 500],
            [['title', 'author'], 'string', 'max' => 300],
            [['summary', 'img_link'], 'string', 'max' => 1000],
            [['img_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'source_id' => 'Source ID',
            'type' => 'Type',
            'uid' => 'Uid',
            'title' => 'Title',
            'link' => 'Link',
            'summary' => 'Summary',
            'author' => 'Author',
            'date' => 'Date',
            'img_link' => 'Img Link',
            'img_name' => 'Img Name',
            'status' => 'Status',
        ];
    }
}
