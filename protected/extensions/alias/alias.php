<?php
    class Alias extends CWidget{
        public $model = null;
        public $source = 'title';
        public $target = 'alias';
        
        public function init() {
            if ($this->model !== null) {
                $this->source = get_class($this->model).'_'.$this->source;
                $this->target = get_class($this->model).'_'.$this->target;
            }
        }
        
        public function run() {
            $this->registerCoreScript();
        }
        
        public function registerCoreScript(){
            $skin = dirname(__FILE__).DIRECTORY_SEPARATOR.'assets';
            $baseUrl = Yii::app()->getAssetManager()->publish($skin);
            $cs = Yii::app()->clientScript;
            $script = "$('#{$this->source}').mbAlias({target:'#{$this->target}'});";
            $cs->registerCoreScript('jquery')
                ->registerScriptFile($baseUrl.'/string.toAlias.js')
                ->registerScriptFile($baseUrl.'/jquery.alias.js')
                ->registerScript($this->target, $script, CClientScript::POS_READY);
        }
    }