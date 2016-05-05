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
        $sql = "SELECT id FROM users where email='" . $email . "'";

        $array = [$user->getEmail()];

        $result = $this->dataSource->execution($sql, $array);

        //return $result->fetchAll();
        if (count($$esult) == 1) {
            $encrypt = md5(1290 * 3 + $result['email']);
            $message = "Your password reset link send to your e-mail address.";
            $to = $email;
            $subject = "Forget Password";
            $from = 'proinsprov@gmail.com';
            $body = 'Hi, <br/> <br/>Your Membership ID is ' . $Results['id'] . ' <br><br>Click here to reset your password http://localhost/RestaurantManagement_1/reset.php?encrypt=' . $encrypt . '&action=reset   <br/> <br/>';
            $headers = "From: " . strip_tags($from) . "\r\n";
            $headers .= "Reply-To: " . strip_tags($from) . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            mail($to, $subject, $body, $headers);
        }
    }
    public function resetPassword(){
        
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
