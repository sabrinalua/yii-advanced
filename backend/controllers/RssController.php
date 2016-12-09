<?php

namespace backend\controllers;

use yii\console\Controller;
use vendor\simple_html_dom;
use vendor\RssAtomParser;
use vendor\OpenGraph;

class RssController extends Controller{

	public function actionUpdate($id, $name){
		echo $id;
		echo $name;
	}
}

?>