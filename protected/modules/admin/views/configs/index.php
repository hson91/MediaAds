<div class="action">
</div>
<?php
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'data-grid',
	'dataProvider'=>$model->search(),
    'htmlOptions'=>array('class'=>'table'),
    'summaryText'=>'',
    'filter' => $model,
    'afterAjaxUpdate'=>'function(id, data){$("#data-grid").append("<script type=\"text\/javascript\" src=\"'.Yii::app()->controller->module->assetsUrl.'\/js\/status.js\"><\/script>");}',
    'columns'=>array(
        array(
            'id'=>'ids',
            'class'=>'CCheckBoxColumn',
            'selectableRows'=>2,
            'htmlOptions'=>array('class'=>'ct id'),
        ),
		array(
            'name'=>'id',
            'htmlOptions'=>array('class'=>'ct id'),
            'filterHtmlOptions' => array('class' => 'ct id')
        ),
        array(
            'name'=>'title',
        ),
        array(
            'name'=>'alias',
            'value'=>'$data->alias',
            'filter' => false,
        ),
        array(
            'name'=>'status',
            'filter'=>Yii::app()->params['status'],
            'value'=>'$data->status==1?CHtml::link("&#xf06e;", array("status","id"=>$data->id), array("class"=>"status-dis status icon", "id"=>"stt".$data->id)):CHtml::link("&#xf070;", array("status","id"=>$data->id), array("class"=>"status-en status icon", "id"=>"stt".$data->id))',
            'type'=>'raw',
            'htmlOptions'=>array('class'=>'ct'),
        ),
        array(
            'name' => 'updated',
            'value'=> 'date("d-m-Y",strtotime($data->updated))',
            'htmlOptions'=>array('class'=>'ct'),
        ),
        array(
			'class'=>'CButtonColumn',
            'template'=>'{update}',
            'buttons' => array(
                'update'=>array(
                    'label'=>'<i>&#xf040;</i>',
                    'imageUrl' => false,
                    'options'=>array( 'title'=>'Edit' ),
                ),
            ),
            'header'=>CHtml::dropDownList('pageSize',$pageSize,Yii::app()->params['recordsPerPage'],array(
                          'onchange'=>"$.fn.yiiGridView.update('data-grid',{data:{pageSize: $(this).val()}})")),
            'htmlOptions'=>array('class'=>'ct act'),
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