<?php
/**
 * Session Entity - storing the session data in the database
 *
 * @package    Core
 * @subpackage Entity
 * @author     lhe<helin16@gmail.com>
 */
class Session extends BaseEntityAbstract
{
    /**
     * The session ID
     *
     * @var string
     */
    private $key;
    /**
     * The session data
     *
     * @var string
     */
    private $data;
    /**
     * Getting the sesison ID
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }
    /**
     * Setter for the session ID
     *
     * @param string $key The
     *
     * @return string
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }
    /**
     * Getter for the session data
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }
    /**
     * Setter for the session data
     *
     * @param string $data The session data
     *
     * @return Session
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
	/**
	 * (non-PHPdoc)
	 * @see BaseEntity::toString()
	 */
	public function toString()
	{
        return $tis->data;
	}
	/**
	 * (non-PHPdoc)
	 * @see BaseEntity::loadDaoMap()
	 */
	public function __loadDaoMap()
	{
		DaoMap::begin($this, 'sess');
		DaoMap::setStringType('key', 'varchar', 32);
		DaoMap::setStringType('data', 'longtext');
		parent::__loadDaoMap();

		DaoMap::createUniqueIndex('key');
		DaoMap::commit();
	}
	/**
	 * init a session
	 *
	 * @return bool
	 */
	public function open()
	{
		return true;
	}
	/**
	 * close a session
	 *
	 * @return bool
	 */
	public function close()
	{
		return true;
	}
	/**
	 * Getting the Session Data
	 *
	 * @param string $sessionId The sesison ID
	 *
	 * @return string
	 */
	public function read($sessionId)
	{
		$session = self::getSession($sessionId);
		return ($session instanceof Session ? $session->getData() : '');
	}
	/**
	 * Writting the Session Data
	 *
	 * @param string $sessionId   The sesison ID
	 * @param string $sessionData The sesison data
	 *
	 * @return Session|null
	 */
	public function write($sessionId, $sessionData)
	{
		$user = (($user = Core::getUser()) instanceof UserAccount ? $user : UserAccount::get(UserAccount::ID_GUEST_ACCOUNT));
		Core::setUser($user, Core::getRole(), Core::getOrganization());
		$session = ($session = self::getSession($sessionId)) instanceof Session ? $session : new Session();
		$session->setKey($sessionId)
			->setData($sessionData)
			->save();
		return $session;
	}
	/**
	 * destroy the Session Data
	 *
	 * @param string $sessionId The sesison ID
	 *
	 * @return bool
	 */
	public function destroy($sessionId)
	{
		self::deleteByCriteria('`key` = ?', array($sessionId));
		return true;
	}
	/**
	 * delete all sessions that has been timed out
	 *
	 * @param int $maxTimeOut The number of seconds for the session's life time
	 *
	 * @return bool
	 */
	public function cleanUp($maxTimeOut)
	{
		$now = new UDate();
		$now->modify('-' . $maxTimeOut . ' second');
		return self::deleteByCriteria('`active` = 0 and `updated` < ?' , array($now->__toString()));
	}
	/**
	 * Getting the session object from the session ID
	 *
	 * @param string $sessionId The sesison ID
	 *
	 * @return Session|null
	 */
	public static function getSession($sessionId)
	{
		$session =self::getAllByCriteria('`key` = ?', array($sessionId), true, 1, 1);
		return (count($session) > 0 ? $session[0] : null);
	}
}

?>