<?php

/** userClass.php
 * Entity userClass
 * autor  Roberto Plana
 * version 2012/09
 */
require_once "../model/persist/DBConnect.php";
include "../model/persist/EntityInterfaceADO.php";
require_once "../model/Users/UserClass.php";

class UserADO implements EntityInterfaceADO {

    //Constants of the QUERIES
    const SELECT_NICK_PASS = "SELECT * FROM users WHERE username = ? AND user_password = ?";
    const SELECT_EMAIL = "SELECT * FROM users WHERE email = ?";
    const SELECT_BY_NICK = "SELECT username FROM users WHERE username = ?";
    const SELECT_BY_EMAIL = "SELECT username FROM users WHERE email = ?";
    const INSERT = "INSERT INTO `users` (`username`, `user_password`, `user_name`, `surname`, `email`, `phone`, `address`, `city`, `zip_code`,`image`, `role`) VALUES (?,?,?,?,?,?,?,?,?,?,0)";
    const UPDATE_PASSWD = "UPDATE users SET user_password = ? WHERE user_password= ? and email= ? ";
    
    private $dataSource;

    public function __construct() {
        $this->dataSource = DBConnect::getInstance();
    }

    /**
     * findByNickAndPass()
     * It runs a query and returns an object array
     * @param name
     * @return object with the query results
     */
    public function findByNickAndPass($user) {
        //$cons = "select * from `".UserADO::$tableName."` where ".UserADO::$colNameNick." = \"".$user->getNick()."\" and ".UserADO::$colNamePassword." = \"".$user->getPassword()."\"";
        $sql = "SELECT * FROM users WHERE (username = ? OR email = ?) AND user_password = ?";
        $array = [$user->getUsername(), $user->getUsername(), $user->getPassword()];

        $result = $this->dataSource->execution($sql, $array);

        return $result->fetchAll();
    }

    /**
     * findByEmail()
     * searches for a given email and returns
     * the user if it exists
     * @param user Object
     * @return object with the query results
     */
    public function findByEmail($user) {

        $result = $this->dataSource->execution(self::SELECT_EMAIL, $array = [$user->getEmail()]);

        foreach ($result as $user) {
            $userObject = new UserClass($user[0], $user[1], $user[2], $user[3], $user[4], $user[5], $user[6], $user[7], $user[8], $user[9], $user[10], $user[11], $user[12]);
        }
        
        return $userObject;
    }

    public function emailChecking($email) {
        return $this->dataSource->execution(self::SELECT_BY_EMAIL, $array = [$email]);
    }

    public function resetPassword($user, $newpassword) {
        
        $array = [
          
            $newpassword,
            $user->getPassword(),
            $user->getEmail(),
        ];
       
        return $this->dataSource->execution(self::UPDATE_PASSWD, $array);
        
        
    }

    public function create($userObj) {

        $array = [
            $userObj->getUsername(),
            $userObj->getPassword(),
            $userObj->getName(),
            $userObj->getSurname(),
            $userObj->getEmail(),
            $userObj->getPhone(),
            $userObj->getAddress(),
            $userObj->getCity(),
            $userObj->getZipCode(),
            $userObj->getImage()
        ];

        return $this->dataSource->execution(self::INSERT, $array);
    }

    public function delete($entity) {
        
    }

    public function update($entity) {
        
    }

    public function findAll() {
        
    }

    public function findByNick($nick) {
        $array = [$nick];

        return $this->dataSource->execution(self::SELECT_BY_NICK, $array);
    }

}

?>
