<?php

class UsersController extends AController
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
    
    /*public function accessRules()
	{
        parent::accessRules();
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index', 'detail', 'create', 'update', 'delete', 'deleteList', 'status'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}*/
    
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        $this->breadcrumbs = array($this->ID.' Manager'=>array('index'));
        $model=new Users('search');
        $model->unsetAttributes();
        if(isset($_GET['Users']))
            $model->attributes = $_GET['Users'];
            
        $this->render('index',array(
            'model' => $model
        ));
        
	}
    
    public function actionDetail($id){
        $model = $this->loadModel($id);
        
        if(isset($_GET['ajax'])){
            $this->renderPartial('_detail', array('model'=>$model));
        }else{
            $this->render('detail', array('model'=>$model));
        }
    }
    
    public function actionCreate(){
        $this->breadcrumbs = array($this->ID.' Manager'=>array('index'),'Create'=>array('create'));
        $model = new Users;
        if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
            if($model->validate()){
                $model->password = md5($model->password);
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
        $model->password = '';
        $this->breadcrumbs = array($this->ID.' Manager'=>array('index'),'Update'=>array('update', 'id'=>$id));
        if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
            if($model->validate()){
                if($model->password == ''){
                    $model2 = $this->loadModel($id);
                    $model->password = $model2->password;
                }else{
                    $model->password = md5($model->password);
                }
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
    
    public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
	}
    
    public function actionDeleteList(){
        set_time_limit(0);
        if ($_POST['ids']) {
            $ids = implode(',',$_POST['ids']);
            Yii::app()->db->createCommand()->delete('users','id in ('.$ids.')');
        }
    }
    
    public function loadModel($id)
	{
		$model = Users::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
 }