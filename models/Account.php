<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "account".
 *
 * @property string $username
 * @property string $password
 * @property string $name
 * @property string $role
 *
 * @property Post[] $posts
 */
class Account extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'account';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'name', 'role'], 'required'],
            [['username', 'name', 'role'], 'string', 'max' => 45],
            [['password'], 'string', 'max' => 250],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'password' => 'Password',
            'name' => 'Name',
            'role' => 'Role',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['username' => 'username']);
    }

    public static function findByUsername($username)
    {

        $account = Account::find()
              ->where(['username' => $username])
              ->one();
        if (count($account)!=0) {
                return new static($account);
            }
        return null;
    }

    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
