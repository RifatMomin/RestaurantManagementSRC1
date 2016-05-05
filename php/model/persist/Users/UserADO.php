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
        $sql = "SELECT * FROM users WHERE username = ? AND user_password = ?";
        $array = [$user->getUsername(), $user->getPassword()];

        $result = $this->dataSource->execution($sql, $array);

        return $result->fetchAll();
    }

    public function findByEmail($user) {
        //$cons = "select * from `".UserADO::$tableName."` where ".UserADO::$colNameNick." = \"".$user->getNick()."\" and ".UserADO::$colNamePassword." = \"".$user->getPassword()."\"";
        $sql = "SELECT * FROM users where email= ?";
        $array = [$user->getEmail()];
        $result = $this->dataSource->execution($sql, $array);
        
        foreach ($result as $user) {
            $userObject = new UserClass($user[0], $user[1], $user[2], $user[3], $user[4], $user[5], $user[6], $user[7], $user[8], $user[9], $user[10], $user[11], $user[12]);
        }
 
        return $userObject;
    }

    public function resetPassword() {
        
    }

    public function create($entity) {
        
    }

    public function delete($entity) {
        
    }

    public function update($entity) {
        
    }

    public function findAll() {
        
    }

    public function findByQuery($cons, $vector) {
        
    }

}

?>
