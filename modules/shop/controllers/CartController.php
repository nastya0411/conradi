<?php

namespace app\modules\shop\controllers;

use app\models\Cart;
use app\models\CartItem;
use app\models\Product;
use app\modules\shop\models\CartSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CartController implements the CRUD actions for Cart model.
 */
class CartController extends Controller
{
    /**
     * @inheritDoc
     */
    // public function behaviors()
    // {
    //     return array_merge(
    //         parent::behaviors(),
    //         [
    //             'verbs' => [
    //                 'class' => VerbFilter::className(),
    //                 'actions' => [
    //                     'delete' => ['POST'],
    //                 ],
    //             ],
    //         ]
    //     );
    // }


    /**
     * Lists all Cart models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CartSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cart model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Cart model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Cart();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Cart model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Cart model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


        public function actionClear($id)
    {
        if ($model = $this->findModel($id)) {
            $model->delete();
            return $this->asJson(['status' => true]);
        }
        return $this->asJson(['status' => false]);
    }

        public function actionCount()
    {
        if ($model = Cart::findOne(['user_id' => Yii::$app->user->id])) {
            return $this->asJson([
                'status' => true,
                'value' => (int)CartItem::find()
                    ->where(['cart_id' => $model->id])
                    ->sum('amount')
            ]);
        } else {
            return $this->asJson([
                'status' => true,
                'value' => 0
            ]);
        }
    }

    public function actionAdd($id)
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    $product = Product::findOne($id);
    
    if (!$product || $product->count < 1) {
        return $this->asJson(['status' => false, 'message' => 'Товар недоступен']);
    }

    $cart = Cart::findOne(['user_id' => Yii::$app->user->id]);
    if (!$cart) {
        $cart = new Cart();
        $cart->user_id = Yii::$app->user->id;
        $cart->cost = 0;
        $cart->amount = 0;
        if (!$cart->save()) {
            return $this->asJson(['status' => false, 'message' => 'Ошибка создания корзины']);
        }
    }

    $cartItem = CartItem::findOne([
        'cart_id' => $cart->id, 
        'product_id' => $id
    ]);
    
    if (!$cartItem) {
        $cartItem = new CartItem();
        $cartItem->cart_id = $cart->id;
        $cartItem->product_id = $product->id;
        $cartItem->amount = 0;
        $cartItem->cost = $product->price; 
        $cartItem->total = 0;
    }

    if ($cartItem->amount >= $product->count) {
        return $this->asJson(['status' => false, 'message' => 'Недостаточно товара на складе']);
    }

    $cartItem->amount++;
    $cartItem->total = $cartItem->amount * $cartItem->cost; 
    
    if (!$cartItem->save()) {
        return $this->asJson(['status' => false, 'message' => 'Ошибка сохранения элемента']);
    }

    $cart->amount++;
    $cart->cost += $product->price;
    
    if (!$cart->save()) {
        return $this->asJson(['status' => false, 'message' => 'Ошибка сохранения корзины']);
    }

    return $this->asJson([
        'status' => true,
        'cartTotal' => $cart->cost,
        'itemsCount' => $cart->amount,
        'itemCount' => $cartItem->amount,
        'itemTotal' => $cartItem->total
    ]);
}

    public function actionItemRemove($id)
    {
        if ($model = CartItem::findOne($id)) {
            $model->delete();
            return $this->asJson(['status' => true]);
        } else {
            return $this->asJson(['status' => false]);
        }
    }

    public function actionItemAdd($id)
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
    $cartItem = CartItem::findOne($id);
    
    if ($cartItem) {
        $product = $cartItem->product;
        
        if ($cartItem->amount >= $product->count) {
            return $this->asJson(['status' => false]);
        }
        
        $cart = $cartItem->cart;
        
        $cartItem->amount++;
        $cartItem->cost += $product->price;
        $cartItem->save();
        
        $cart->amount++;
        $cart->cost += $product->price;
        $cart->save();
        
        return $this->asJson(['status' => true]);
    }
    
    return $this->asJson(['status' => false]);
}

    /**
     * Finds the Cart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Cart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cart::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
