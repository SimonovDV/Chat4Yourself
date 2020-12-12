<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bakersdream_product".
 *
 * @property string $product_id
 * @property float $count
 */
class Bakersdreamproduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bakersdream_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'count'], 'required'],
            [['count'], 'number'],
            [['product_id'], 'string', 'max' => 250],
            [['product_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'count' => 'Count',
        ];
    }
}
