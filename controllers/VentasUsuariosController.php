<?php

namespace app\controllers;

use Yii;
use app\models\VentasUsuarios;
use app\models\VentasUsuariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\models\Productos;


/**
 * VentasUsuariosController implements the CRUD actions for VentasUsuarios model.
 */
class VentasUsuariosController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all VentasUsuarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VentasUsuariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VentasUsuarios model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new VentasUsuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VentasUsuarios();
        $user_id = Yii::$app->user->identity->cedula;
        $model->usuario_id = $user_id;
        $productos = ArrayHelper::map(Productos::find()->all(), 'id', 'descripcion');
        $params = [];
        $producto = [];
        if (Yii::$app->request->post()) {

            $params = Yii::$app->request->post('VentasUsuarios');
            $cantidad = $params['cantidad'];
            $producto = Productos::find()->where(['id'=>$params['producto_id']])->one();

            if ($producto->cantidad < $cantidad) {
                Yii::$app->getSession()->setFlash('error', 'No hay existencias suficientes del producto, contacte con el administrador');
                return $this->render('create', [
                    'model' => $model,
                    'productos' => $productos,
                ]);
            } else {
                $model->cantidad = $cantidad;
                $model->valor = $producto->precio_venta * $cantidad;
                $model->load(Yii::$app->request->post());
                $producto->cantidad= $producto->cantidad - $cantidad;
                $model->save();
                $producto->save();
                if ($model->save() && $producto->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
                }
            }

        
        } else {
            return $this->render('create', [
                'model' => $model,
                'productos' => $productos,
            ]);
        }
    }

    /**
     * Updates an existing VentasUsuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $productos = ArrayHelper::map(Productos::find()->all(), 'id', 'descripcion');
        $params = [];
        $producto = [];
        if (Yii::$app->request->post()) 
        {
            $params = Yii::$app->request->post('VentasUsuarios');
            $cantidad = $params['cantidad'];
            $producto = Productos::find()->where(['id'=>$params['producto_id']])->one();

            if ($producto->cantidad < $cantidad) 
            {
                Yii::$app->getSession()->setFlash('error', 'No hay existencias suficientes del producto, contacte con el administrador');
                return $this->render('create', [
                    'model' => $model,
                    'productos' => $productos,
                ]);
            } else {
                $model->cantidad = $cantidad;
                $model->valor = $producto->precio_venta * $cantidad;
                $model->load(Yii::$app->request->post());
                $producto->cantidad= $producto->cantidad - $cantidad;
                $model->save();
                $producto->save();
                if ($model->save() && $producto->save()) 
                {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }

        } else{
            return $this->render('update', [
                'model' => $model,
                'productos' => $productos,
            ]);
        }
    }

    /**
     * Deletes an existing VentasUsuarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the VentasUsuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VentasUsuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VentasUsuarios::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
