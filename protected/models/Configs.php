<?php

/**
 * This is the model class for table "configs".
 *
 * The followings are the available columns in table 'configs':
 * @property integer $id
 * @property string $titleConfig
 * @property string $aliasConfig
 * @property integer $dataType
 * @property string $contentConfig
 * @property integer $status
 * @property integer $inserted
 * @property integer $updated
 */
class Configs extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Configs the static model class
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
		return 'configs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contentConfig', 'required'),
			array('dataType, status, inserted, updated', 'numerical', 'integerOnly'=>true),
			array('titleConfig, aliasConfig', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, titleConfig, aliasConfig, dataType, contentConfig, status, inserted, updated', 'safe', 'on'=>'search'),
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
			'titleConfig' => 'Title Config',
			'aliasConfig' => 'Alias Config',
			'dataType' => 'Data Type',
			'contentConfig' => 'Content Config',
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
		$criteria->compare('titleConfig',$this->titleConfig,true);
		$criteria->compare('aliasConfig',$this->aliasConfig,true);
		$criteria->compare('dataType',$this->dataType);
		$criteria->compare('contentConfig',$this->contentConfig,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('inserted',$this->inserted);
		$criteria->compare('updated',$this->updated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}