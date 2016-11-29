<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $fname
 * @property string $lname
 * @property string $password
 * @property string $email
 * @property string $username
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fname', 'lname', 'password', 'email', 'username'], 'required'],
            [['fname', 'lname'], 'string', 'max' => 200],
            [['password'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 100],
            [['username'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fname' => 'Fname',
            'lname' => 'Lname',
            'password' => 'Password',
            'email' => 'Email',
            'username' => 'Username',
        ];
    }
}
