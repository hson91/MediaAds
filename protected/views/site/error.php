<section class="page-content">
	<div class="container">
        <div class="row">
            <h2 style="font-size: 18px;color: #f00;padding-top: 20px;float:left;width: 100%;">Error <?=isset($error) ? $error : '404'; ?></h2>
            <p style="color: #f00;padding-bottom:20px"><?=isset($message) ? CHtml::encode($message) : 'Yêu cầu không hợp lệ!'; ?></p>
          <div class="clearfix"></div>
         </div>
    </div>
</div>