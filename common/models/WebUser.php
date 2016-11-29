<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_user".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $type
 * @property string $last_login
 */
class WebUser extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'web_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'type', 'authKey'], 'required'],
            [['type'], 'string'],
            [['last_login'], 'safe'],
            [['username'], 'string', 'max' => 200],
            [['email'], 'string', 'max' => 100],
            [['password', 'authKey'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'type' => 'Type',
            'last_login' => 'Last Login',
            'authKey' => 'Auth Key',
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
