<?php

namespace app\models;

class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $cedula;
    public $nombre;
    public $usuario;
    public $passwd;
    public $email;
    public $estado;
    public $fecha_registro;
    public $fecha_actualizacion;
    public $edad;
    public $rol;


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        //return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;

        $user = Usuarios::find()
                ->where("estado=:estado", [":estado" => 1])
                ->andWhere("cedula=:id", ["id" => $id])
                ->one();
        
        return isset($user) ? new static($user) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        //throw new \yii\base\NotSupportedException();
        return true;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $users = Usuarios::find()
                ->where("estado=:estado", ["estado" => 1])
                ->andWhere("usuario=:usuario", [":usuario" => $username])
                ->all();
        
        foreach ($users as $user) {
            if (strcasecmp($user->usuario, $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->cedula;
    }

    /**
     * @inheritdoc
     */
    
    public function getAuthKey()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    
    public function validateAuthKey($authKey)
    {
        return true;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->passwd === $password;
    }


    /**
     * Verifica si el usuario es administrador
     * 
    **/
    public static function isUserAdmin($id)
    {
       if (Usuarios::findOne(['cedula' => $id, 'estado' => '1', 'rol' => 2])){
        return true;
       } else {

        return false;
       }

    }

    /**
     * Verifica si el usuario tiene perfil usuario
     * 
    **/
    public static function isUserSimple($id)
    {
       if (Usuarios::findOne(['cedula' => $id, 'estado' => '1', 'rol' => 1])){
       return true;
       } else {

       return false;
       }
    }
}
