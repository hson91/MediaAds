<?php

class RolesController extends AController
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
				'actions'=>array('index', 'create', 'update', 'delete', 'deleteList', 'status'),
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
        $model=new Roles('search');
        $model->unsetAttributes();
        if(isset($_GET['Roles']))
            $model->attributes = $_GET['Roles'];
            
        $this->render('index',array(
            'model' => $model
        ));
        
	}
    
    public function actionCreate(){
        $this->breadcrumbs = array($this->ID.' Manager'=>array('index'),'Create'=>array('create'));
        $model = new Roles;
        if(isset($_POST['Roles']))
		{
			$model->attributes=$_POST['Roles'];
            
            if($model->validate()){
                $model->save();
                Yii::app()->db->createCommand('insert into authitem(name, type, description) values(:name, 2, :description)')->execute(array(':name'=>$model->alias, ':description'=>$model->title));
                $this->redirect(array('roles/index'));
            }
        }
		$this->render('create',array(
			'model'=>$model,
		));
    }
    
    public function actionUpdate($id){
        $model = $this->loadModel($id);
        $oldModel = new Roles;
        $oldModel->attributes = $model->attributes;
        $this->breadcrumbs = array($this->ID.' Manager'=>array('index'),'Update'=>array('update', 'id'=>$id));
        if(isset($_POST['Roles']))
		{
			$model->attributes=$_POST['Roles'];
            if($model->validate()){
                $model->save();
                Yii::app()->db->createCommand('update authitem set description = :title, name = :alias where name = :oldAlias')->execute(array(':title' => $model->title, ':alias' => $model->alias, 'oldAlias' => $oldModel->alias));
                $this->redirect(array('roles/index'));
            }
        }
		$this->render('create',array(
			'model'=>$model,
		));
    }
    
    public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
	}
    
    public function actionDeleteList(){
        set_time_limit(0);
        if ($_POST['ids']) {
            $ids = implode(',',$_POST['ids']);
            Yii::app()->db->createCommand()->delete('roles','id in ('.$ids.')');
        }
    }
    
    public function loadModel($id)
	{
		$model = Roles::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
 }