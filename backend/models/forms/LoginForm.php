<?php
namespace backend\models\forms;

use backend\models\User;
use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;

/**
 * Login form
 */
class LoginForm extends Model
{

    public $email;
    public $password;
    public $rememberMe = TRUE;

    private $_user;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => time(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // email and password are both required
            [['email', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('admin-side', 'Email'),
            'password' => Yii::t('admin-side', 'Password'),
            'rememberMe' => Yii::t('admin-side', 'Remember Me'),
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array  $params    the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Yii::t('admin-side', 'Incorrect login or password'));
            }
        }
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === NULL) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }

    /**
     * Logs in a user using the provided email and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            if (Yii::$app->user->login($this->getUser(), $this->rememberMe ? (3600 * 24 * 30) : 0)) {
                if (
                Yii::$app->user->cannot([
                    User::ROLE_ROOT,
                    User::ROLE_ADMIN,
                    User::ROLE_MANAGER,
                    User::ROLE_SELLER,
                ])
                ) {
                    Yii::$app->user->logout();
                    Yii::$app->session->addFlash('error', Yii::t('admin-side', 'You have insufficient privileges!'));
                    return FALSE;
                }
                return TRUE;
            }
        }
        return FALSE;
    }
}
