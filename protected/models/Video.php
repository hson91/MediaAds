<?php

/**
 * This is the model class for table "video".
 *
 * The followings are the available columns in table 'video':
 * @property integer $id
 * @property string $videoName
 * @property string $description
 * @property string $flagDeleted
 * @property string $videoStatus
 * @property integer $updateClosest
 * @property integer $inserted
 * @property integer $updated
 *
 * The followings are the available model relations:
 * @property Scheduledetail[] $scheduledetails
 * @property Videourl[] $videourls
 */
class Video extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Video the static model class
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
		return 'video';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('videoName, videoStatus', 'required'),
			array('updateClosest, inserted, updated', 'numerical', 'integerOnly'=>true),
			array('videoName, description, flagDeleted, videoStatus', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, videoName, description, flagDeleted, videoStatus, updateClosest, inserted, updated', 'safe', 'on'=>'search'),
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
			'scheduledetails' => array(self::HAS_MANY, 'Scheduledetail', 'VideoID'),
			'videourls' => array(self::HAS_MANY, 'Videourl', 'videoID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'videoName' => 'Video Name',
			'description' => 'Description',
			'flagDeleted' => 'Flag Deleted',
			'videoStatus' => 'Video Status',
			'updateClosest' => 'Update Closest',
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
		$criteria->compare('videoName',$this->videoName,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('flagDeleted',$this->flagDeleted,true);
		$criteria->compare('videoStatus',$this->videoStatus,true);
		$criteria->compare('updateClosest',$this->updateClosest);
		$criteria->compare('inserted',$this->inserted);
		$criteria->compare('updated',$this->updated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function beforeSave(){
        if($this->isNewRecord){
            $this->inserted = time();
        }
        $this->updated = time();
        return true;
    }

}