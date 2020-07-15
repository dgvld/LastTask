<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\SignupForm;
use yii\db\Expression;
use Yii;


class User extends ActiveRecord implements IdentityInterface
{


    public $_password;


    const ACTIVE_USER = 1;


    public static function tableName()
    {
        return 'user';
    }


    // Ищим пользователя по id
    public static function findIdentity($id)
    {
        return static ::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        /* return static::findOne(['access_token' => $token]);*/
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static ::findOne(['email' => $email, 'active' =>self::ACTIVE_USER]);
    }


    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }
    /**
     * @inheritdoc
     */

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    // Проверяем пароль, каторый вёл пользователь
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    // Генерируем рандомную строку
    public function generateAuthKey()
    {
        $this -> auth_key = Yii::$app->security->generateRandomString();
    }
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }
    public function setCode($code)
    {
        $this->code = Yii::$app->getSecurity()->generateRandomString(10);
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {

            $this->_user = $this->findByEmail($this->email);
        }
        return $this->_user;
    }
    /**
     * @return mixed
     * Отправка почты с потверждением Email
     */
    /**
     * @return bool
     */
    public function create()
    {
        return $this->save(false);
    }
    public function sendConfirmationLink()
    {
        $confirmationLink = Html::a('Подтвердите Email', Url::to(['site/confirmemail', 'email' => $this->email, 'code' => $this->code], true));

        $sendingResult = Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($this->email)
            ->setSubject('Потвердите Email')
            ->setHtmlBody('<p> Для прохождения регистрации Вам необходимо потвердить свой email</p>
            <p>'. $confirmationLink .'</p>')
            ->send();
        return $sendingResult;
    }
    public function getDate()
    {
        return Yii::$app->formatter->asDate($this->date_create);
    }
}