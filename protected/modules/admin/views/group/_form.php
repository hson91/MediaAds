<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'TypeProductCode',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->dropDownList($model,'TypeProductCode',$model->listTypeProduct(),array('class'=>'sel-form')); ?>
            <?php echo $form->error($model,'TypeProductCode', array('class'=>'error')); ?>
        </div>
	</div>

	<div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'UnProductCode',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo ($model->allowChangeCode() == true)?($form->textField($model,'UnProductCode',array('size'=>30,'maxlength'=>30,'class'=>'txt-form','oninput'=>'checkCode(this.value + "|'.$this->id.'|'.$model->UnProductCode.'")'))):$model->UnProductCode; ?>
            <label id="messCode"></label>
            <?php echo $form->error($model,'UnProductCode', array('class'=>'error')); ?>
        </div>
	</div>

	<div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'UnProductName',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'UnProductName',array('size'=>60,'maxlength'=>255,'class'=>'txt-form')); ?>
            <?php echo $form->error($model,'UnProductName', array('class'=>'error')); ?>
        </div>
	</div>
    <div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'SupplierId',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->dropDownList($model,'SupplierId',$model->listSupplier(),array('class'=>'sel-form')); ?>
            <?php echo $form->error($model,'SupplierId', array('class'=>'error')); ?>
        </div>
	</div>
	<div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'ProductBuyPrice',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'ProductBuyPrice',array('class'=>'txt-form')); ?>
            <?php echo $form->error($model,'ProductBuyPrice', array('class'=>'error')); ?>
        </div>
	</div>

	<div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'ProductSalePrice',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'ProductSalePrice',array('class'=>'txt-form')); ?>
            <?php echo $form->error($model,'ProductSalePrice', array('class'=>'error')); ?>
        </div>
	</div>

	<div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'ProductReOderLimit',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'ProductReOderLimit',array('class'=>'txt-form')); ?>
            <?php echo $form->error($model,'ProductReOderLimit', array('class'=>'error')); ?>
        </div>
	</div>

	<div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'ProductUnit',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'ProductUnit',array('size'=>60,'maxlength'=>100,'class'=>'txt-form')); ?>
            <?php echo $form->error($model,'ProductUnit', array('class'=>'error')); ?>
        </div>
	</div>

	<div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'Quantity',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'Quantity',array('class'=>'txt-form')); ?>
            <?php echo $form->error($model,'Quantity', array('class'=>'error')); ?>
        </div>
	</div>

	<div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'Status',array('class'=>'lbl-form')); ?>
        </div>
		<div class="input">
            <?php echo $form->dropDownList($model,'Status', Yii::app()->params['status'], array('options' => array($model->Status => array('selected' => 'selected')), 'class'=>'sel-form')); ?>
		  <?php echo $form->error($model,'Status', array('class'=>'error', array('class'=>'error'))); ?>
        </div>
	</div>

	<div class="controls">
        <label class="label" style="display: inline-block;"> &nbsp;</label>
        <div class="input">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Tạo mới' : 'Lưu lại',array('class'=>'bnt-form')); ?>
            <?php echo CHtml::resetButton('Hủy bỏ',array('class'=>'bnt-form','style'=>'margin-left:10px')); ?>
        </div>
	</div>
    <?php if($model->ProductQrImage != null){?>
    <div class="" style="position: absolute;right:20px;width: 160px; text-align: left;">
        <div id="contentPrint">
            <img src="<?php echo Yii::app()->baseUrl.'/data/qrcodeProduct/'.$model->ProductQrImage?>" style="width: 160px; border:1px solid #dcdcdc" />
        </div>
        <a id="btnPrind" class="bnt-form" style="">Print Card</a>
    </div>
    <?php }?>

<?php $this->endWidget(); ?>