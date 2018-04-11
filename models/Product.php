<?php
    /**
     * Created by PhpStorm.
     * User: wrewolf
     * Date: 10.04.18
     * Time: 22:24
     */
    
    namespace app\models;
    
    
    use yii\db\ActiveRecord;
    
    /**
     * Class Product
     *
     * @package app\models
     *
     * @property integer $id
     * @property string  $name
     * @property integer $count
     * @property integer $price
     */
    class Product extends ActiveRecord
    {
    
    }