<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'video-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'videoName',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'videoName',array('size'=>60,'maxlength'=>255,'class'=>'txt-form')); ?>
            <?php echo $form->error($model,'videoName', array('class'=>'error')); ?>
        </div>
    </div>
    <div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'description',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textArea($model,'description',array('maxlength'=>255,'class'=>'txtare-form','style'=>'width:40%;resize:none')); ?>
            <?php echo $form->error($model,'description', array('class'=>'error')); ?>
        </div>
    </div>
	<div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'videoStatus',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'videoStatus',array('class'=>'txt-form')); ?>
            <?php echo $form->error($model,'videoStatus', array('class'=>'error')); ?>
        </div>
	</div>

	<div class="controls">
        <label class="label" style="display: inline-block;"> &nbsp;</label>
        <div class="input">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Tạo mới' : 'Lưu lại',array('class'=>'bnt-form')); ?>
            <?php echo CHtml::resetButton('Hủy bỏ',array('class'=>'bnt-form','style'=>'margin-left:10px')); ?>
        </div>
	</div>

<?php $this->endWidget(); ?>