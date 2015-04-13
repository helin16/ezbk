<?php
class UserAccountController extends ControllerAbstract
{
	/**
	 * Returns a JSON string object to the browser when hitting the root of the domain
	 *
	 * @url GET /$id
     * @url GET /current
	 */
	public function getUser($id = null) {
		var_dump('test');
		if ($id) {
            $user = UserAccount::get($id); // possible user loading method
        } else {
            $user = $_SESSION['user'];
        }
        return $user; // serializes object into JSON
	}
}