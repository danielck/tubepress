<?php
require_once dirname(__FILE__) . '/../../../includes/TubePressUnitTest.php';
require_once 'WordPressMessageServiceTest.php';

class org_tubepress_impl_message_MessageTestSuite
{
	public static function suite()
	{
		return new TubePressUnitTestSuite(array(
            'org_tubepress_message_WordPressMessageServiceTest'
       	));
	}
}

