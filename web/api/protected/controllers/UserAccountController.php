<?php
class UserAccountController extends ControllerAbstract
{
	public function __construct($entityClass) {
		parent::__construct('UserAccount');
	}
	/**
	 * Returns a JSON string object to the browser when hitting the root of the domain
	 *
     * @url GET /current
	 */
	public function getUser($id = null) {
        return Core::getUser() instanceof UserAccount ? Core::getUser()->getJson() : array(); // serializes object into JSON
	}
	/**
     * Logs in a user with the given username and password POSTed. Though true
     * REST doesn't believe in sessions, it is often desirable for an AJAX server.
     *
     * @url POST /login
     */
    public function login() {
        if(!isset($_POST['username']) || ($username = trim($_POST['username'])) === '');
        	throw new RestException(400, 'Invalid username provided');
        if(!isset($_POST['password']) || ($password = trim($_POST['password'])) === '');
        	throw new RestException(400, 'Invalid password provided');
        $user = UserAccount::getUserByUsernameAndPassword($username, $password);
        if(!$user instanceof UserAccount)
        	throw new RestException(400, 'Invalid User');
        Core::setUser($user);
        return $user->getJson();
    }

}