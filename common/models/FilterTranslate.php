<?php

namespace common\models;

use xz1mefx\base\db\ActiveRecord;
use xz1mefx\multilang\models\Language;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%filter_translate}}".
 *
 * @property integer  $id
 * @property integer  $filter_id
 * @property integer  $language_id
 * @property string   $name
 * @property string   $value
 * @property integer  $created_by
 * @property integer  $updated_by
 * @property integer  $created_at
 * @property integer  $updated_at
 *
 * @property User     $updatedBy
 * @property User     $createdBy
 * @property Filter   $filter
 * @property Language $language
 */
class FilterTranslate extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%filter_translate}}';
    }

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
            [['filter_id', 'language_id', 'name', 'value'], 'required'],
            [['filter_id', 'language_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['name', 'value'], 'string', 'max' => 255],
            [['updated_by'], 'exist', 'skipOnError' => TRUE, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => TRUE, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['filter_id'], 'exist', 'skipOnError' => TRUE, 'targetClass' => Filter::className(), 'targetAttribute' => ['filter_id' => 'id']],
            [['language_id'], 'exist', 'skipOnError' => TRUE, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_by = Yii::$app->user->id;
        } else {
            $this->updated_by = Yii::$app->user->id;
        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'filter_id' => Yii::t('common', 'Filter ID'),
            'language_id' => Yii::t('common', 'Language ID'),
            'name' => Yii::t('common', 'Name'),
            'value' => Yii::t('common', 'Value'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFilter()
    {
        return $this->hasOne(Filter::className(), ['id' => 'filter_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }
}
