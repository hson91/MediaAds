<div class="head board-green">
    <img src="<?=Yii::app()->theme->baseUrl?>/images/websites/globe.png" />
    <span><?=$this->getUniqueId();?> Detail</span>
</div>
<?php $this->renderPartial('_detail', array('model'=>$model)); ?>