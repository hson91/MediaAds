<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->controller->module->assetsUrl;?>/css/style.css" />
    <link rel="stylesheet" href="<?php echo Yii::app()->controller->module->assetsUrl;?>/farbtastic/farbtastic.css" type="text/css" />
	<title><?php echo $this->pageTitle?></title>
    
    <style type="text/css">
        .left, .left ul li a, .home-item a, .bnt-form, .message-show, .filter-external input[type="button"]{background:<?php echo $this->bgColor?>}
        .header, .profiles{border-bottom:2px solid <?php echo $this->bgColor?>}
        .footer{border-top:2px solid <?php echo $this->bgColor?>}
        .action a i, .head i, .filter-external a.download{color:<?php echo $this->bgColor?>}
        .table table thead tr{border-bottom:1px solid <?php echo $this->bgColor?>}
        .pagination ul li.active a{background: <?php echo $this->bgColor?>;border:1px solid <?php echo $this->bgColor?>}
        
        .left ul li a:hover, .home-item a:hover, .left ul li.active a{background:<?php echo $this->activeColor?>}
        .left ul li{border-bottom:1px solid <?php echo $this->borderColor?>}
        
    </style>
    <script type="text/javascript" src="<?php echo Yii::app()->controller->module->assetsUrl;?>/js/app.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->controller->module->assetsUrl;?>/js/status.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->controller->module->assetsUrl;?>/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->controller->module->assetsUrl;?>/js/app.js"></script>
    <script type="text/javascript">
        var url = '<?php echo Yii::app()->baseUrl;?>/admin';
        var sss = '<?php echo Yii::app()->controller->module->assetsUrl;?>';
    </script>
</head>
<body>
    <div class="message-show"></div>
    <div class="header">
        <div class="h-left">
            <a href="<?php echo Yii::app()->baseUrl?>/admin">Admin Dashboard</a>
        </div>
        <div class="h-right">
            <span><?php echo Yii::app()->user->getState('fullname');?></span>
            <div class="user-action">
                <i>&#xf0c9;</i>
                <div class="profiles">
                    <div class="profile"><a href="<?php echo Yii::app()->baseUrl?>/admin/site/profiles">Profile</a></div>
                    <div class="profile"><a href="<?php echo Yii::app()->baseUrl?>/admin/site/profiles">Change Password</a></div>
                    <div class="profile"><a href="<?php echo Yii::app()->baseUrl?>/admin/site/logout">Logout</a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="left">
            <?php
                $cMenu = array();
                $cMenu[] = array('label'=>'<i>&#xf0e4;</i><span>Dashboard</span>', 'url'=>array('device/index'), 'active'=>$this->ID == 'site');
                $cMenu[] = array('label'=>'<i>&#xf073;</i><span>Schedule</span>', 'url'=>array('schedule/index'), 'active'=>$this->ID == 'schedule');
                $cMenu[] = array('label'=>'<i>&#xf03d;</i><span>Video</span>', 'url'=>array('video/index'), 'active'=>$this->ID == 'video');
                $cMenu[] = array('label'=>'<i>&#xf00a;</i><span>Group</span>', 'url'=>array('group/index'), 'active'=>$this->ID == 'group');
                $cMenu[] = array('label'=>'<i>&#xf0e0;</i><span>Device</span>', 'url'=>array('device/index'), 'active'=>$this->ID == 'device');
                $cMenu[] = array('label'=>'<i>&#xf013;</i><span>Setting </span>', 'url'=>array('configs/index'), 'active'=>$this->ID == 'configs');
                $cMenu[] = array('label'=>'<i>&#xf016;</i><span>Log</span>', 'url'=>array('log/index'), 'active'=>$this->ID == 'log');
            ?>
			<?php $this->widget('zii.widgets.CMenu', array(
				'encodeLabel'=>false,
				'items'=>$cMenu));
			?>
        </div>
        <div class="right">
            <?php echo $content?>
        </div>
    </div>
    <div class="footer">
        <span>&COPY 2014 by KHOI SANG COMPANY </span>
    </div>
</body>
</html>