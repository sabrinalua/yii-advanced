<?php

namespace common\models;

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
class User1 extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
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

    public static function findIdentity($id){
        return static::findOne($id);
    }

    public static function findByUsername($username){
        return static::findOne(['username' => $username]);
    }

    public function validatePassword($password){
        return $this->password === md5($password);
        // return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public static function findIdentityByAccessToken($token, $type = null){
        throw new NotSupportedException();
    // return static::findOne(['access_token' => $token]);
    }

    public function getId(){
        return $this->id;
    }

    public function getAuthKey(){
        return $this->authKey;
    }

    public function validateAuthKey($authKey){
        return $this->authKey === $authKey;
    }
}
