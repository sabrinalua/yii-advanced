<?php

namespace backend\controllers;

use yii\console\Controller;
use vendor\Util;

class UtilController extends Controller{

	public function actionIndex(){
		$util = new Util;
		$url = "http://feeds.reuters.com/news/artsculture";
		if($util ->visit($url)){
			echo "valid";
		}else{
			echo "nope";
		}
		// echo $d;
	}

}
?>