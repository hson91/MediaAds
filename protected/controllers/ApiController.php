<?php
class ApiController extends Controller
{
    protected $data;
    const APPLICATION_ID = 'KHOISANG';
    private $format = 'json';
    public function init(){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        if(isset($_POST['data'])){
            $this->data = json_decode( $_POST['data'] );
        }else{
            $this->data = array();
        }
        if($this->data == null){
            $this->setLog('device',json_encode('[Insert]Error! No data is sent to server'),json_encode('No data is sent to server'),2);
            $this->_sendResponse(array('status'=>0,'message'=>'Error! No data is sent to server'));
            Yii::app()->end();
        }
    }
    public function actionGettingStarted(){
        $data = $this->data;
        if(isset($data->id)){
            $model = Device::model()->findByPk($data->id);
            if($model == null){
                $model = new Device;
            }
        }else{
            $model = new Device;    
        }
        foreach($data as $k=>$v){
            if($model->hasAttribute($k)){
                $model->$k = $v;
            }
        }
        if($model->save()){
            $model->tokenID = $model->id;
            $model->save();
            $data = array('deviceID'=>$model->id);
            $this->_sendResponse(array('status'=>1,'data'=>$data,'message'=>sprintf('Success! The device "%s" have been added with ID is "%s".',$model->deviceName,$model->id)));
            Yii::app()->end();
        }else{
            $jsonErrors = array();
            $jsonErrors['message'] = sprintf('Error! Add device "%s" failed',$model->deviceName);
            foreach ( $model->errors as $attr=>$errors ) {
                $jsonErrors[$attr] = $errors;
            }
            $this->setLog('device',json_encode('[Insert]'.$jsonErrors['message']),json_encode($jsonErrors),2);
            $this->_sendResponse(array('status'=>0,'message'=>$jsonErrors));
            Yii::app()->end();
        }
    }
    private function setLog($table= '',$logTitle='',$logDetail = '',$status = 1){
        $log = new Log;
        $log->logTable = $table;
        $log->logTitle = json_encode($logTitle);
        $log->logDetail = json_encode($logDetail);
        $log->logTime = time();
        $log->status = $status;
        $log->save(false);
    }
    public function actionGetVideo(){
        $data = $this->data;
        if(isset($data->lstUrlError)){
            foreach($data->lstUrlError as $k=>$v){
                $video = Video::model()->findByPk($k);
                if($video){
                    foreach($v as $ktmp=>$vtmp){
                        if($v->hasAttribute($ktmp)){
                            $v->$ktmp = 0;
                        }
                    }
                    if($video->save()){
                        $this->setLog('video',json_encode('[urlDownload] Video "%s" with ID "%s" link download errors'),json_encode($v),2);
                    }
                }
            }
        }
        $timeStart = isset($data->timeStart)? $data->timeStart :time();
        //$timeEnd = isset($data->timeDuration)? ($timeStart + ($data->timeDuration * 60 * 60)) :($timeStart + (24*60*60));
        $criteria = new CDbCriteria;
        $criteria->condition = 'status = 1 and timeEnd > :timeEnd';
        $criteria->order = 'timeStart asc';
        $criteria->params = array(':timeEnd' => $timeStart);
        $models = Schedule::model()->findAll($criteria);
        if($models){
            $result = array();
            foreach($models as $k=>$v){
                $video = Video::model()->findByPk($v->videoID);
                if($video){
                    $arrUrl = array();
                    $arrUrl['videoID'] = $video->id;
                    if($video->flagUrlDefault == 1){
                        $arrUrl['urlDefault'] = $video->urlDefault;
                    }
                    if($video->flagUrlBackup1 == 1){
                        $arrUrl['urlBackup1'] = $video->urlBackup1;
                    }
                    if($video->flagUrlBackup2 == 1){
                        $arrUrl['urlBackup2'] = $video->urlBackup2;
                    }
                    if($arrUrl != null){
                        $arrUrl['videoFileSize'] = $video->videoFileSize;
                        //$arrUrl['md5File'] = md5_file($arrUrl['urlDefault']);
                        $arrUrl['title'] = $video->title;
                        $arrUrl['videoName'] = $video->videoName;
                        $arrUrl['timeStart'] = $v->timeStart;
                        $arrUrl['timeEnd'] = $v->timeEnd; 
                        $arrUrl['updated'] = $v->updated;
                        $result[] = $arrUrl;
                    }
                }
            }
            $this->setLog('Schedule',json_encode('Get Schedule'),json_encode($result),1);
            $this->_sendResponse(array('status'=>1,'message'=>'Success!','data'=>$result));
            Yii::app()->end();
        }
        $this->setLog('Schedule',json_encode('Schedule'),json_encode("Not found schedule from ".date('Y/m/d H:i:s',$timeStart)),1);
        $this->_sendResponse(array('status'=>0,'message'=>'Error! Data not found'));
        Yii::app()->end();
    }
    private function _sendResponse( $body = '') {
        if ( is_array( $body ) ) {
            if ( !isset( $body['message'] ) ) {
                $body['message'] = 'No message';
            }
            $body['time'] = time();
            $body = json_encode($body);
        }
        echo $body;
        exit;
    }
    private function _sendError( $status, $message='' ) {
        $this->_sendResponse(array(
                                    'status'=> $status,
                                    'message'=>($message != '')? $message : $this->_getStatusCodeMessage($status)
                                    )
            );
    }
    private function _getStatusCodeMessage($status) {
        $codes = $this->_getStatusCode();
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    private function _getStatusCode() {
        return array(
            200 => 'OK',
            401 => 'Unauthorized',
            4011 => 'Invalid Username',
            4012 => 'Invalid Password',
            4013 => 'Account is locked',
            404 => 'Not Found',
            501 => 'Not Implemented',
            500 => 'Internal Server Error',
        );
    }
    private function checkAuth() {
        return true;
    }
}
?>
