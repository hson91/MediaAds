<?php
class Controller extends CController
{
	public $layout='main';
    public function init() {
        parent::init();
    }
    
    protected function beforeRender($view) {
        return true;
    }

    protected function afterRender($view, &$output) {
        parent::afterRender($view,$output);
        return true;
    }
}