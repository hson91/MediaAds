<?php

class ConfigsController extends AController
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
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
            'upload'=>'application.controllers.upload.UploadFileAction',
		);
	}
    /**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}
    
    public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','index','update','status'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
    
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        $this->breadcrumbs = array($this->ID.' Manager'=>array('index'));
        $model=new Configs('search');
        $model->unsetAttributes();
        if(isset($_GET['Configs']))
            $model->attributes = $_GET['Configs'];
        $this->render('index',array(
            'model' => $model
        ));
        
	}
    
    public function actionCreate(){
        $this->breadcrumbs = array($this->ID.' Manager'=>array('index'),'Create'=>array('create')); 
        $model = new Configs();
        if(isset($_POST['Configs'])){
			$model->attributes=$_POST['Configs'];
            if($model->validate()){
                $model->save();
                $this->redirect(array('index'));
            }
        }
		$this->render('create',array(
			'model'=>$model,
		));
    }
    
    public function actionUpdate($id){
        $model = $this->loadModel($id);
        $this->breadcrumbs = array($this->ID.' Manager'=>array('index'),'Update'=>array('update', 'id'=>$id));
        if(isset($_POST['Configs']))
		{
			$model->attributes=$_POST['Configs'];
            
            if($model->validate()){
                $model->save();
                $this->redirect(array('index'));
            }
        }
		$this->render('create',array(
			'model'=>$model,
		));
    }
    
    public function actionStatus($id = null){
        $data = array();
        $model = $this->loadModel($id);
        if($model->status == 1){
            $model->status = 0;
        }else{
            $model->status = 1;
        }
        $model->save();
        $data['status'] = $model->status;
        echo json_encode($data);
        if(!isset($_GET['ajax'])){
            $this->redirect(array('index'));
        }
    }
    public function loadModel($id)
	{
		$model = Configs::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
    public function loadModelWithAlias($alias){
        $model = Configs::model()->findByAttributes(array('alias'=>$alias));
        if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
    }
 }