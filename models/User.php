<?php
    
    namespace app\models;
    
    use yii\db\ActiveRecord;
    
    class User extends ActiveRecord
    {
        private $id;
        private $username;
        
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
        
        /**
         * @return mixed
         */
        public function getUsername()
        {
            return $this->username;
        }
        
        /**
         * @param mixed $username
         */
        public function setUsername($username): void
        {
            $this->username = $username;
        }
        
        /**
         * @return Wallet
         */
        public function getWallet()
        {
            return Wallet::find()->where(['id' => 1])->one();
        }
    }
