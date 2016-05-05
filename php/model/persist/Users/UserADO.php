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
    const SELECT_EMAIL = "SELECT id FROM users WHERE email = :email";
    const SELECT_BY_NICK = "SELECT username FROM users WHERE username = ?";
    const SELECT_BY_EMAIL = "SELECT username FROM users WHERE email = ?";
    const INSERT = "INSERT INTO `users` (`username`, `user_password`, `user_name`, `surname`, `email`, `phone`, `address`, `city`, `zip_code`, `role`) VALUES (?,SHA1(?),?,?,?,?,?,?,?,0)";
    
    
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
        $sql = "SELECT id FROM users WHERE email = :email";

        $array = [":email" => $user->getEmail()];

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

    public function resetPassword() {
        
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
        ];
        
        return $this->dataSource->execution(self::INSERT,$array);
    }

    public function delete($entity) {
        
    }

    public function update($entity) {
        
    }

    public function findAll() {
        
    }
    
    public function findByNick($nick){
        $array = [$nick];
        
        return $this->dataSource->execution(self::SELECT_BY_NICK,$array);
    }

    
}

?>
