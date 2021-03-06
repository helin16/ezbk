<?php
/**
 * Role Entity
 *
 * @package    Core
 * @subpackage Entity
 * @author     lhe<helin16@gmail.com>
 */
class Role extends BaseEntityAbstract
{
	const ID_ADMIN = 10;
	const ID_BOOKKEEPER = 11;
    /**
     * The name of the role
     * @var string
     */
    private $name;
    /**
     * getter Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * setter Name
     *
     * @param string $Name The name of the role
     *
     * @return Role
     */
    public function setName($Name)
    {
        $this->name = $Name;
        return $this;
    }
    /**
     * (non-PHPdoc)
     * @see BaseEntity::__toString()
     */
    public function __toString()
    {
        if(($name = trim($this->getName())) !== '')
            return $name;
        return parent::__toString();
    }
    /**
     * (non-PHPdoc)
     * @see BaseEntity::__loadDaoMap()
     */
    public function __loadDaoMap()
    {
        DaoMap::begin($this, 'r');
        DaoMap::setStringType('name', 'varchar');
        parent::__loadDaoMap();
        DaoMap::createUniqueIndex('name');
        DaoMap::commit();
    }
    /**
     * overload the get function from parent
     * 
     * @param int $id The id of the role
     * 
     * @return NULL
     */
    public static function get($id)
    {
    	if(!self::cacheExsits($id))
    		self::addCache($id, parent::get($id));
    	return self::getCache($id);
    }
}
?>
