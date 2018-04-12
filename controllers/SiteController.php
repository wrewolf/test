<?php
    
    namespace app\controllers;
    
    use app\models\Product;
    use app\models\User;
    use app\models\VM;
    use app\models\Wallet;
    use Yii;
    use yii\filters\AccessControl;
    use yii\web\Controller;
    use yii\web\Response;
    use yii\filters\VerbFilter;
    
    class SiteController extends Controller
    {
        /**
         * {@inheritdoc}
         */
        public function behaviors()
        {
            return [
                'access' => [
                    'class' => AccessControl::class,
                    'only'  => ['logout'],
                    'rules' => [
                        [
                            'actions' => ['logout'],
                            'allow'   => true,
                            'roles'   => ['*'],
                        ],
                    ],
                ],
                'verbs'  => [
                    'class'   => VerbFilter::class,
                    'actions' => [
                        'logout' => ['post'],
                    ],
                ],
            ];
        }
        
        /**
         * {@inheritdoc}
         */
        public function actions()
        {
            return [
                'error'   => [
                    'class' => 'yii\web\ErrorAction',
                ],
                'captcha' => [
                    'class'           => 'yii\captcha\CaptchaAction',
                    'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                ],
            ];
        }
        
        /**
         * Displays homepage.
         *
         * @return string
         */
        public function actionIndex()
        {
            return $this->render('index');
        }
        
        public function actionState()
        {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $user = new User();
            $vm = new VM();
            
            return $this->getState($user, $vm);
        }
        
        public function actionReset()
        {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            
            $w = Wallet::findOne(1);
            if (empty($w))
            {
                $w = new Wallet();
                $w->id = 1;
            }
            $w->count_one = 10;
            $w->count_two = 30;
            $w->count_five = 20;
            $w->count_ten = 15;
            $w->save();
            $w = Wallet::findOne(2);
            if (empty($w))
            {
                $w = new Wallet();
                $w->id = 2;
            }
            $w->count_one = 100;
            $w->count_two = 100;
            $w->count_five = 100;
            $w->count_ten = 100;
            $w->save();
            $w = Wallet::findOne(3);
            if (empty($w))
            {
                $w = new Wallet();
                $w->id = 3;
            }
            $w->count_one = 0;
            $w->count_two = 0;
            $w->count_five = 0;
            $w->count_ten = 0;
            $w->save();
            $p = Product::findOne(1);
            if (empty($p))
            {
                $p = new Product();
                $p->id = 1;
            }
            $p->name = 'tea';
            $p->price = 13;
            $p->count = 10;
            $p->save();
            $p = Product::findOne(2);
            if (empty($p))
            {
                $p = new Product();
                $p->id = 2;
            }
            $p->name = 'coffee';
            $p->price = 18;
            $p->count = 20;
            $p->save();
            $p = Product::findOne(3);
            if (empty($p))
            {
                $p = new Product();
                $p->id = 3;
            }
            $p->name = 'white_coffee';
            $p->price = 21;
            $p->count = 20;
            $p->save();
            $p = Product::findOne(4);
            if (empty($p))
            {
                $p = new Product();
                $p->id = 4;
            }
            $p->name = 'juice';
            $p->price = 35;
            $p->count = 15;
            $p->save();
            
            $user = new User();
            $vm = new VM();
            
            return $this->getState($user, $vm);
        }
        
        public function actionPut()
        {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $denomination = \Yii::$app->request->get('denomination');
            if (empty($denomination))
            {
                return ['status' => 400, 'message' => 'Не указан номинал'];
            }
            $user = new User();
            $vm = new VM();
            
            $vm_wallet = $vm->getWallet();
            $op_vm_wallet = $vm->getOPWallet();
            $user_wallet = $user->getWallet();
            $transaction = \Yii::$app->db->beginTransaction();
            try
            {
                switch ($denomination)
                {
                    case 1:
                        if ($user_wallet->count_one)
                        {
                            $user_wallet->count_one = $user_wallet->count_one - 1;
                            $op_vm_wallet->count_one = $op_vm_wallet->count_one + 1;
                            $user_wallet->save();
                            $op_vm_wallet->save();
                        }
                        else
                        {
                            return ['status' => 400, 'message' => 'Нет монеты'];
                        }
                        break;
                    case 2:
                        if ($user_wallet->count_two)
                        {
                            $user_wallet->count_two = $user_wallet->count_two - 1;
                            $op_vm_wallet->count_two = $op_vm_wallet->count_two + 1;
                            $user_wallet->save();
                            $op_vm_wallet->save();
                        }
                        else
                        {
                            return ['status' => 400, 'message' => 'Нет монеты'];
                        }
                        break;
                    case 5:
                        if ($user_wallet->count_five)
                        {
                            $user_wallet->count_five = $user_wallet->count_five - 1;
                            $op_vm_wallet->count_five = $op_vm_wallet->count_five + 1;
                            $user_wallet->save();
                            $op_vm_wallet->save();
                        }
                        else
                        {
                            return ['status' => 400, 'message' => 'Нет монеты'];
                        }
                        break;
                    case 10:
                        if ($user_wallet->count_ten)
                        {
                            $user_wallet->count_ten = $user_wallet->count_ten - 1;
                            $op_vm_wallet->count_ten = $op_vm_wallet->count_ten + 1;
                            $user_wallet->save();
                            $op_vm_wallet->save();
                        }
                        else
                        {
                            return ['status' => 400, 'message' => 'Нет монеты'];
                        }
                        break;
                }
                $transaction->commit();
            }
            catch (\Exception $e)
            {
                $transaction->rollBack();
                
                return ['status' => 400, 'message' => 'Не удалось'];
            }
            catch (\Throwable $e)
            {
                $transaction->rollBack();
                
                return ['status' => 400, 'message' => 'Не удалось'];
            }
            
            return $this->getState($user, $vm);
        }
        
        public function actionReturn()
        {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $type = \Yii::$app->request->get('type');
            
            $user = new User();
            $vm = new VM();
            
            $vm_wallet = $vm->getWallet();
            $op_vm_wallet = $vm->getOPWallet();
            $user_wallet = $user->getWallet();
            
            $cash = $op_vm_wallet->count_one +
                $op_vm_wallet->count_two * 2 +
                $op_vm_wallet->count_five * 5 +
                $op_vm_wallet->count_ten * 10;
            
            $vm_wallet->put($op_vm_wallet);
            $transaction = \Yii::$app->db->beginTransaction();
            try
            {
                if ($message = $this->processReturn($user_wallet, $vm_wallet, $cash))
                {
                    return ['status' => 400, 'message' => $message];
                }
                
                $user_wallet->save();
                $vm_wallet->save();
                $op_vm_wallet->save();
                
                $transaction->commit();
            }
            catch (\Exception $e)
            {
                $transaction->rollBack();
                
                return ['status' => 400, 'message' => 'Не удалось'];
            }
            catch (\Throwable $e)
            {
                $transaction->rollBack();
                
                return ['status' => 400, 'message' => 'Не удалось'];
            }
            
            return $this->getState($user, $vm);
        }
        
        public function actionOrder()
        {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $type = \Yii::$app->request->get('type');
            if (empty($type))
            {
                return ['status' => 400, 'message' => 'Не указан товар'];
            }
            $user = new User();
            $vm = new VM();
            
            $vm_wallet = $vm->getWallet();
            $op_vm_wallet = $vm->getOPWallet();
            $user_wallet = $user->getWallet();
            $transaction = \Yii::$app->db->beginTransaction();
            try
            {
                switch ($type)
                {
                    case 'tea':
                        $product = $vm->getProducts()->getTea();
                        if ($message = $this->processOrder($user_wallet, $op_vm_wallet, $vm_wallet, $product))
                        {
                            return ['status' => 400, 'message' => $message];
                        }
                        break;
                    case 'coffee':
                        $product = $vm->getProducts()->getCoffee();
                        if ($message = $this->processOrder($user_wallet, $op_vm_wallet, $vm_wallet, $product))
                        {
                            return ['status' => 400, 'message' => $message];
                        }
                        break;
                    case 'white_coffee':
                        $product = $vm->getProducts()->getWhiteCoffee();
                        if ($message = $this->processOrder($user_wallet, $op_vm_wallet, $vm_wallet, $product))
                        {
                            return ['status' => 400, 'message' => $message];
                        }
                        break;
                    case 'juice':
                        $product = $vm->getProducts()->getJuice();
                        if ($message = $this->processOrder($user_wallet, $op_vm_wallet, $vm_wallet, $product))
                        {
                            return ['status' => 400, 'message' => $message];
                        }
                        break;
                }
                
                $product->save();
                $user_wallet->save();
                $vm_wallet->save();
                $op_vm_wallet->save();
                
                $transaction->commit();
            }
            catch (\Exception $e)
            {
                $transaction->rollBack();
                
                return ['status' => 400, 'message' => 'Не удалось'];
            }
            catch (\Throwable $e)
            {
                $transaction->rollBack();
                
                return ['status' => 400, 'message' => 'Не удалось'];
            }
            
            return $this->getState($user, $vm);
        }
        
        /**
         * @param $user User
         * @param $vm   VM
         *
         * @return array
         */
        private function getState($user, $vm)
        {
            $vm_wallet = $vm->getWallet();
            $products = $vm->getProducts();
            $op_vm_wallet = $vm->getOPWallet();
            $user_wallet = $user->getWallet();
            
            return [
                'status' => 200,
                'user'   => [
                    '1'   => $user_wallet->count_one,
                    '2'   => $user_wallet->count_two,
                    '5'   => $user_wallet->count_five,
                    '10'  => $user_wallet->count_ten,
                    'sum' => $user_wallet->getSum(),
                ],
                'vm'     => [
                    'wallet'    => [
                        '1'   => $vm_wallet->count_one,
                        '2'   => $vm_wallet->count_two,
                        '5'   => $vm_wallet->count_five,
                        '10'  => $vm_wallet->count_ten,
                        'sum' => $vm_wallet->getSum(),
                    ],
                    'op_wallet' => [
                        '1'   => $op_vm_wallet->count_one,
                        '2'   => $op_vm_wallet->count_two,
                        '5'   => $op_vm_wallet->count_five,
                        '10'  => $op_vm_wallet->count_ten,
                        'sum' => $op_vm_wallet->getSum(),
                    ],
                    'products'  => [
                        'tea'          => ['price' => $products->getTea()->price, 'count' => $products->getTea()->count],
                        'coffee'       => ['price' => $products->getCoffee()->price, 'count' => $products->getCoffee()->count],
                        'white_coffee' => ['price' => $products->getWhiteCoffee()->price, 'count' => $products->getWhiteCoffee()->count],
                        'juice'        => ['price' => $products->getJuice()->price, 'count' => $products->getJuice()->count],
                    ],
                ],
            ];
        }
        
        /**
         * @param $user_wallet  \app\models\Wallet
         * @param $op_vm_wallet \app\models\Wallet
         * @param $vm_wallet    \app\models\Wallet
         * @param $product      \app\models\Product
         *
         * @return string|boolean
         */
        private function processOrder($user_wallet, $op_vm_wallet, $vm_wallet, $product)
        {
            if (!$product->count)
            {
                return 'Нет товара';
            }
            
            $product->count--;
            
            $cash = $op_vm_wallet->getSum();
            if ($cash < $product->price)
            {
                return "Недостаточно средств";
            }
            
            $for_return = $cash - $product->price;
            $vm_wallet->put($op_vm_wallet);
            
            if ($message = $this->processReturn($user_wallet, $vm_wallet, $for_return))
            {
                return $message;
            }
            
            return false;
        }
        
        /**
         * @param $user_wallet \app\models\Wallet
         * @param $vm_wallet   \app\models\Wallet
         * @param $for_return  int
         *
         * @return bool|string
         */
        private function processReturn($user_wallet, $vm_wallet, $for_return)
        {
            $ten = floor($for_return / 10);
            
            if ($vm_wallet->count_ten < $ten)
            {
                $ten = $vm_wallet->count_ten;
            }
            $five = floor(($for_return - $ten * 10) / 5);
            if ($vm_wallet->count_five < $five)
            {
                $five = $vm_wallet->count_five;
            }
            $two = floor(($for_return - $ten * 10 - $five * 5) / 2);
            if ($vm_wallet->count_two < $two)
            {
                $two = $vm_wallet->count_two;
            }
            $one = $for_return - $ten * 10 - $five * 5 - $two * 2;
            if ($vm_wallet->count_one < $one)
            {
                $one = $vm_wallet->count_one;
                
                return 'Невозможно выдать сдачу';
            }
            
            $vm_wallet->count_ten = $vm_wallet->count_ten - $ten;
            $user_wallet->count_ten = $user_wallet->count_ten + $ten;
            $vm_wallet->count_five = $vm_wallet->count_five - $five;
            $user_wallet->count_five = $user_wallet->count_five + $five;
            $vm_wallet->count_two = $vm_wallet->count_two - $two;
            $user_wallet->count_two = $user_wallet->count_two + $two;
            $vm_wallet->count_one = $vm_wallet->count_one - $one;
            $user_wallet->count_one = $user_wallet->count_one + $one;
            
            return false;
        }
    }
