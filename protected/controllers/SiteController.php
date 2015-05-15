<?php

class SiteController extends Controller
{
	public function actions(){
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	public function actionIndex(){
	   date_default_timezone_set("Asia/Ho_Chi_Minh");
	   echo time()."<br>";
	   echo date('d-m-Y H:i:s');
	   $this->render('index');
	}
    public function actionError(){
		if($error=Yii::app()->errorHandler->error){
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}else{
		      $this->render('error', $error);
		} 
        //$this->redirect(Yii::app()->baseUrl);
	}
}