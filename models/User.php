<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property string $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
  */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const ROLE_USER = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],

            ['role', 'default', 'value' => self::ROLE_USER],
            ['role', 'in', 'range' => [self::ROLE_USER]],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        if ( static::AuthenticateCode($token) == true)
        {
            return static::findByUsername('luke');
        }
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }
    
    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }
	
    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    
    /**
     * Contact Google and check that the given authcode is valid to release the endpoint data
     * we have. We do this by getting an email and checking we are happy with the email
     * @param type $authCode
     */
    public static function AuthenticateCode($authCode)
    {
        $post_data = 'code='.$authCode;
        $post_data .= '&client_id=868600881793-qleonnq3jr662ffhr6vdchetl8vqmjv5.apps.googleusercontent.com';
        $post_data .= '&client_secret=pc9YAOxPDaiSWwcLYR6jetOF';
        $post_data .= '&redirect_uri=urn:ietf:wg:oauth:2.0:oob';
        $post_data .= '&grant_type=authorization_code';
        
        $ch = curl_init();
        //$f = fopen('c:\request.txt', 'w');
        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/oauth2/v3/token');
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        //curl_setopt($ch, CURLOPT_STDERR, $f );
        $raw_response = curl_exec($ch);
        Yii::info('Get token raw response: '.$raw_response,'luke');
        if ( $raw_response == false )
        {
            return false;
        }
        $response = json_decode($raw_response,true);
        
        if ( array_key_exists("error", $response))
        {
            \Yii::error('Get Token error: '.$response["error"],'luke');
            return false;
        }
        
        /* Example response. For this test, we only care about the access_token
         * {
            "access_token":"1/fFAGRNJru1FTz70BzhT3Zg",
            "expires_in":3920,
            "token_type":"Bearer",
            "refresh_token":"1/xEoDL4iW3cxlI7yDbSRFYNG01kVKM2C-259HOF2aQbI"
          }
         */
        
        $accessToken = $response['access_token'];
        
        curl_reset($ch);
        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/oauth2/v1/tokeninfo?access_token='.$accessToken);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        $raw_response = curl_exec($ch);
        \Yii::info('Raw response: '.$raw_response,'luke');
        if ( $raw_response == false )
        {
            \Yii::info('Raw response is false','luke');
            return false;
        }
        $person = json_decode($raw_response, true);
        
        if ( array_key_exists("error",$person))
        {
            \Yii::error('Token info error: '.$person["error"],'luke');
            return false;
        }
        
        //\Yii::info('Person: '.print_r($person),'luke');
        
        $firstEmail = $person["email"];
        \Yii::info('Email: '.$firstEmail,'luke');
        
        return $firstEmail == "luke@pixelpin.co.uk";
    }
    
    public function getUserBooks()
    {
        return $this->hasMany(BookUserLink::className(), ['user_id' => 'id']);
    }
    
    public function getBooks()
    {
        return $this->hasMany(Book::className(), ['id' => 'book_id'])
            ->via('userBooks');
    }
}
