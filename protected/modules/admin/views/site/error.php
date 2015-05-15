<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>
<h2 class="error-code">Error <?php echo $code; ?></h2>
<span><?php echo CHtml::encode($message); ?></span>