<?php
class DeviceController extends AController
{
	public function filters()
	{
		return array(
			'accessControl',
		);
	}
    public function actionIndex()
	{
		$model=new Device('search');
		$model->unsetAttributes();
		if(isset($_GET['Device']))
			$model->attributes=$_GET['Device'];
		$this->render('index',array('model'=>$model));
	}
    public function actionDetail($id){
        $model = $this->loadModel($id);
        // $this->render('view',array('model'=>$model));
        $this->redirect(array('cheduledevice/create/'));
    }
	public function actionCreate(){
		$model = new Device;
		if(isset($_POST['Device'])){
			$model->attributes=$_POST['Device'];
            if($model->save()){
                $this->redirect(array('index'));
            }
		}
		$this->render('create',array('model'=>$model));
	}
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
        if(isset($_POST['Device'])){
			$model->attributes=$_POST['Device'];
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
        if($model->deviceStatus == 1){
            $model->deviceStatus = 0;
        }else{
            $model->deviceStatus = 1;
        }
        $model->save();
        $data['status'] = $model->deviceStatus;
        echo json_encode($data);
        if(!isset($_GET['ajax'])){
            $this->redirect(array('index'));
        }
    }
    public function actionCheckCode($codeOld = null,$code =  null,$ajax = true){
        if(isset($_POST['code']) || $code != null){
            $alias = isset($_POST['code'])?$_POST['code']:$code;
            if(isset($_POST['codeOld'])){$codeOld = $_POST['codeOld'];}
            if($codeOld != null && $codeOld == $alias){
                if(Yii::app()->request->isAjaxRequest && $ajax == true){
                    echo '<span class="fa" style="color:#1AD20D; font-size:18px" title="Mã hợp lệ">&#xf00c; </span><span style="color:blue"> Mã thiết bị không thay đổi</span>|1';
                    Yii::app()->end();
                }
                return true;
            }
            if(strlen($alias) == 0){
                if(Yii::app()->request->isAjaxRequest  && $ajax == true){
                    echo '<span class="fa" style="color:red; font-size:18px" title="Mã không hợp lệ">&#xf05c; </span><b style="color:red; font-size:12px"> Mã thiết bị không được để trống </b>|0';
                    Yii::app()->end();
                }
                return false;
            }
            $model = $this->loadModelByCode($alias); 
            if($model != null){
                if(Yii::app()->request->isAjaxRequest  && $ajax == true){
                    echo '<span class="fa" style="color:red; font-size:18px" title="Mã không hợp lệ">&#xf05c; </span><b style="color:red; font-size:12px">"'.$alias.'" đã tồn tại </b>|0';
                    Yii::app()->end();
                }
                return false;
            }else{
                if(Yii::app()->request->isAjaxRequest  && $ajax == true){
                    echo '<span class="fa" style="color:#1AD20D; font-size:18px" title="Mã hợp lệ">&#xf05d; </span><span style="color:blue">Mã thiết bị hợp lệ</span>|1';
                    Yii::app()->end();
                }
                return true;
            }
        }else{
            if(Yii::app()->request->isAjaxRequest  && $ajax == true){
                    echo '<span class="fa" style="color:red; font-size:18px" title="Mã không hợp lệ">&#xf05c;</span><b style="color:red">Mã thiết bị không được để trống|0</b>';
                    Yii::app()->end();
                }
        }
        return false;
    }
    public function loadModelByCode($alias)
	{
		$model=Device::model()->find('deviceID = :deviceID',array(':deviceID' => $alias));
		return $model;
	}
	public function loadModel($id)
	{
		$model=Device::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'Không tồn tại sản phẩm này.');
		return $model;
	}
}
