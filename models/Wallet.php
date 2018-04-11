<?php
    /**
     * Created by PhpStorm.
     * User: wrewolf
     * Date: 10.04.18
     * Time: 21:31
     */
    
    namespace app\models;
    
    
    use yii\db\ActiveRecord;
    
    /**
     * Class Wallet
     *
     * @package app\models
     *
     * @property integer $id
     * @property integer $count_one
     * @property integer $count_two
     * @property integer $count_five
     * @property integer $count_ten
     */
    class Wallet extends ActiveRecord
    {
        /**
         * @param $op_vm_wallet \app\models\Wallet
         */
        public function put($op_vm_wallet)
        {
            $this->count_one = $this->count_one + $op_vm_wallet->count_one;
            $op_vm_wallet->count_one = 0;
            $this->count_two = $this->count_two + $op_vm_wallet->count_two;
            $op_vm_wallet->count_two = 0;
            $this->count_five = $this->count_five + $op_vm_wallet->count_five;
            $op_vm_wallet->count_five = 0;
            $this->count_ten = $this->count_ten + $op_vm_wallet->count_ten;
            $op_vm_wallet->count_ten = 0;
        }
        
        public function getSum()
        {
            return $this->count_one + $this->count_two * 2 + $this->count_five * 5 + $this->count_ten * 10;
        }
    }