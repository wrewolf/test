<?php
    /**
     * Created by PhpStorm.
     * User: wrewolf
     * Date: 10.04.18
     * Time: 21:32
     */
    
    namespace app\models;
    
    
    use yii\db\ActiveRecord;
    
    class Products
    {
        private $id;
        
        /**
         * @return Product
         */
        public function getTea()
        {
            return Product::find()->where(['id' => 1])->one();
        }
        
        /**
         * @return Product
         */
        public function getCoffee()
        {
            return Product::find()->where(['id' => 2])->one();
        }
        
        /**
         * @return Product
         */
        public function getWhiteCoffee()
        {
            return Product::find()->where(['id' => 3])->one();
        }
        
        /**
         * @return Product
         */
        public function getJuice()
        {
            return Product::find()->where(['id' => 4])->one();
        }
        
        /**
         * @return mixed
         */
        public function getId()
        {
            return $this->id;
        }
        
        /**
         * @param mixed $id
         */
        public function setId($id): void
        {
            $this->id = $id;
        }
    }