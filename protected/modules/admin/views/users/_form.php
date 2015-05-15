<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'data-form',
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array(
        'enctype'=>'multipart/form-data'
    )
)); ?>
<div class="controls">
    <div class="label">
        <?=$form->labelEx($model,'username', array('class'=>'lbl-form')); ?>
    </div>
    <div class="input">
        <?=$form->textField($model,'username',array('class'=>'txt-form')); ?>
        <?=$form->error($model,'username', array('class'=>'error'));?>
    </div>
</div>

<div class="controls">
    <div class="label">
        <?=$form->labelEx($model,'password', array('class'=>'lbl-form')); ?>
    </div>
    <div class="input">
        <?=$form->passwordField($model,'password',array('class'=>'txt-form')); ?>
        <?=$form->error($model,'password', array('class'=>'error'));?>
    </div>
</div>

<div class="controls">
    <div class="label">
        <?=$form->labelEx($model,'roles', array('class'=>'lbl-form')); ?>
    </div>
    <div class="input">
        <?=$form->dropDownList($model,'roles', CHtml::listData(Roles::model()->findAll(),'id','title'), array('options' => array($model->scenario == 'insert'?3:$model->roles => array('selected' => 'selected')), 'class'=>'sel-form')); ?>
        <?=$form->error($model,'roles', array('class'=>'error'));?>
    </div>
</div>

<div class="controls">
    <div class="label">
        <?=$form->labelEx($model,'status', array('class'=>'lbl-form')); ?>
    </div>
    <div class="input">
        <?=$form->dropDownList($model,'status', Yii::app()->params['status'], array('options' => array(1 => array('selected' => 'selected')), 'class'=>'sel-form')); ?>
        <?=$form->error($model,'status', array('class'=>'error'));?>
    </div>
</div>

<div class="controls">
    <div class="label">
        <?=$form->labelEx($model,'fullname', array('class'=>'lbl-form')); ?>
    </div>
    <div class="input">
        <?=$form->textField($model,'fullname',array('class'=>'txt-form')); ?>
        <?=$form->error($model,'fullname', array('class'=>'error'));?>
    </div>
</div>

<div class="controls">
    <div class="label">
        <?=$form->labelEx($model,'email', array('class'=>'lbl-form')); ?>
    </div>
    <div class="input">
        <?=$form->textField($model,'email',array('class'=>'txt-form')); ?>
        <?=$form->error($model,'email', array('class'=>'error'));?>
    </div>
</div>

<div class="controls">
    <div class="label">
        <?=$form->labelEx($model,'phone', array('class'=>'lbl-form')); ?>
    </div>
    <div class="input">
        <?=$form->textField($model,'phone',array('class'=>'txt-form')); ?>
        <?=$form->error($model,'phone', array('class'=>'error'));?>
    </div>
</div>

<div class="controls">
    <div class="label">
        <?=$form->labelEx($model,'address', array('class'=>'lbl-form')); ?>
    </div>
    <div class="input">
        <?=$form->textField($model,'address',array('class'=>'txt-form')); ?>
        <?=$form->error($model,'address', array('class'=>'error'));?>
    </div>
</div>

<div class="controls">
    <div class="label">
        <?=$form->labelEx($model,'dob', array('class'=>'lbl-form')); ?>
    </div>
    <div class="input">
        <?=$form->textField($model,'dob',array('class'=>'txt-form')); ?>
        <?=$form->error($model,'dob', array('class'=>'error'));?>
    </div>
</div>

<div class="controls">
    <div class="label">
        <?=$form->labelEx($model,'yahoo', array('class'=>'lbl-form')); ?>
    </div>
    <div class="input">
        <?=$form->textField($model,'yahoo',array('class'=>'txt-form')); ?>
        <?=$form->error($model,'yahoo', array('class'=>'error'));?>
    </div>
</div>

<div class="controls">
    <div class="label">
        <?=$form->labelEx($model,'skype', array('class'=>'lbl-form')); ?>
    </div>
    <div class="input">
        <?=$form->textField($model,'skype',array('class'=>'txt-form')); ?>
        <?=$form->error($model,'skype', array('class'=>'error'));?>
    </div>
</div>

<div class="controls">
    <div class="label">&nbsp;</div>
    <div class="input">
        <?=CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save Change', array('class'=>'bnt-form')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>