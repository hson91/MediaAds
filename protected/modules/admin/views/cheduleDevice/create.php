<div class="action">
    <?php echo CHtml::link('<i>&#xf060;</i>Go Back',Yii::app()->baseUrl.'/admin/cheduledevice',array('class'=>'goback')); ?>
    <h2>THÊM SCHEDULE DEVICE</h2>
</div>
<div class="form">
    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>