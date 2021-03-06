<?php
/**
 * Global core settings and operations, This is for runtime only
 *
 * @package    Core
 * @subpackage Utils
 * @author     lhe<helin16@gmail.com>
 */
abstract class Core
{
    /**
     * The storage for the Core at the runtime level
     *
     * @var array
     */
	private static $_storage = array('user' => null, 'role' => null, 'organization' => null);
    /**
     * Setting the role in the core
     *
     * @param Role $role The role
     */
	public static function setRole(Role $role)
	{
		self::setUser(self::getUser(), $role);
	}
	/**
	 * removing core role
	 */
	public static function rmRole()
	{
	    self::$_storage['role'] = null;
	}
	/**
	 * Set the active user on the core for auditing purposes
	 *
	 * @param UserAccount  $userAccount The useraccount
	 * @param Role         $role        The role
	 * @param Organization $org         The Organization
	 */
	public static function setUser(UserAccount $userAccount, Role $role = null, Organization $org = null)
	{
		self::$_storage['user'] = $userAccount;
		self::$_storage['role'] = $role;
		self::$_storage['organization'] = $org;
	}
	/**
	 * removing core user
	 */
	public static function rmUser()
	{
	    self::$_storage['user'] = null;
	    self::rmRole();
	}
	/**
	 * Get the current user set against the System for auditing purposes
	 *
	 * @return UserAccount
	 */
	public static function getUser()
	{
		return self::$_storage['user'];
	}
	/**
	 * Get the current user role set against the System for Dao filtering purposes
	 *
	 * @return Role
	 */
	public static function getRole()
	{
		return self::$_storage['role'] instanceof Role ? self::$_storage['role'] : null;
	}
    /**
     * serialize all the components in core
     *
     * @return string
     */
	public static function serialize()
	{
		$array['userId'] = self::$_storage['user'] instanceof UserAccount ? self::$_storage['user']->getId() : null;
		$array['roleId'] = self::$_storage['role'] instanceof UserAccount ? self::$_storage['role']->getId() : null;
		$array['organizationId'] = self::$_storage['organization'] instanceof Organization ? self::$_storage['organization']->getId() : null;
		return serialize($array);
	}
	/**
	 * unserialize all the components and store them in Core
	 *
	 * @param string $string The serialized core storage string
	 */
	public static function unserialize($string)
	{
		$array = unserialize($string);
		self::$_storage['user'] = self::$_storage['user'] instanceof UserAccount ? self::$_storage['user'] : (isset($array['userId']) ? UserAccount::get($array['userId']) : null);
		self::$_storage['role'] = self::$_storage['role'] instanceof Role ? self::$_storage['role'] : (isset($array['roleId']) ? Role::get($array['roleId']) : null);
		self::$_storage['organization'] = self::$_storage['organization'] instanceof Organization ? self::$_storage['organization'] : (isset($array['organizationId']) ? Organization::get($array['organizationId']) : null);
		return self::$_storage;
	}
	/**
	 * getting the Organization
	 *
	 * @return Organization|null
	 */
	public static function getOrganization()
	{
		return self::$_storage['organization'];
	}
	/**
	 * Getting the application's meta information
	 *
	 * @return multitype:Mixed
	 */
	public static function getAppMetaInfo()
	{
		return array('name' => Config::get('Application', 'name'), 'version' => Config::get('Application', 'version'), 'Logo' => Config::get('Application', 'logo'));
	}
}

?>