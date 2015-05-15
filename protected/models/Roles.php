<?php

/**
 * This is the model class for table "roles".
 *
 * The followings are the available columns in table 'roles':
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property integer $view_bill
 * @property string $inserted
 * @property string $updated
 * @property integer $inserter
 * @property integer $updater
 */
class Roles extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Roles the static model class
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
		return 'roles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, alias', 'required'),
			array('inserter, view_bill, updater', 'numerical', 'integerOnly'=>true),
			array('title, alias', 'length', 'max'=>100),
			array('alias', 'unique'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, alias, view_bill, inserted, updated, inserter, updater', 'safe'),
			array('id, title, alias, view_bill, inserted, updated, inserter, updater', 'safe', 'on'=>'search'),
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
			'title' => 'Title',
			'alias' => 'Alias',
			'view_bill' => 'View Bill',
			'inserted' => 'Inserted',
			'updated' => 'Updated',
			'inserter' => 'Inserter',
			'updater' => 'Updater',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('view_bill',$this->view_bill,true);
		$criteria->compare('inserted',$this->inserted,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('inserter',$this->inserter);
		$criteria->compare('updater',$this->updater);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    protected function beforeSave() {
        if ($this->isNewRecord) {
            $this->inserted = new CDbExpression('NOW()');
            $this->inserter = Yii::app()->user->id;
        }
        $this->updated = new CDbExpression('NOW()');
        $this->updater = Yii::app()->user->id;
        return true;
    }
}