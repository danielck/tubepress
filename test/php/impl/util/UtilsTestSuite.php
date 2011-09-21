<?php
require_once dirname(__FILE__) . '/../../../includes/TubePressUnitTestSuite.php';
require_once 'StringUtilsTest.php';
require_once 'TimeUtilsTest.php';

class org_tubepress_impl_util_UtilsTestSuite
{
	public static function suite()
	{
		return new TubePressUnitTestSuite(array(
            'org_tubepress_impl_util_StringUtilsTest',
		    'org_tubepress_impl_util_TimeUtilsTest'
		));
	}
}

