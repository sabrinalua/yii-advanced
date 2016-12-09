<?php

//usage:: Yii::$app->runAction('rss', ['idvalue','namevalue'])

namespace backend\controllers;

use yii\console\Controller;
use vendor\simple_html_dom;
use vendor\RssAtomParser;
use vendor\OpenGraph;

class RssController extends Controller{

	public function actionIndex($id, $name){
		$this->update($id, $name);
	}

	public function update($id, $name){
		echo $id;
		echo $name;
	}
	


}

?>