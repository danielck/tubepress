<?php
require_once '/Applications/MAMP/bin/php5/lib/php/PHPUnit/Framework.php';
require_once 'ProviderTest.php';

class ProviderTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('TubePress Video Provider Tests');
        $suite->addTestSuite('org_tubepress_video_feed_provider_ProviderTest');
        return $suite;
    }
}
?>