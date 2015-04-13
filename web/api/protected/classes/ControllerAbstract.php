<?php
abstract class ControllerAbstract
{
	protected $_entityClass = '';
	/**
	 * Constructor
	 * 
	 * @param unknown $entityClass
	 */
	public function __construct($entityClass) {
		$this->_entityClass = $entityClass;
	}
	/**
	 * Getting all 
	 * @throws RestException
	 * 
	 * @url GET /
	 */
	public function listAll() {
		if(!class_exists($className = trim($this->_entityClass)))
			throw new RestException(400, 'Invalid class: ' . $className);
		$items = $className::getAll(true, 1, DaoQuery::DEFAUTL_PAGE_SIZE);
		return array_map(create_function('$a', 'return $a->getJson();'), $items);
	}
	/**
     * Saves a entity to the database
     *
     * @url POST /
     * @url PUT /$id
     */
    public function save($id = null, $data)
    {
    	if(!class_exists($className = trim($this->_entityClass)))
    		throw new RestException(400, 'Invalid class: ' . $className);
    	if(($id = trim($id)) !== '') {
    		if(!($entity = $className::get($id)))
    			throw new RestException(400, 'Invalid entity: ' . $id);
    	} else {
    		$entity = $className::saveNew($data);
    	}
        return $entity->getJson(); // returning the updated or newly created user object
    }
    /**
     * deactive a entity from database
     * @param unknown $id
     * 
     * @url DELETE /$id
     */
    public function delete($id) {
    	if(!class_exists($className = trim($this->_entityClass)))
    		throw new RestException(400, 'Invalid class: ' . $className);
    	if(($id = trim($id)) === '' || !($entity = $className::get($id)))
    		throw new RestException(400, 'Invalid entity: ' . $id);
    	return $entity->setActive(false)->save()->getJson();
    }
}