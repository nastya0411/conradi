<?php

namespace app\modules\admin\controllers;

use app\models\Order;
use app\models\Status;
use app\modules\admin\models\OrderSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrdertController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Order models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
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

        public function actionWork($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            $model->status_id = Status::getStatusId('В сборке');
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Заказ принят в сборку!');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
    }


    

    public function actionApply($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->pay_receipt) {
                $model->status_id = Status::getStatusId('Заказ выдан');
                Yii::$app->session->setFlash('success', 'Заказ успешно выдан!');
            } else {
                $model->status_id = Status::getStatusId('Доставлен');
                Yii::$app->session->setFlash('success', 'Заказ успешно доставлен!');
            }
            if ($model->save(false)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
    }

        public function actionCancel($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            $model->status_id = Status::getStatusId('Отменен');
            if ($model->save(false)) {
                Yii::$app->session->setFlash('warning', 'Заказ отменен!');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
    }


    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
