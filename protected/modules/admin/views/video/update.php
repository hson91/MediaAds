<div class="action">
    <?php echo CHtml::link('<i>&#xf060;</i>Go Back',Yii::app()->baseUrl.'/product/detail/'.$model->PkProductID,array('class'=>'goback')); ?>
    <h2>CẬP NHẬT SẢN PHẨM</h2>
</div>
<div class="form">
    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>