<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class AController extends CController
{
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array('Dashboard'=>array('device/index'));
    public $bgColor = '#9e9e9e';
    public $borderColor = '#c2c2c2';
    public $activeColor = '#3c3c3c';
    public function init(){
        if (isset(Yii::app()->user->role)) {
            if(Yii::app()->user->role == 'user'){
                $this->redirect(Yii::app()->homeUrl);    
                Yii::app()->end();
            }
        }
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
            unset($_GET['pageSize']);
        }
        Yii::app()->clientScript->registerCoreScript('jquery');
        Yii::app()->clientScript->registerCoreScript('jquery.ui');
    }
}