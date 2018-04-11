<?php
    /**
     * Created by PhpStorm.
     * User: wrewolf
     * Date: 10.04.18
     * Time: 21:32
     */
    
    namespace app\models;
    
    
    class VM
    {
        private $id;
        
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
        
        public function getProducts()
        {
            return new Products();
        }
        
        public function getWallet()
        {
            return Wallet::find()->where(['id' => 2])->one();
        }
        
        public function getOPWallet()
        {
            return Wallet::find()->where(['id' => 3])->one();
        }
    }