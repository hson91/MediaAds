<?php

/**
 * This is the model class for table "scheduledetail".
 *
 * The followings are the available columns in table 'scheduledetail':
 * @property integer $ID
 * @property integer $scheduleID
 * @property integer $VideoID
 * @property integer $timeStart
 * @property integer $timeEnd
 * @property string $flagDelete
 * @property string $status
 * @property integer $inserted
 * @property integer $updated
 *
 * The followings are the available model relations:
 * @property Schedule $schedule
 * @property Video $video
 */
class Scheduledetail extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Scheduledetail the static model class
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
		return 'scheduledetail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('scheduleID, VideoID, timeStart, timeEnd, inserted, updated', 'numerical', 'integerOnly'=>true),
			array('flagDelete, status', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, scheduleID, VideoID, timeStart, timeEnd, flagDelete, status, inserted, updated', 'safe', 'on'=>'search'),
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
			'schedule' => array(self::BELONGS_TO, 'Schedule', 'scheduleID'),
			'video' => array(self::BELONGS_TO, 'Video', 'VideoID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'scheduleID' => 'Schedule',
			'VideoID' => 'Video',
			'timeStart' => 'Time Start',
			'timeEnd' => 'Time End',
			'flagDelete' => 'Flag Delete',
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

		$criteria->compare('ID',$this->ID);
		$criteria->compare('scheduleID',$this->scheduleID);
		$criteria->compare('VideoID',$this->VideoID);
		$criteria->compare('timeStart',$this->timeStart);
		$criteria->compare('timeEnd',$this->timeEnd);
		$criteria->compare('flagDelete',$this->flagDelete,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('inserted',$this->inserted);
		$criteria->compare('updated',$this->updated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}