<div class="action">
    <?php echo CHtml::ajaxLink('<i>&#xf055;</i>Thêm Mới', array('addRow'),array(
        'type'=>'post',
        'beforeSend' => 'function(){if(flagRunning == false){$("body").css("cursor", "wait");flagRunning = true;}else{openNotification("<b style=\"color:red\">Bạn chưa kết thúc phiên làm việc trước.!</b>");setTimeout(function(){closeNotification();},7000);return false;}}',
        'success'=>'function(data){$("#data-grid table").prepend(data);$("body").css("cursor", "default");}',
    ),array('id'=>'lnkAddRow')); ?>
</div>
<?php
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'formListProduct',
	'enableAjaxValidation'=>false,
    'action'=> Yii::app()->createUrl('product/qrcodePrints'),
    'htmlOptions'=>array(
        'enctype'=>'multipart/form-data',
        'target' => '_blank',
    )
)); 
$listTypeProduct = TypeProduct::model()->findAll("Status = 1");
$listSupplier = Supplier::model()->findAll("Status = 1");
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'data-grid',
	'dataProvider'=>$model->search(),
    'htmlOptions'=>array('class'=>'table'),
    'summaryText'=>'',
    'filter'=>$model,
    'columns'=>array(
        array(
            'id'=>'ids',
            'class'=>'CCheckBoxColumn',
            'selectableRows'=>2,
            'htmlOptions'=>array('class'=>'print ct id'),
            'headerHtmlOptions' => array('class'=>'id'),
        ),
        array(
            'name' => 'Qrcode',
            'value' => '"<div class=\"dataPrint\" dataPrint=\"product".$data->PkProductID."\"><div id=\"product".$data->PkProductID."\" style=\"display: inline-block;padding:10px; border:1px solid #dcdcdc; margin: 7px;\"><img src=\"".Yii::app()->baseUrl."/data/qrcodeProduct/".$data->ProductQrImage."\" style=\"width: 130px;\" /><p style=\"font-size: 11px;\">".$data->UnProductCode."<br />Giá: ".number_format($data->ProductSalePrice)." vnđ</p></div></div>"',
            'type' =>'raw',
            'filter' => false,
            'filterHtmlOptions' => array('style'=>'display:none'),
            'htmlOptions' => array('style'=>'display:none'),
            'headerHtmlOptions' => array('style'=>'display:none'),
        ),
        array(
            'name'=>'STT',
            'filter'=>false,
            'value' => '$row + 1',
            'type'=>'raw',
            'htmlOptions'=>array('class'=>'ct id'),
        ),
        array(
            'name'=>'UnProductCode',
            'value' => 'CHtml::link($data->UnProductCode, array("detail","id"=>$data->PkProductID), array("title"=>"Xem sản phẩm ".$data->UnProductName,"class"=>"link")).
                        (($data->allowChangeCode())?(CHtml::textField("Product[UnProductCode]",$data->UnProductCode,array("class"=>"txt-form input","oninput"=>"checkCode(this.value + \"|'.$this->id.'|".$data->UnProductCode."\")","style"=>"width:96%;float:left;margin-left:3px;display:none; min-width:1px"))."<label id=\"messCode\" class=\"notEmpty\" style=\"display:none; \">(*) Bắt buộc nhập</label>"):("<span class=\"input\" style=\"display:none\" >".$data->UnProductCode."</span>"))',
            'type'=>'raw',
            'htmlOptions'=>array('class'=>'ct id','style'=>'width:100px'),
        ),
        array(
            'name'=>'UnProductName',
            'value' => 'CHtml::link($data->UnProductName, array("detail","id"=>$data->PkProductID), array("title"=>"Xem sản phẩm ".$data->UnProductName,"class"=>"link")).
                        CHtml::textField("Product[UnProductName]",$data->UnProductName,array("class"=> "txt-form input","style"=>"width:96%;float:left;margin-left:3px;display:none; min-width:1px"))."<label class=\"notEmpty\" style=\"display:none\">(*) Bắt buộc nhập</label>"',
            'type'=>'raw',
            'htmlOptions'=>array('class'=>'ct','style'=>'width:200px'),
        ),
        array(
            'name'=>'TypeProductCode',
            'filter'=>CHtml::listData($listTypeProduct,'UnTypeProductCode','UnTypeProductName'),
            'value'=>'"<label class=\"link\">".$data->typeProduct()->UnTypeProductName."</label>".
                    CHtml::dropDownList("Product[TypeProductCode]",$data->TypeProductCode,$data->listTypeProduct(),array("class"=>"input sel-form","style"=>"width:86%;float:left;margin-left:3px;display:none"))."<label class=\"notEmpty\" style=\"display:none\">&nbsp; &nbsp;</label>"',
            'type'=>'raw',
            'htmlOptions'=>array('class'=>'ct'),
        ),
        array(
            'name'=>'SupplierId',
            'filter'=>CHtml::listData($listSupplier,'PkSupplier_Id','UnSupplierName'),
            'value'=>'"<label class=\"link\">".$data->supplier->UnSupplierName."</label>".
                    CHtml::dropDownList("Product[SupplierId]",$data->SupplierId,$data->listSupplier(),array("class"=>"input sel-form","style"=>"width:86%;float:left;margin-left:3px;display:none"))."<label class=\"notEmpty\" style=\"display:none\"> &nbsp; &nbsp;</label>"',
            'type'=>'raw',
            'htmlOptions'=>array('class'=>'ct'),
        ),
        array(
            'name'=>'ProductSalePrice',
            'filter'=>false,
            'value'=>'"<label class=\"link\">".$data->ProductSalePrice."</label>".
                    "<div class=\"input\" style=\"display:none; text-align:left; padding-left:3px\">".
                    "Giá Bán: ".CHtml::textField("Product[ProductSalePrice]",$data->ProductSalePrice,array("class"=> "txt-form input","style"=>"width:96%;float:left;margin-left:3px;display:none; min-width:1px"))."<label class=\"notEmpty\" style=\"display:none\">(*)</label>".
                    "<br>Giá mua: ".CHtml::textField("Product[ProductBuyPrice]",$data->ProductBuyPrice,array("class"=> "txt-form input","style"=>"width:96%;float:left;margin-left:3px;display:none; min-width:1px"))."<label class=\"notEmpty\" style=\"display:none\">*</label>".
                    "<br>Đơn vị tính: ".CHtml::textField("Product[ProductUnit]",$data->ProductUnit,array("class"=> "txt-form input","style"=>"width:96%;float:left;margin-left:3px;display:none; min-width:1px"))."</div>"',
            'type'=>'raw',
            'htmlOptions'=>array('class'=>'ct','style'=>'width:160px'),
        ),
        array(
            'name'=>'Quantity',
            'filter'=>false,
            'value'=>'"<label class=\"link\">".$data->Quantity."</label>".
                    "<div class=\"input\" style=\"display:none; text-align:left; padding-left:3px\">".CHtml::textField("Product[Quantity]",$data->Quantity,array("class"=> "txt-form input","style"=>"width:96%;float:left;margin-left:3px;display:none; min-width:1px"))."</div>"',
            'type'=>'raw',
            'htmlOptions'=>array('class'=>'ct','style'=>'width:80px'),
        ),
        array(
            'name'=>'Status',
            'filter'=>Yii::app()->params['status'],
            'value'=>'($data->Status==1?CHtml::link("&#xf06e;", array("status","id"=>$data->PkProductID), array("class"=>"status-dis status icon link", "id"=>"stt".$data->PkProductID)):CHtml::link("&#xf070;", array("status","id"=>$data->PkProductID), array("class"=>"status-en status icon link", "id"=>"stt".$data->PkProductID))).
                    CHtml::dropDownList("Product[Status]",$data->Status,Yii::app()->params["status"],array("class"=>"input sel-form","style"=>"width:86%;float:left;margin-left:3px;display:none"))',
            'type'=>'raw',
            'htmlOptions'=>array('class'=>'ct','style'=>'width:110px'),
        ),
        array(
			'class'=>'CButtonColumn',
            'template'=>'{update}{delete}{cancel}',//{deny}
            'buttons' => array(
                'update'=>array(
                    'label'=>'<i>&#xf040;</i>',
                    'imageUrl' => false,
                    'options'=>array( 'title'=>'Cập nhật','class'=>'lnkUpdate btnAction1'),
                ),
                'delete'=>array(
                    'label'=>'<i>&#xf014;</i>',
                    'imageUrl' => false,
                    'options'=>array( 'title'=>'Xóa','class'=>'delete btnAction2'),
                    'visible' => '$data->allowDelete()',
                ),/*
                'deny'=>array(
                    'label'=>'<i style="color:red !important">&#xf05e;</i>',
                    'imageUrl' => false,
                    'options'=>array( 'title'=>'Không thể xóa','class'=>'deny btnAction2'),
                    'visible' => 'true',
                ),*/
                'cancel' =>array(
                    'label'=>'<i>&#xf00d;</i>',
                    'imageUrl' => false,
                    'options'=>array( 'title'=>'Hủy cập nhật','class'=>'lnkcancel btnAction2','style'=>'display:none'),
                ),                
            ),
            'header'=>CHtml::dropDownList('pageSize',$pageSize,Yii::app()->params['recordsPerPage'],array(
                          'onchange'=>"$.fn.yiiGridView.update('data-grid',{data:{pageSize: $(this).val()}})")),
            'htmlOptions'=>array('class'=>'ct act','style'=>'width:100px; padding:0; text-align:left; display:table-cell; padding-left:3px'),
		),
        
	),
    'pager'=>array(
        'cssFile'=>false,
        'class'=>'CLinkPager',
        'firstPageLabel' => 'First',
        'prevPageLabel' => 'Previous',
        'nextPageLabel' => 'Next',
        'lastPageLabel' => 'Last',
        'header'=>'',
        'selectedPageCssClass'=>'active',
    ),
    'pagerCssClass' => 'pagination',
));?>
<a class="bnt-form" id="btnPrind" style="margin: 10px; display: none;">In QrCode các sản phẩm đã chọn</a>
<?php $this->endWidget(); ?>
<div id="contentPrint" style="clear: both;display: none;">
    <div style="width: 100%;" id="contents">
        
    </div>
</div>