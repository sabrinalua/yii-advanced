<?php

namespace backend\command;

use yii\console\Controller;
use vendor\simple_html_dom;
use vendor\RssAtomParser;
use vendor\OpenGraph;

class RssController extends Controller{

	//usage:: Yii::$app->runAction('rss/update', ['idvalue','namevalue'])
	public function actionUpdate($id, $name){
		echo $id;
		echo $name;
	}
}

?>