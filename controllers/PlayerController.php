<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use app\models\Teams;
use app\models\Players;

class PlayerController extends Controller
{
    /**
     * @inheritdoc
     */

    public $name;
    public $sname;
    public $birthday;
    public $position;

    public $layout = 'main.twig';

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

    public function actionIndex($id)
    {
        //return $this->render('index');
        $this->view->registerCssFile(Url::base(true)."/css/table.css");
        $players = Players::find()->where(['team_id' => $id])->orderBy('name')->limit(10)->all();
        $team = Teams::findOne($id);
        return $this->render(
            'main.twig',['players' => $players,'team'=>$team,'title' => 'Гравці команди '.$team['name'],'emptyTable'=>'В команді немає жодного гравця!']
        );
    }
    public function actionCreate($id)
    {
        $model = new Players();
        $players = Players::find()->where(['team_id' => $id])->orderBy('name')->limit(10)->all();
        $team = Teams::findOne($id);
        $model->team_id = $id;
        $date = $model->birthday;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index','id' => $id, 'title' => 'Ввести нового гравця до команди '.$team['name'], 'team' => $team,'players' => $players,'emptyTable'=>'В команді немає жодного гравця!']);
        } else {
            return $this->render('create.twig', [
                'model' => $model,
                'birth' => $date,
                'title' => 'Ввести нового гравця до команди '.$team['name'],
            ]);
        }
    }
    public function actionDel($id)
    {
        $name = '';
        $team_id = 0;
        $model = Players::findOne($id);
        if($model !== null)
        {
            $name = $model['name'];
            $team_id = $model['team_id'];
            $model->delete();

        }
        return $this->redirect(['index','id' => $team_id, 'text' => 'Видалено гравця '.$name]);

    }
    public function actionUp($id)
    {
        $team_id = 0;
        $model = Players::findOne($id);
        if($model != null)
        {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['index', 'id' => $model['team_id']]);
            } else {
                return $this->render('update.twig', [
                    'model' => $model,
                ]);
            }
        }
    }


}