<?php

/**
 * This is the model class for table "groupdevice".
 *
 * The followings are the available columns in table 'groupdevice':
 * @property integer $id
 * @property integer $groupID
 * @property integer $deviceID
 * @property integer $status
 * @property string $inserted
 * @property string $updated
 */
class Groupdevice extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Groupdevice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'groupdevice';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('groupID, deviceID, status', 'numerical', 'integerOnly'=>true),
			array('inserted', 'length', 'max'=>255),
			array('updated', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, groupID, deviceID, status, inserted, updated', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'groupID' => 'Group',
			'deviceID' => 'Device',
			'status' => 'Status',
			'inserted' => 'Inserted',
			'updated' => 'Updated',
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
		$criteria->compare('groupID',$this->groupID);
		$criteria->compare('deviceID',$this->deviceID);
		$criteria->compare('status',$this->status);
		$criteria->compare('inserted',$this->inserted,true);
		$criteria->compare('updated',$this->updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}