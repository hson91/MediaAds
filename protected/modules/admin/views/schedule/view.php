<div class="action">
    <?php echo CHtml::link('<i>&#xf060;</i>Go Back',Yii::app()->baseUrl.'/product',array('class'=>'goback')); ?>
    <h2>THÔNG TIN CHI TIẾT SẢN PHẨM <?php echo $model->UnProductName;?></h2>
</div>
<div class="form" style="position: relative;">
	<div class="controls">
        <div class="label">
            <label class="lbl-form">Mã sản phẩm: </label>
        </div>
        <div class="input">
           <?php echo $model->UnProductCode;?>
        </div>
	</div>
    <div class="controls">
        <div class="label">
            <label class="lbl-form">Loại sản phẩm: </label>
        </div>
        <div class="input">
            <?php
                if($model->typeProduct()){
                    echo Chtml::link($model->typeProduct()->UnTypeProductName,Yii::app()->baseUrl.'/typeProduct/detail/'.$model->typeProduct()->PkTypeProductID);
                }else{
                    echo $model->TypeProductCode;   
                } 
             ?>
            
        </div>
	</div>
	<div class="controls">
        <div class="label">
            <label class="lbl-form">Tên sản phẩm: </label>
        </div>
        <div class="input">
            <?php echo $model->UnProductName; ?>
        </div>
	</div>
	<div class="controls">
        <div class="label">
            <label class="lbl-form">Nhà cung cấp: </label>
        </div>
        <div class="input">
            <?php if($model->supplier){
                    echo Chtml::link($model->supplier->UnSupplierName,Yii::app()->baseUrl.'/supplier/detail/'.$model->supplier->PkSupplier_Id);
                }else{
                    echo 'N/A';   
                } ?>
        </div>
	</div>
	<div class="controls">
        <div class="label">
            <label class="lbl-form">Giá mua vào: </label>
        </div>
        <div class="input">
            <?php echo number_format($model->ProductBuyPrice); ?>
        </div>
	</div>

	<div class="controls">
        <div class="label">
            <label>Giá bán ra: </label>
        </div>
        <div class="input">
            <?php echo number_format($model->ProductSalePrice); ?>
        </div>
	</div>
	<div class="controls">
        <div class="label">
            <label class="lbl-form">Đơn vị tính: </label>
        </div>
        <div class="input">
            <?php echo $model->ProductUnit; ?>
        </div>
	</div>
	<div class="controls">
        <div class="label">
            <label class="lbl-form">Số lượng hiện có</label>
        </div>
        <div class="input">
            <?php echo $model->Quantity; ?>
        </div>
	</div>
	<div class="controls">
        <div class="label">
            <label class="lbl-form">Giới hạn có thể đặt hàng: </label>
        </div>
        <div class="input">
            <?php echo $model->ProductReOderLimit; ?>
        </div>
	</div>
	<div class="controls">
        <div class="label">
            <label class="lbl-form">Sản phẩm được nhập vào ngày : </label>
        </div>
		<div class="input">
            <?php echo date('d/m/Y H:i:s',$model->TimeInsert); ?>
        </div>
	</div>
    <div class="controls">
        <div class="label">
            <label class="lbl-form">Lần nhập kho cuối cùng : </label>
        </div>
		<div class="input">
            <?php echo date('d/m/Y H:i:s',$model->TimeUpdate); ?>
        </div>
	</div>
    <div class="controls">
        <div class="label">
            <label class="lbl-form">Sản phẩm được nhập bởi : </label>
        </div>
		<div class="input">
            <?php echo $model->PersonInsert; ?>
        </div>
	</div>
	<div class="controls">
        <div class="label">
            <label class="lbl-form">Tình trạng: </label>
        </div>
		<div class="input">
            <?php echo Yii::app()->params['status'][$model->Status]; ?>
        </div>
	</div>
	<div class="controls">
        <label class="label" style="display: inline-block;"> &nbsp;</label>
        <div class="input">
            <a href="<?php echo Yii::app()->baseUrl.'/product';?>" class="bnt-form" ><i class="fa">&#xf177; </i> Danh sách</a>
            <a href="<?php echo Yii::app()->baseUrl.'/product/update/'.$model->PkProductID;?>" class="bnt-form" style="margin-left: 5px; white-space:pre" >Chỉnh sửa <i class="fa">&#xf178;</i></a>
        </div>
	</div>
    <?php if($model->ProductQrImage != ''){?>
    <div class="" style="position: absolute;right:20px;width: 160px; text-align: left;">
        <div id="contentPrint">
            <img src="<?php echo Yii::app()->baseUrl.'/data/qrcodeProduct/'.$model->ProductQrImage?>" style="width: 160px; border:1px solid #dcdcdc" />
        </div>
        <a id="btnPrind" class="bnt-form" style="">Print Card</a>
    </div>
    <?php }?>
</div>