<?php

namespace backend\controllers;

use Yii;
use app\models\FeedSource;
use app\models\FeedSourceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use vendor\simple_html_dom;
use vendor\RssAtomParser;
use vendor\OpenGraph;


/**
 * FeedsourceController implements the CRUD actions for FeedSource model.
 */
class FeedsourceController extends Controller
{
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
     * Lists all FeedSource models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FeedSourceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FeedSource model.
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
     * Creates a new FeedSource model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FeedSource();


        if ($model->load(Yii::$app->request->post())/* && $model->save()*/) {
            $string = str_replace(' ', '', $model->link);
            $link =$string;

            $rss = new RssAtomParser;
            $rss->CDATA='strip';
            $rss->stripHTML=true;

            if($data=$rss->getRootTitle($link)){
                if(!empty($data)){
                    $model->title = $data['title'];

                    $count = (new \yii\db\Query())
                    ->from('feed_source')
                    ->where(['link' => $link])
                    ->count();

                    if($count<1){
                        if($model->save()){
                        return $this->redirect(['view', 'id' => $model->id]);
                        }
                    }else{
                        Yii::$app->session->setFlash('error', $link." already exists in the database.");
                        $this->redirect(['create']);
                    }

                }
            }

            // return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FeedSource model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing FeedSource model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionImport($id){
        echo $id;
    }

    /**
     * Finds the FeedSource model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FeedSource the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FeedSource::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
