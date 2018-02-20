<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Source;
use frontend\models\SourceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SourceController implements the CRUD actions for Source model.
 */
class SourceController extends Controller
{

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Source models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SourceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Source model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionAbout()
    {
        $this->enableCsrfValidation = false;

        $model = new Source();
        $model = Source::find()->asArray()->orderBy(['forsort' => SORT_DESC])->all();

        foreach ($model as $m) {

        /*список ресурсов откуда брать информацию для каждого свой обработчик */
            switch ($m['marker']) {
                case 'ecb':
                    $data[]=["currency"=> SourceController::actionEcb($m['url']),"url"=>$m['marker']];
                    break;
                case 'daily':
                    $data[]=["currency"=> SourceController::actionDayli($m['url']),"url"=>$m['marker']];
            }
        }

        if(Yii::$app->request->post('json')=='go'){
            return json_encode($data);
        }else{
            return $this->render('about', [
                'data' => $data,

            ]);

        }


    }
    /* обработчик для ресурса www.ecb.europa.*/
    private function actionEcb($url)
    {

        $page = @simplexml_load_file($url);
        if ($page) {
            /*поиск элемента RUB */
            foreach ($page->Cube->Cube->Cube as $a) {
                if ($a['currency'] == 'RUB') {
                    return (string)$a['rate'];
                }
            }
        } else {
            return 'ошибка';
        }

    }

    /* обработчик для ресурса cbr-xml-daily.ru.*/
    private function actionDayli($url)
    {
        $json = @file_get_contents($url);
        if ($json) {
            $obj = json_decode($json);
            return $obj->Valute->EUR->Value;
        } else {
            return 'ошибка';
        }

    }

    /**
     * Creates a new Source model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Source();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Source model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Source model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Source model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Source the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Source::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
