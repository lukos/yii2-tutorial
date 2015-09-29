<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%author}}".
 *
 * @property integer $id
 * @property string $firstname
 * @property string $surname
 * @property string $biography
 *
 * @property Book[] $books
 */
class Author extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%author}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstname', 'surname'], 'required'],
            [['firstname'], 'string', 'max' => 32],
            [['surname'], 'string', 'max' => 64],
            [['biography'], 'string', 'max' => 2048]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'firstname' => Yii::t('app', 'Firstname'),
            'surname' => Yii::t('app', 'Surname'),
            'biography' => Yii::t('app', 'Biography'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Book::className(), ['author_id' => 'id'])->inverseOf('author');
    }
    
    public function getDisplayName()
    {
        return $this->firstname.' '.$this->surname;
    }
}
