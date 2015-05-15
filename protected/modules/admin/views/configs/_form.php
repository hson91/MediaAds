<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'data-form',
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array(
        'enctype'=>'multipart/form-data'
    )
)); ?>

<div class="controls">
    <div class="label">
        <?=$form->labelEx($model,'title', array('class'=>'lbl-form')); ?>
    </div>
    <div class="input">
        <?=$form->textField($model,'title',array('class'=>'txt-form')); ?>
        <?=$form->error($model,'title', array('class'=>'error'));?>
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
<?php if($model->is_textarea == 0):?>
<div class="controls">
    <div class="label">
        <?=$form->labelEx($model,'value', array('class'=>'lbl-form')); ?>
    </div>
    <div class="input">
        <?=$form->textArea($model, 'value', array('class'=>'txtare-form'));?>
        <?=$form->error($model,'value',array('class'=>'error'));?>
    </div>
</div>

<?php else:?>
<div class="controls">
    <div class="label">
        <?=$form->labelEx($model,'value', array('class'=>'lbl-form')); ?>
    </div>
    <div class="input">
        <?php
            $this->widget('ext.ckeditor.CKEditor', array(
                'model'=>$model,
                'attribute'=>'value', // model atribute
                'editorTemplate'=>'full', // Toolbar settings (full, basic, advanced)
                
            ));
         ?>
        <?=$form->error($model,'description',array('class'=>'error'));?>
    </div>
</div>
<?php endif;?>

<div class="controls">
    <div class="label">&nbsp;</div>
    <div class="input">
        <?=CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save Change', array('class'=>'bnt-form')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>