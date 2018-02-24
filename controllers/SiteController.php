<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\Usuarios;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
     public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'user', 'admin'],
                'rules' => [
                    [
                        //El administrador tiene permisos sobre las siguientes acciones
                        'actions' => ['logout', 'admin'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            //Llamada al método que comprueba si es un administrador
                            return User::isUserAdmin(Yii::$app->user->identity->cedula);
                        },
                    ],
                    [
                       //Los usuarios simples tienen permisos sobre las siguientes acciones
                       'actions' => ['logout', 'user'],
                       'allow' => true,
                       'roles' => ['@'],
                       'matchCallback' => function ($rule, $action) {
                          return User::isUserSimple(Yii::$app->user->identity->cedula);
                      },
                   ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
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

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest)
        {
            if (User::isUserAdmin(Yii::$app->user->identity->cedula))
            {
                return $this->redirect(['ventas-usuarios/index']);
            }
            else
            {
                return $this->redirect(['usuarios/index']);
            }
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) 
        {
            if (User::isUserAdmin(Yii::$app->user->identity->cedula))
            {
                return $this->redirect(['usuarios/index']);
            }
        else
        {
            return $this->redirect(['ventas-usuarios/index']);
        }
   
        } else 
        {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }


    public function actionRegister()
    {
        $model = new Usuarios();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->db->createCommand()
            ->insert('auth_assignment', [
                     'item_name' => 'Usuario',
                     'user_id' => $model->cedula,])
            ->execute();
            Yii::$app->getSession()->setFlash('success', 'Registered Successfully, please login');
            return $this->redirect(['login']);
        } else {
            return $this->render('register', [
                'model' => $model,
            ]);
        }
    }
}
