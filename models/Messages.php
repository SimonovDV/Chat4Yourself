<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "messages".
 * Модель сообщений, обработка записи и получения данных.
 *
 * @property int $id
 * @property string $created
 * @property string $ip
 * @property string $message
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * Структура таблицы
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created'], 'safe'],
            [['message'], 'required'],
            [['ip'], 'integer'],
            [['message'], 'string', 'max' => 250],
        ];
    }

    /**
     * Лейблы полей
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created' => 'Дата',
            'ip' => 'Владелец',
            'message' => 'Сообщение',
        ];
    }
    
   /**
    * Перед сохранением, наводим порядок в записи
    * @param type $insert
    * @return boolean
    */
    public function beforeSave($insert)
    {
        if(strlen(trim($this->message))<1) return false;
        if (parent::beforeSave($insert)) {
            $this->ip = ip2long(Yii::$app->request->userIP);
            return true;
        }
        return false;
    }
    
}
