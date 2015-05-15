<?php

/**
 * This is the model class for table "group".
 *
 * The followings are the available columns in table 'group':
 * @property integer $id
 * @property string $groupName
 * @property string $groupDescription
 * @property integer $numberDevice
 * @property string $groupLocation
 * @property string $groupStatus
 * @property string $flagDeleted
 * @property integer $changeClosest
 * @property integer $updated
 * @property integer $inserted
 */
class Group extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Group the static model class
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
		return 'group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('groupName', 'required'),
			array('numberDevice, changeClosest, updated, inserted', 'numerical', 'integerOnly'=>true),
			array('groupName, groupDescription, groupLocation, groupStatus, flagDeleted', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, groupName, groupDescription, numberDevice, groupLocation, groupStatus, flagDeleted, changeClosest, updated, inserted', 'safe', 'on'=>'search'),
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
			'groupName' => 'Group Name',
			'groupDescription' => 'Group Description',
			'numberDevice' => 'Number Device',
			'groupLocation' => 'Group Location',
			'groupStatus' => 'Group Status',
			'flagDeleted' => 'Flag Deleted',
			'changeClosest' => 'Change Closest',
			'updated' => 'Updated',
			'inserted' => 'Inserted',
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
		$criteria->compare('groupName',$this->groupName,true);
		$criteria->compare('groupDescription',$this->groupDescription,true);
		$criteria->compare('numberDevice',$this->numberDevice);
		$criteria->compare('groupLocation',$this->groupLocation,true);
		$criteria->compare('groupStatus',$this->groupStatus,true);
		$criteria->compare('flagDeleted',$this->flagDeleted,true);
		$criteria->compare('changeClosest',$this->changeClosest);
		$criteria->compare('updated',$this->updated);
		$criteria->compare('inserted',$this->inserted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}