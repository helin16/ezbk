<?php
/**
 * UserAccount Entity
 *
 * @package    Core
 * @subpackage Entity
 * @author     lhe<helin16@gmail.com>
 */
class UserAccount extends ConfirmEntityAbstract
{
    /**
     * The id of the GUEST account
     *
     * @var int
     */
    const ID_GUEST_ACCOUNT = 1;
    /**
     * The id of the system account
     *
     * @var int
     */
    const ID_SYSTEM_ACCOUNT = 42;
    /**
     * The username
     *
     * @var string
     */
    private $username;
    /**
     * The password
     *
     * @var string
     */
    private $password;
    /**
     * the person of the user account
     *
     * @var Person
     */
    protected $person;
   	/**
   	 * Getter for username
   	 *
   	 * @return string
   	 */
   	public function getUsername()
   	{
   	    return $this->username;
   	}
   	/**
   	 * Setter for username
   	 *
   	 * @param string $value The username
   	 *
   	 * @return UserAccount
   	 */
   	public function setUsername($value)
   	{
   	    $this->username = $value;
   	    return $this;
   	}
    /**
     * getter Password
     *
     * @return String
     */
    public function getPassword()
    {
        return $this->password;
    }
    /**
     * Setter Password
     *
     * @param string $Password The password
     *
     * @return UserAccount
     */
    public function setPassword($password, $encryptPass = false)
    {
        $this->password = ($encryptPass === true ? self::encryptPass($password) : $password);
        return $this;
    }
    /**
     * getter Person
     *
     * @return Person
     */
    public function getPerson()
    {
        $this->loadManyToOne("person");
        return $this->person;
    }
    /**
     * Setter Person
     *
     * @param Person $Person The person that this useraccount belongs to
     *
     * @return UserAccount
     */
    public function setPerson(Person $Person)
    {
        $this->person = $Person;
        return $this;
    }
    /**
     * (non-PHPdoc)
     * @see BaseEntity::__toString()
     */
    public function __toString()
    {
        return $this->getUsername();
    }
    /**
     * Getting the full name of the user
     * @return string
     */
    public function getFullName()
    {
    	return trim($this->getPerson()->getFullName());
    }
    /**
     * (non-PHPdoc)
     * @see BaseEntityAbstract::getJson()
     */
    public function getJson($extra = array(), $reset = false)
    {
    	if(!$this->isJsonLoaded($reset))
    	{
    		$extra['person'] = $this->getPerson()->getJson();
    	}
    	return parent::getJson($extra, $reset);
    }
    /**
     * (non-PHPdoc)
     * @see BaseEntityAbstract::preSave()
     */
    public function preSave()
    {
    	if(trim($this->getUsername()) === '')
    		throw new EntityException('Username can NOT be empty', 'exception_entity_useraccount_username_empty');
    	if(trim($this->getPassword()) === '')
    		throw new EntityException('Password can NOT be empty', 'exception_entity_useraccount_password_empty');
    	parent::preSave();
    }
    /**
     * (non-PHPdoc)
     * @see BaseEntity::__loadDaoMap()
     */
    public function __loadDaoMap()
    {
        DaoMap::begin($this, 'ua');
        DaoMap::setStringType('username', 'varchar', 100);
        DaoMap::setStringType('password', 'varchar', 40);
        DaoMap::setManyToOne('person', 'Person');
        parent::__loadDaoMap();

        DaoMap::createIndex('username');
        DaoMap::createIndex('password');
        DaoMap::commit();
    }
    /**
     * Getting UserAccount
     *
     * @param string  $email    The email string
     * @param string  $password The password string
     *
     * @throws AuthenticationException
     * @throws Exception
     * @return Ambigous <BaseEntityAbstract>|NULL
     */
    public static function getUserByUsernameAndPassword($username, $password, $noHashPass = false)
    {
    	$query = self::getQuery();
    	$userAccounts = self::getAllByCriteria("`username` = :username AND `Password` = :password", array('username' => $username, 'password' => ($noHashPass === true ? $password : self::encryptPass($password))), true, 1, 1);
    	if(count($userAccounts) > 0)
    		return $userAccounts[0];
    	return null;
    }
    /**
     * encrypt password
     *
     * @param string $password
     *
     * @return string
     */
    public static function encryptPass($password)
    {
    	return sha1($password);
    }
    /**
     * Creating a new useraccount
     *
     * @param unknown $username
     * @param unknown $password
     * @param Person  person
     *
     * @return UserAccount
     */
    public static function create($username, $password, Person $person, $encryptedPass = true)
    {
    	$userAccount = new UserAccount();
    	return $userAccount->setUserName($username)
    		->setPassword($password, !$encryptedPass)
    		->setPerson($person)
    		->save()
    		->needToConfirm('UserAccount Created')
    		->addLog(Log::TYPE_SYS, 'UserAccount created with (username=' . $username . ') with person(id=' . $person->getId() . ')');
    }
    /**
     * Updating an useraccount
     *
     * @param UserAccount $userAccount
     * @param string      $username
     * @param string      $password
     *
     * @return Ambigous <BaseEntity, BaseEntityAbstract>
     */
    public static function updateUser(UserAccount &$userAccount, $username, $password, $encryptedPass = true)
    {
    	return $userAccount->setUserName($username)
    		->setPassword($password, !$encryptedPass)
    		->save()
    		->addLog(Log::TYPE_SYS, 'UserAccount updated with (username=' . $username . ') with person(id=' . $userAccount->getPerson()->getId() . ')' );
    }
}

?>
