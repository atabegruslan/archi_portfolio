<?php
/**
 * @package    solo
 * @copyright  Copyright (c)2014-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license    GNU GPL version 3 or later
 */

// Protection against direct access
use Akeeba\Engine\Factory;
use Awf\Text\Text;

defined('AKEEBAENGINE') or die();

/**
 * Checks for database permissions (SHOW permissions)
 */
class AliceCoreDomainChecksRequirementsDbpermissions extends AliceCoreDomainChecksAbstract
{
    public function __construct($logFile = null)
    {
        parent::__construct(40, 'COM_AKEEBA_ALICE_ANALYZE_REQUIREMENTS_DBPERMISSIONS', $logFile);
    }

	public function check()
	{
        $db = Factory::getDatabase();

		// Can I execute SHOW statements?
		try
		{
			$result = $db->setQuery('SHOW TABLES')->query();
		}
		catch(Exception $e)
		{
			AliceUtilLogger::WriteLog(_AE_LOG_INFO, $this->checkName." Test failed, can't execute SHOW TABLES statement");

			$this->setResult(-1);
			$this->setErrLangKey('COM_AKEEBA_ALICE_ANALYZE_REQUIREMENTS_DBPERMISSIONS_ERROR');

			throw new Exception(Text::_('COM_AKEEBA_ALICE_ANALYZE_REQUIREMENTS_DBPERMISSIONS_ERROR'));
		}

		if(!$result)
		{
			AliceUtilLogger::WriteLog(_AE_LOG_INFO, $this->checkName." Test failed, can't execute SHOW TABLES statement");

			$this->setResult(-1);
			$this->setErrLangKey('COM_AKEEBA_ALICE_ANALYZE_REQUIREMENTS_DBPERMISSIONS_ERROR');

			throw new Exception(Text::_('COM_AKEEBA_ALICE_ANALYZE_REQUIREMENTS_DBPERMISSIONS_ERROR'));
		}

		try
		{
			$result = $db->setQuery('SHOW CREATE TABLE '.$db->nameQuote('#__ak_profiles'))->query();
		}
		catch(Exception $e)
		{
			AliceUtilLogger::WriteLog(_AE_LOG_INFO, $this->checkName." Test failed, can't execute SHOW CREATE TABLE statement");

			$this->setResult(-1);
			$this->setErrLangKey('COM_AKEEBA_ALICE_ANALYZE_REQUIREMENTS_DBPERMISSIONS_ERROR');

			throw new Exception(Text::_('COM_AKEEBA_ALICE_ANALYZE_REQUIREMENTS_DBPERMISSIONS_ERROR'));
		}

		if(!$result)
		{
			AliceUtilLogger::WriteLog(_AE_LOG_INFO, $this->checkName." Test failed, can't execute SHOW CREATE TABLE statement");

			$this->setResult(-1);
			$this->setErrLangKey('COM_AKEEBA_ALICE_ANALYZE_REQUIREMENTS_DBPERMISSIONS_ERROR');

			throw new Exception(Text::_('COM_AKEEBA_ALICE_ANALYZE_REQUIREMENTS_DBPERMISSIONS_ERROR'));
		}

		return true;
	}

	public function getSolution()
	{
		return Text::_('COM_AKEEBA_ALICE_ANALYZE_REQUIREMENTS_DBPERMISSIONS_SOLUTION');
	}
}
