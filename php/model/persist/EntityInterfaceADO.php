<?php
interface EntityInterfaceADO
{
	public function findAll();
	public function create($entity);
	public function delete($entity);
	public function update($entity);
   
}
?>
