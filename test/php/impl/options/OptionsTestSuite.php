<?php
require_once dirname(__FILE__) . '/../../../includes/TubePressUnitTestSuite.php';
require_once 'WordPressStorageManagerTest.php';
require_once 'SimpleOptionValidatorTest.php';
require_once 'FormHandlerTest.php';
require_once 'OptionsReferenceTest.php';

class org_tubepress_impl_options_OptionsTestSuite
{
	public static function suite()
	{
		return new TubePressUnitTestSuite(array(
            'org_tubepress_impl_options_WordPressStorageManagerTest',
            'org_tubepress_impl_options_SimpleOptionValidatorTest',
            'org_tubepress_impl_options_FormHandlerTest',
            'org_tubepress_impl_options_OptionsReferenceTest'
		));
	}
}

