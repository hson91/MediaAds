<?php

/**
 * This is the model class for table "device".
 *
 * The followings are the available columns in table 'device':
 * @property integer $id
 * @property string $tokenID
 * @property string $deviceID
 * @property string $textNotification
 * @property string $deviceName
 * @property string $deviceProducers
 * @property string $deviceOS
 * @property string $versionOS
 * @property string $coordinatesX
 * @property string $coordinatesY
 * @property string $macAddress
 * @property string $ipAddress
 * @property string $versionApp
 * @property string $deviceWidth
 * @property string $deviceHeight
 * @property integer $location
 * @property double $screenRatio
 * @property string $deviceStatus
 * @property integer $interActionClosest
 * @property string $flagDeleted
 * @property string $notes
 * @property integer $timerOpen
 * @property integer $timerClosed
 * @property integer $timeDowloadClosest
 * @property integer $timeUseClosest
 * @property integer $inserted
 * @property integer $updated
 *
 * The followings are the available model relations:
 * @property Cheduledevice[] $cheduledevices
 */
class Device extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Device the static model class
	 */
    private $codeOld = null; 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'device';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tokenID, deviceID, deviceName', 'required'),
			array('interActionClosest, timerOpen, timerClosed, timeDowloadClosest, timeUseClosest, inserted, updated', 'numerical', 'integerOnly'=>true),
			array('screenRatio', 'numerical'),
			array('tokenID, deviceID, textNotification, deviceName, deviceProducers, deviceOS, deviceStatus, flagDeleted, notes', 'length', 'max'=>255),
			array('versionOS, ipAddress, versionApp', 'length', 'max'=>20),
			array('coordinatesX, coordinatesY, macAddress', 'length', 'max'=>30),
			array('deviceWidth, deviceHeight', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tokenID, deviceID, textNotification, deviceName, deviceProducers, deviceOS, versionOS, coordinatesX, coordinatesY, macAddress, ipAddress, versionApp, deviceWidth, deviceHeight, screenRatio, deviceStatus, interActionClosest, flagDeleted, notes, timerOpen, timerClosed, timeDowloadClosest, timeUseClosest, inserted, updated', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'cheduledevices' => array(self::HAS_MANY, 'Cheduledevice', 'deviceID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tokenID' => 'Token',
			'deviceID' => 'Mã TB',
			'textNotification' => 'Nội dung Push Message',
			'deviceName' => 'Tên TB',
			'deviceProducers' => 'Nhà SX',
			'deviceOS' => 'HĐH',
			'versionOS' => 'Phiên bản HĐH',
			'coordinatesX' => 'Tọa Độ X',
			'coordinatesY' => 'Tọa Độ Y',
			'macAddress' => 'Địa Chỉ MAC',
			'ipAddress' => 'Địa Chỉ IP',
			'versionApp' => 'Phiên bản Ứng dụng',
			'deviceWidth' => 'Độ rộng màn hình',
			'deviceHeight' => 'Chiều cao màn hình',
			'location' => 'Vị trí',
			'screenRatio' => 'Tỉ lệ màn hình',
			'deviceStatus' => 'Trạng thái',
			'interActionClosest' => 'Tương tác gần nhất',
			'flagDeleted' => 'TB Bị Xóa',
			'notes' => 'Ghi chú',
			'timerOpen' => 'Hẹn giờ mở',
			'timerClosed' => 'Hẹn giờ tắt',
			'timeDowloadClosest' => 'Download gần nhất',
			'timeUseClosest' => 'Sử dụng gần nhất',
			'inserted' => 'Thiết bị được thêm',
			'updated' => 'Thiết bị được cập nhật',
            'scheduleRunning' => 'Lịch Trình', 
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('tokenID',$this->tokenID,true);
		$criteria->compare('deviceID',$this->deviceID,true);
		$criteria->compare('textNotification',$this->textNotification,true);
		$criteria->compare('deviceName',$this->deviceName,true);
		$criteria->compare('deviceOS',$this->deviceOS,true);
		$criteria->compare('versionOS',$this->versionOS,true);
		$criteria->compare('deviceStatus',$this->deviceStatus,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    public function beforeFind(){
        
    }
    public function beforeSave(){
        if($this->isNewRecord){
            $this->inserted = time();
        }
        $this->updated = time();
        return true;
    }
}