<?php
class CheduleDeviceController extends AController
{
	public function filters()
	{
		return array(
			'accessControl',
		);
	}
    public function actionIndex()
	{
		$model=new Cheduledevice('search');
		$model->unsetAttributes();
		if(isset($_GET['Cheduledevice']))
			$model->attributes=$_GET['Cheduledevice'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
    public function actionDetail($id){
        $model = $this->loadModel($id);
        $this->render('view',array('model'=>$model));
    }
	public function actionCreate()
	{
		$model=new Cheduledevice;
		if(isset($_POST['Cheduledevice'])){
			$model->attributes=$_POST['Cheduledevice'];
            if($model->save()){
                $this->redirect(array('index'));
            }
		}
		$this->render('create',array(
			'model'=>$model,
		));
	}
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
        if(isset($_POST['Cheduledevice'])){
			$model->attributes=$_POST['Cheduledevice'];
            if($model->save()){
                $this->redirect(array('index'));
            }
		}
        
		$this->render('update',array(
			'model'=>$model,
		));
	}
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
    public function actionStatus($id){
        $data = array();
        $model = $this->loadModel($id);
        if($model->Status == 1){
            $model->Status = 0;
        }else{
            $model->Status = 1;
        }
        $model->save();
        $data['status'] = $model->Status;
        echo json_encode($data);
        if(!isset($_GET['ajax'])){
            $this->redirect(array('index'));
        }
    }
	public function loadModel($id)
	{
		$model=Cheduledevice::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'Không tồn tại sản phẩm này.');
		return $model;
	}
}
