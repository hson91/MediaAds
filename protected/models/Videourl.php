<?php

/**
 * This is the model class for table "videourl".
 *
 * The followings are the available columns in table 'videourl':
 * @property integer $ID
 * @property integer $videoID
 * @property double $screenRatio
 * @property string $urlVideo
 * @property string $videoFileSize
 * @property string $videoTimeSize
 * @property integer $videoWidth
 * @property integer $videoHeight
 * @property string $flagError
 * @property string $flagDeleted
 * @property string $urlStatus
 * @property integer $updateClosest
 * @property integer $inserted
 * @property integer $updated
 *
 * The followings are the available model relations:
 * @property Video $video
 */
class Videourl extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Videourl the static model class
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
		return 'videourl';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('videoID, urlVideo', 'required'),
			array('videoID, videoWidth, videoHeight, updateClosest, inserted, updated', 'numerical', 'integerOnly'=>true),
			array('screenRatio', 'numerical'),
			array('urlVideo, videoFileSize, videoTimeSize, flagError, flagDeleted, urlStatus', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, videoID, screenRatio, urlVideo, videoFileSize, videoTimeSize, videoWidth, videoHeight, flagError, flagDeleted, urlStatus, updateClosest, inserted, updated', 'safe', 'on'=>'search'),
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
			'video' => array(self::BELONGS_TO, 'Video', 'videoID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'videoID' => 'Video',
			'screenRatio' => 'Screen Ratio',
			'urlVideo' => 'Url Video',
			'videoFileSize' => 'Video File Size',
			'videoTimeSize' => 'Video Time Size',
			'videoWidth' => 'Video Width',
			'videoHeight' => 'Video Height',
			'flagError' => 'Flag Error',
			'flagDeleted' => 'Flag Deleted',
			'urlStatus' => 'Url Status',
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

		$criteria->compare('ID',$this->ID);
		$criteria->compare('videoID',$this->videoID);
		$criteria->compare('screenRatio',$this->screenRatio);
		$criteria->compare('urlVideo',$this->urlVideo,true);
		$criteria->compare('videoFileSize',$this->videoFileSize,true);
		$criteria->compare('videoTimeSize',$this->videoTimeSize,true);
		$criteria->compare('videoWidth',$this->videoWidth);
		$criteria->compare('videoHeight',$this->videoHeight);
		$criteria->compare('flagError',$this->flagError,true);
		$criteria->compare('flagDeleted',$this->flagDeleted,true);
		$criteria->compare('urlStatus',$this->urlStatus,true);
		$criteria->compare('updateClosest',$this->updateClosest);
		$criteria->compare('inserted',$this->inserted);
		$criteria->compare('updated',$this->updated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}