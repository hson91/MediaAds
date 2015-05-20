<div class="action">
    <?php echo CHtml::link('<i>&#xf055;</i>Thêm', array('create')); ?>
    <?php echo CHtml::ajaxLink("<i>&#xf014;</i>Xóa chọn", array('deleteList'), array(
        "type"    => "post",
        "data"    => "js:{ids:$.fn.yiiGridView.getChecked('data-grid','ids')}",
        "success" => "function(data){
            $.fn.yiiGridView.update('data-grid'); 
        }"),
        array('class'=>'red', 'confirm' => 'Bạn có chắc chắn muốn xóa?')); 
    ?>
</div>
<?php
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
            'name'=>'STT',
            'filter'=>false,
            'value' => '$row + 1',
            'type'=>'raw',
            'htmlOptions'=>array('class'=>'ct id'),
        ),
        array(
            'name'=>'deviceID','type'=>'raw',
            'htmlOptions'=>array('class'=>'ct','style'=>'width:100px'),
        ),
        array(
            'name'=>'deviceName','type'=>'raw',
            'htmlOptions'=>array('class'=>'ct','style'=>'width:100px'),
        ),
        array(
            'name'=>'deviceOS',
            'filter'=>Yii::app()->params["device_os"],
            'value'=>'Yii::app()->params["device_os"][$data->deviceOS]',
            'type'=>'raw',
            'htmlOptions'=>array('class'=>'ct'),
        ),
        array(
            'name'=>'deviceStatus',
            'filter'=>Yii::app()->params["device_status"],
            'value'=>'"<strong style=\"color:#888\" >".Yii::app()->params["device_status"][$data->deviceStatus]."</strong>"',
            'type'=>'raw',
            'htmlOptions'=>array('class'=>'ct'),
        ),
        array(
            'name' => 'scheduleRunning',
            'filter' => false,
            'value' => 'CHtml::link("&#xf0ce;", array("#","id"=>0), array("class"=>"icon","style" => "font-size:24px; color:green"))',
            'type' => 'raw',
            'htmlOptions'=>array('class'=>'ct','style' => 'width:80px'),
        ),
        array(
            'name'=>'interActionClosest',
            'filter'=>false,
            'value'=>'date("d-m-Y H:i:s",$data->interActionClosest)',
            'type'=>'raw',
            'htmlOptions'=>array('class'=>'ct'),
        ),
        array(
			'class'=>'CButtonColumn',
            'template'=>'{update}{delete}',//{deny}
            'buttons' => array(
                'update'=>array(
                    'label'=>'<i>&#xf040;</i>',
                    'imageUrl' => false,
                    'options'=>array( 'title'=>'Cập nhật','class'=>'btnAction1'),
                ),
                'delete'=>array(
                    'label'=>'<i>&#xf014;</i>',
                    'imageUrl' => false,
                    'options'=>array( 'title'=>'Xóa','class'=>'delete btnAction2'),
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
));
?>
