<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_details".
 *
 * @property integer $order_id
 * @property integer $product_id
 * @property integer $quantity
 * @property integer $status
 * @property double $price
 */
class OrderDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'quantity', 'status', 'price'], 'required'],
            [['order_id', 'product_id', 'quantity', 'status'], 'integer'],
            [['price'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'product_id' => 'Product ID',
            'quantity' => 'Quantity',
            'status' => 'Status',
            'price' => 'Price',
        ];
    }
}