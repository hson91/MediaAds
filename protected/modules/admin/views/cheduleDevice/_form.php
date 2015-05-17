<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cheduledevice-form',
	'enableAjaxValidation'=>false,
)); ?>
    
    <div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'deviceID',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'deviceID',array('size'=>60,'maxlength'=>255,'class'=>'txt-form','oninput'=>'checkCode(this.value + "|'.$this->id.'|'.$model->deviceID.'")')); ?>
            <label id="messCode"></label>
            <?php echo $form->error($model,'deviceID', array('class'=>'error')); ?>
        </div>
    </div>

    <div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'scheduleID',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'scheduleID',array('size'=>60,'maxlength'=>11,'class'=>'txt-form')); ?>
            <?php echo $form->error($model,'scheduleID', array('class'=>'error')); ?>
        </div>
    </div>

    <div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'timeStart',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model, 'timeStart', array('size'=>60,'maxlength'=>11,'class'=>'txt-form','placeholder'=>'hh:mm:ss')); ?>
            <?php echo $form->error($model,'timeStart', array('class'=>'error')); ?>
        </div>
    </div>

    <div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'timeEnd',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model, 'timeEnd', array('size'=>60,'maxlength'=>11,'class'=>'txt-form','placeholder'=>'hh:mm:ss')); ?>
            <?php echo $form->error($model,'timeEnd', array('class'=>'error')); ?>
        </div>
    </div>
    
    <div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'flagExpire',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'flagExpire',array('size'=>60,'maxlength'=>255,'class'=>'txt-form')); ?>            
            <?php echo $form->error($model,'flagExpire', array('class'=>'error')); ?>
        </div>
    </div>
    
   <div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'flagDelete',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'flagDelete',array('size'=>60,'maxlength'=>255,'class'=>'txt-form')); ?>            
            <?php echo $form->error($model,'flagDelete', array('class'=>'error')); ?>
        </div>
    </div>

    <div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'status',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'status',array('size'=>60,'maxlength'=>255,'class'=>'txt-form')); ?>            
            <?php echo $form->error($model,'status', array('class'=>'error')); ?>
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