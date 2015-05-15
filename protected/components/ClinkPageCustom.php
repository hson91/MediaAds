<?php
class ClinkPageCustom extends CLinkPager{
    protected function createPageButton($label,$page,$class,$hidden,$selected)
	{
		if($hidden || $selected)
			$class.=' '.($hidden ? $this->hiddenPageCssClass : $this->selectedPageCssClass);
		return '<li >'.CHtml::link($label,$this->createPageUrl($page),array('class'=>$class)).'</li>';
	}
}
?>