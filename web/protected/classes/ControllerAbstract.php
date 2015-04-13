<?php
abstract class ControllerAbstract
{
	/**
	 * Returns a JSON string object to the browser when hitting the root of the domain
	 *
	 * @url GET /
	 */
	public function index() {
		return 'test';
	}
}