<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property string $id
 * @property string $updated
 * @property string $inserted
 * @property string $updater
 * @property string $inserter
 * @property string $username
 * @property string $password
 * @property string $roles
 * @property string $first_name
 * @property string $last_name
 * @property string $fullname
 * @property string $email
 * @property string $gender
 * @property string $dob
 * @property string $address
 * @property string $phone
 * @property string $image
 * @property string $status
 * @property string $yahoo
 * @property string $skype
 * @property string $visited
 */
class Users extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
    public $verifyCode; 
    public $cate_id;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, roles, email, fullname', 'required'),
            array('password', 'required', 'on'=>'insert'),
			array('updater, inserter, gender, status', 'length', 'max'=>11),
			array('username', 'length', 'max'=>32),
			array('password', 'length', 'max'=>64),
			array('email, yahoo, skype', 'length', 'max'=>100),
			array('fullname, image', 'length', 'max'=>255),
			array('phone', 'length', 'max'=>40),
            array('username, email', 'unique'),
            array('email', 'email'),
			array('updated, inserted, dob, address, visited', 'safe'),
            array('verifyCode', 'captcha', 'on' => 'register'),
            array('fullname', 'required', 'on'=>'register'),
            array('password', 'required', 'on'=>'register'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, updated, inserted, updater, inserter, username, password, cate_id, roles, fullname, email, gender, dob, address, phone, image, status, yahoo, skype, visited', 'safe'),
			array('id, updated, inserted, updater, inserter, username, password, cate_id, roles, fullname, email, gender, dob, address, phone, image, status, yahoo, skype, visited', 'safe', 'on'=>'search'),
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
			'role' => array(self::BELONGS_TO, 'Roles', 'roles'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'updated' => 'Cập nhật',
			'inserted' => 'Thêm',
			'updater' => 'Người cập nhật',
			'inserter' => 'Người thêm',
			'username' => 'Tên truy cập',
			'password' => 'Mật khẩu',
			'roles' => 'Quyền hạn',
			'fullname' => 'Họ tên',
			'email' => 'Email',
			'gender' => 'Giới tính',
			'dob' => 'Dob(YYYY/MM/DD)',
			'address' => 'Địa chỉ',
			'phone' => 'Điện thoại',
			'image' => 'Hình đại diện',
			'status' => 'Trạng thái',
			'yahoo' => 'Yahoo',
			'skype' => 'Skype',
			'visited' => 'Visited',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('inserted',$this->inserted,true);
		$criteria->compare('updater',$this->updater,true);
		$criteria->compare('inserter',$this->inserter,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('roles',$this->roles,true);
		$criteria->compare('fullname',$this->fullname,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('dob',$this->dob,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('yahoo',$this->yahoo,true);
		$criteria->compare('skype',$this->skype,true);
		$criteria->compare('visited',$this->visited,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    protected function beforeSave() {
        if($this->fullname == ''){
            $this->fullname = trim($this->first_name . ' ' .$this->last_name);
        }
        if ($this->isNewRecord) {
            $this->inserted = new CDbExpression('NOW()');
            $this->inserter = Yii::app()->user->id;
        }
        $this->updated = new CDbExpression('NOW()');
        $this->updater = Yii::app()->user->id;
        return true;
    }
}