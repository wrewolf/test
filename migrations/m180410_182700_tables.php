<?php
    
    use yii\db\Migration;
    
    /**
     * Class m180410_182700_tables
     */
    class m180410_182700_tables extends Migration
    {
        /**
         * {@inheritdoc}
         */
        public function safeUp()
        {
            $this->createTable(\app\models\Product::tableName(), [
                'id'    => $this->primaryKey(),
                'name'  => $this->string(),
                'count' => $this->integer(),
                'price' => $this->integer(),
            ]);
            
            $this->createTable(\app\models\Wallet::tableName(), [
                'id'        => $this->primaryKey(),
                'count_one'  => $this->integer(),
                'count_two'  => $this->integer(),
                'count_five' => $this->integer(),
                'count_ten'  => $this->integer(),
            ]);
            
            $w = new \app\models\Wallet();
            $w->setId(1);
            $w->setCountOne(10);
            $w->setCountTwo(20);
            $w->setCountFive(20);
            $w->setCountTen(15);
            $w->save();
            $w = new \app\models\Wallet();
            $w->setId(2);
            $w->setCountOne(100);
            $w->setCountTwo(100);
            $w->setCountFive(100);
            $w->setCountTen(100);
            $w->save();
            $w = new \app\models\Wallet();
            $w->setId(3);
            $w->setCountOne(0);
            $w->setCountTwo(0);
            $w->setCountFive(0);
            $w->setCountTen(0);
            $w->save();
            $p = new \app\models\Product();
            $p->setId(1);
            $p->setName('tea');
            $p->setPrice(13);
            $p->setCount(10);
            $p->save();
            $p = new \app\models\Product();
            $p->setId(2);
            $p->setName('coffee');
            $p->setPrice(18);
            $p->setCount(20);
            $p->save();
            $p = new \app\models\Product();
            $p->setId(3);
            $p->setName('white_coffee');
            $p->setPrice(21);
            $p->setCount(20);
            $p->save();
            $p = new \app\models\Product();
            $p->setId(4);
            $p->setName('juice');
            $p->setPrice(35);
            $p->setCount(15);
            $p->save();
            
            return true;
        }
        
        /**
         * {@inheritdoc}
         */
        public function safeDown()
        {
            echo "m180410_182700_tables cannot be reverted.\n";
            
            return false;
        }
        
        /*
        // Use up()/down() to run migration code without a transaction.
        public function up()
        {
    
        }
    
        public function down()
        {
            echo "m180410_182700_tables cannot be reverted.\n";
    
            return false;
        }
        */
    }
