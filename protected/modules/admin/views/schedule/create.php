<div class="action">
    <?php echo CHtml::link('<i>&#xf060;</i>Go Back',Yii::app()->baseUrl.'/product',array('class'=>'goback')); ?>
    <h2>THÊM SẢN PHẨM</h2>
</div>
<div class="form">
    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>