<?php
/**
 * Boostrapper for the Core module
 *
 * @package Core
 * @author  lhe
 */
abstract class SystemCoreAbstract
{
    /**
     * autoloading function
     *
     * @param string $className The class that we are trying to autoloading
     *
     * @return boolean Whether we loaded the class
     */
	public static function autoload($className)
	{
		$base = dirname(__FILE__);
		$autoloadPaths = array(
			$base . '/conf/',
			$base . '/db/',
			$base . '/entity/',
			$base . '/entity/accounting/',
			$base . '/entity/content/',
			$base . '/entity/property/',
			$base . '/entity/system/',
			$base . '/entity/tag/',
			$base . '/exception/',
			$base . '/util/',
			$base . '/util/Connectors',
			$base . '/util/Connectors/comms/',
		);
		foreach ($autoloadPaths as $path)
		{
			if (file_exists($file = trim($path . $className . '.php')))
			{
				require_once $file;
				return true;
			}
		}
		return false;
	}
}
spl_autoload_register(array('SystemCoreAbstract','autoload'));
// Bootstrap the Prado framework
// require_once dirname(__FILE__) . '/../3rdParty/PHPExcel/Classes/PHPExcel.php';
// require_once dirname(__FILE__) . '/../3rdParty/PHPMailer/PHPMailerAutoload.php';

?>