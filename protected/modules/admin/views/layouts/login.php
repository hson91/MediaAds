<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>LOGIN ADMIN SYSTEM</title>
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="<?=Yii::app()->controller->module->assetsUrl;?>/css/login-style.css" />
</head>

<body>
    <div class="wrapper">
        <div class="main">
            <div class="content">
                <div class="header">
                    <a href="<?=Yii::app()->getBaseUrl(true)?>">&#xf015;</a>
                </div>
        	    <?php echo $content; ?>
            </div>
        </div>
    </div>
</body>
</html>
