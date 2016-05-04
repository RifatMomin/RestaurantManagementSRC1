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
    public function findByNickAndPass( $user ) {
		//$cons = "select * from `".UserADO::$tableName."` where ".UserADO::$colNameNick." = \"".$user->getNick()."\" and ".UserADO::$colNamePassword." = \"".$user->getPassword()."\"";
		$sql = "SELECT * FROM users WHERE username = ? AND user_password = ?";
		$array = [$user->getUsername(),$user->getPassword()];
		
		$result = $this->dataSource->execution($sql,$array);
                
                return $result->fetchAll();
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
