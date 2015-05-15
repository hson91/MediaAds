<?php $form = $this->beginWidget('CActiveForm', array(
    	'id'=>'product-form',
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
            <?php echo $form->labelEx($model,'deviceName',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'deviceName',array('size'=>60,'maxlength'=>255,'class'=>'txt-form')); ?>
            <?php echo $form->error($model,'deviceName', array('class'=>'error')); ?>
        </div>
	</div>
    
    <div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'tokenID',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'tokenID',array('size'=>60,'maxlength'=>255,'class'=>'txt-form')); ?>
            <?php echo $form->error($model,'tokenID', array('class'=>'error')); ?>
        </div>
	</div>
    
    <div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'deviceProducers',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'deviceProducers',array('size'=>60,'maxlength'=>255,'class'=>'txt-form')); ?>
            <?php echo $form->error($model,'deviceProducers', array('class'=>'error')); ?>
        </div>
	</div>
    
    <div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'deviceOS',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->dropDownList($model,'deviceOS', Yii::app()->params['device_os'], array('options' => array($model->deviceOS => array('selected' => 'selected')), 'class'=>'sel-form')); ?>
            <?php echo $form->error($model,'deviceOS', array('class'=>'error')); ?>
        </div>
	</div>
    
    <div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'versionOS',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'versionOS',array('size'=>60,'maxlength'=>20,'class'=>'txt-form')); ?>
            <?php echo $form->error($model,'versionOS', array('class'=>'error')); ?>
        </div>
	</div>
    
    <div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'versionApp',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'versionApp',array('size'=>60,'maxlength'=>20,'class'=>'txt-form')); ?>
            <?php echo $form->error($model,'versionApp', array('class'=>'error')); ?>
        </div>
	</div>
    
    <div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'deviceWidth',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'deviceWidth',array('size'=>60,'maxlength'=>10,'class'=>'txt-form')); ?>
            <?php echo $form->error($model,'deviceWidth', array('class'=>'error')); ?>
        </div>
	</div>
    
    <div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'deviceHeight',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'deviceHeight',array('size'=>60,'maxlength'=>10,'class'=>'txt-form')); ?>
            <?php echo $form->error($model,'deviceHeight', array('class'=>'error')); ?>
        </div>
	</div>
    
    <div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'textNotification',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textArea($model,'textNotification',array('maxlength'=>255,'class'=>'txtare-form','style'=>'width:40%;resize:none')); ?>
            <?php echo $form->error($model,'textNotification', array('class'=>'error')); ?>
        </div>
	</div>
    
	<div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'deviceStatus',array('class'=>'lbl-form')); ?>
        </div>
		<div class="input">
            <?php echo $form->dropDownList($model,'deviceStatus', Yii::app()->params['status'], array('options' => array($model->deviceStatus => array('selected' => 'selected')), 'class'=>'sel-form')); ?>
		    <?php echo $form->error($model,'deviceStatus', array('class'=>'error', array('class'=>'error'))); ?>
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