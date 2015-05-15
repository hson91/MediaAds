<?php

class SiteController extends AController
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
            'upload'=>'application.modules.admin.controllers.upload.UploadFileAction',
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
            array('allow',
                'actions'=>array('login'),
                'users'=>array('*'),
            ),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','logout','error','profiles','upload','CreateRoles','loadUnits','loadActivities','loadSkills'),
				'users'=>array('@'),
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
	   $this->pageTitle = "PHONE REPAIR - SYSTEM MANAGEMENT";
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	   
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
        $this->layout = 'login';
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()) {
			     if (Yii::app()->user->role == 'user') {
			         $this->redirect(Yii::app()->homeUrl);    
                     Yii::app()->end();
			     } 
			     $this->redirect(Yii::app()->homeUrl.'admin');
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
    
    /**
	 * Displays the login page
	 */
	public function actionProfiles()
	{
        $this->layout = 'login';
		$model=Users::model()->findByPk(Yii::app()->user->id);
		if(isset($_POST['ajax']) && $_POST['ajax']==='profiles-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['update']))
		{ 
			$model->attributes=$_POST['Users'];
            if($model->validate()){
                $validate = true;
                $flash = '';
                if ($_POST['new_password'] != '') {
                    $old_password = $_POST['old_password'];
                    $new_password = $_POST['new_password'];
                    $confirm_password = $_POST['confirm_password'];
                    if ($old_password == ''){
                        $flash .= 'Password old can not be blank.<br />';
                        $validate = false;
                    }
                    
                    if ($confirm_password == '') {
                        $flash .= 'Confirm password can not be blank.<br />';
                        $validate = false;
                    }
                    
                    if ($old_password != '' && $new_password != '' && $confirm_password != '') {
                        if ($model->password!==md5($old_password)) {
                            $flash .= 'Password old incorrect.<br />';
                            $validate = false;
                        } else {
                            if ($new_password!==$confirm_password) {
                                $flash .= 'Confirm password incorrect.<br />';
                                $validate = false;
                            }    
                        }
                    }
                    if ($validate) {
                        if ($old_password!=$new_password) {
                            $model->password=md5($_POST['new_password']);
                        }
                    }
                }
                if($model->save() && $validate) {
                    Yii::app()->user->setFlash('profiles','Update profile success!');
                    $this->refresh();
                } else {
                    Yii::app()->user->setFlash('error',$flash);
                }
            }else{
                $flash = '';
                foreach($model->errors as $key => $error){
                    foreach($error as $value){
                        $flash .= $value.'<br/>';
                    }
                }
                Yii::app()->user->setFlash('error',$flash);
            }
		}
		$this->render('profiles',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
        $roleAssigned = Yii::app()->authManager->getRoles(Yii::app()->user->id);
 
        if (!empty($roleAssigned)) { //checks that there are assigned roles
            $auth = Yii::app()->authManager; //initializes the authManager
            foreach ($roleAssigned as $n => $role) {
                if ($auth->revoke($n, Yii::app()->user->id)) //remove each assigned role for this user
                Yii::app()->authManager->save(); //again always save the result
            }
        }
     
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->baseUrl.'/admin/login');
	}
    
    public function actionCreateRoles(){
        $auth = Yii::app()->authManager;
        $auth->clearAll();
        foreach (Yii::app()->params['users.roles'] as $k=>$v) {
            $auth->createRole($k, $v);    
        }
        $this->redirect('login');
    }
    
    public function actionLoadUnits(){
        $id = Yii::app()->request->getParam('id', 0);
    
        $units = Units::model()->findAll('course_id=:course_id', array(':course_id'=>(int) $id));
        
        $data = Helpers::clistData($units,'id','title');
        foreach($data as $value=>$name) {
            echo CHtml::tag('option',
                array('value'=>$value),CHtml::encode($name),true);
        }
        Yii::app()->end();
    }
    
    public function actionLoadActivities(){
        $id = Yii::app()->request->getParam('id', 0);
    
        $activities = Activities::model()->findAll('unit_id=:unit_id', array(':unit_id'=>(int) $id));
        
        $data = Helpers::clistData($activities,'id','title');
        foreach($data as $value=>$name) {
            echo CHtml::tag('option',
                array('value'=>$value),CHtml::encode($name),true);
        }
        Yii::app()->end();
    }
    
    public function actionLoadSkills(){
        $id = Yii::app()->request->getParam('id', 0);
    
        $skills = Skills::model()->with('skillType')->findAll('activity_id=:activity_id', array(':activity_id'=>(int) $id));
        
        $data = Helpers::clistData($skills,'id','title');
        foreach($data as $value=>$name) {
            echo CHtml::tag('option',
                array('value'=>$value),CHtml::encode($name),true);
        }
        Yii::app()->end();
    }
}