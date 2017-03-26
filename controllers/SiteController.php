<?php

namespace app\controllers;

use app\models\Players;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use app\models\Teams;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public $layout = 'main.twig';
    public $emptyTableText = "Не створено жодної команди";
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
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

    public function actionIndex()
    {

        $this->view->registerCssFile(Url::base(true)."/css/table.css");
        $teams = Teams::find()->orderBy('name')->limit(10)->all();

        $get = Yii::$app->request->get();
        return $this->render(
            'main.twig',
            [
                'title'     =>      'Менеджер футбольних команд',
                'teams'     =>      $teams,
                'nameTable' =>      'Таблиця футбольних команд',
                'emptyTable'=>      $this->emptyTableText,
                'text'      =>      $get['text'],
            ]);
    }
    public function actionCreate()
    {
        $model = new Teams();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['index','emptyTable'=>$this->emptyTableText]);
        } else {
            return $this->render('create.twig', [
                'model' => $model,
                'title' => 'Ввести нового гравця до команди ',
            ]);
        }
    }
    public function actionDel($id)
    {
        $name = '';
        $model = Teams::findOne($id);
        if($model !== null)
        {
            $name = $model['name'];
            $model->delete();
        }
        return $this->redirect(['index', 'text' => 'Видалено команду '.$name]);

    }
    public function actionUp($id)
    {
        $team_id = 0;
        $model = Teams::findOne($id);
        if($model != null)
        {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            } else {
                return $this->render('update.twig', [
                    'model' => $model,
                ]);
            }
        }
    }
}
