<h2>Login</h2>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
    'htmlOptions'=>array('class'=>'form-horizontal'),
)); ?>
    <div class="alert">
    <?php foreach($model->errors as $error):?>
        <?=$error[0].' <br />';?>
    <?php endforeach;?>
    </div>
	<div class="input">
        <span class="icon">&#xf007;</span>
        <?php echo $form->textField($model,'username', array('class'=>'input-large span10','placeholder'=>'Username')); ?>
	</div>
	<div class="input">
        <span class="icon">&#xf023;</span>
		<?php echo $form->passwordField($model,'password', array('class'=>'input-large span10','placeholder'=>'Password')); ?>
	</div>
	<div class="input submit">	
		<input type="submit" value="Login" />
	</div>
<?php $this->endWidget(); ?>