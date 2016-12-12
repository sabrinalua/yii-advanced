<?php

//usage:: Yii::$app->runAction('rss', ['idvalue','namevalue'])

namespace backend\controllers;

use yii\console\Controller;
use vendor\simple_html_dom;
use vendor\RssAtomParser;
use vendor\OpenGraph;

use app\models\Feeds;
use app\models\FeedSource;

class RssController extends Controller{

	public function actionIndex($id=null){
		$this->update($id);
	}


	public function update($id=null){
		$start = microtime(true);

		if($id==null){
			$array=$this->getSource();
		}else{
			$array=$this->getSource($id);
		}

		$feeds = $this->getFeeds($array);
		
		if(count($feeds)>0){
			//
		}
		
	}


	public function getSource($id=null){
		$sources= array();

		if($id!=null){
			$model = FeedSource::findOne($id);
			$sources[0]['uid']=$model->id;
			$sources[0]['link']=$model->link;
		}else{
			$model = FeedSource::find()->where(['status' => 'active'])->all();
			$i=0;
			foreach($model as $m){
				$sources[$i]['uid']=$m->id;
				$sources[$i]['link']=$m->link;
				$i++;
			}
		}
		return $sources;
	}

	public function getFeeds($arrays){
		$feed= array();
		$rss = new RssAtomParser;
		$rss->cache_dir="";
		$rss->cache_time=3600;
		$rss->CDATA='strip';
		$rss->stripHTML=true;

		$j=0;
		foreach($arrays as $array){
			$root_id = $array['uid'];
			if($rs=$rss->get($array['link'])){
				$root_type=$rs['type'];
				echo $root_type;

			}
			
			$j++;
		}
	}


	


}

?>