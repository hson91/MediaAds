<?php
    class Helpers {
        public static function cListData($model, $key, $value, $empty = ''){
            $empty = array('0'=>$empty!=''?$empty:'-- Choose --');
            return $empty + CHtml::listData($model, $key, $value);   
        }
        
        public static function dropDownLanguage() {
            $result = array();
            foreach (Yii::app()->params['languages'] as $lang) {
                $result[$lang['key']] = $lang['title'];
            }
            return $result;
        }
        
        /**
         * return random array
         */
        public static function shuffle_assoc($array) {
            $keys = array_keys($array);
            shuffle($keys);
            foreach($keys as $key) {
                $new[$key] = $array[$key];
            }
            return $new;
        }
    }
    