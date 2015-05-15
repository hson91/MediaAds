<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
    
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
        if (filter_var($this->username, FILTER_VALIDATE_EMAIL)) {
            $user = Users::model()->findByAttributes(array(
                'email'=>$this->username,
                'status'=>1,
            ));
        } else {
            $user = Users::model()->findByAttributes(array(
                'username'=>$this->username,
                'status'=>1,
            ));    
        }

        
        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            $password = md5($this->password);
            
            if ($user->password !== $password) {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            } else {
                $this->_id = $user->id;
                if ($user->visited === null) {
                    $lastLogin = new CDbExpression('NOW()');
                } else {
                    $lastLogin = $user->visited;
                }
                
                $auth = Yii::app()->authManager;
                
                if (!$auth->isAssigned($user->role->alias, $this->_id)) {
                    if ($auth->assign($user->role->alias, $this->_id)) {
                        Yii::app()->authManager->save();
                    }
                }
                $this->setState('role', $user->role->alias);
                $this->setState('roles', $user->role);
                $_SESSION['ckeditor']['role'] = $user->role->alias;
                $_SESSION['ckeditor']['username'] = $user->username;
                $this->setState('fullname', $user->fullname != '' ? $user->fullname : $user->first_name . ' ' . $user->last_name);
                $this->setState('username', $user->username);
                $this->setState('email', $user->email);
                $this->setState('visited', $lastLogin);
                $this->errorCode = self::ERROR_NONE;
            }
        }
		return !$this->errorCode;
	}
    
    public function getId(){
        return $this->_id;
    }
}