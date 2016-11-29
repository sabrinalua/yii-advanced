<?php

namespace frontend\controllers;

use Yii;

use yii\helpers\Json;

use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\rest\ActiveController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;

use vendor\simple_html_dom;
use vendor\RssAtomParser;
use vendor\OpenGraph;


class ApiController extends ActiveController{
	public $modelClass = "frontend\models\User";
	
	public function actionIndex(){    
//            return $this->renderContent( Json::encode([1,2,3]));
            $this->goHome();
	} 

        //declare supported actions
	public function actions(){
		$actions = parent::actions();
		unset($actions['create'], $actions['update'],$actions['index']);
		return $actions;
	}

	public function actionCreate(){
		print_r($_POST);
		die();
	}
        
        public function actionUpdate($id){
            
        }

}
?>