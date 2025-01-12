<?php

require_once BASE . '/sys/classes/org/tubepress/impl/ioc/FreeWordPressPluginIocService.class.php';

class org_tubepress_impl_ioc_FreeWordPressPluginIocServiceTest extends TubePressUnitTest {

    private $_sut;
    private $_expectedMapping;

    function setUp()
    {
        $this->_sut = new org_tubepress_impl_ioc_FreeWordPressPluginIocService();
        $this->_expectedMapping = array(

        'org_tubepress_api_bootstrap_Bootstrapper'=>'org_tubepress_impl_bootstrap_TubePressBootstrapper',
        'org_tubepress_api_cache_Cache'=>'org_tubepress_impl_cache_PearCacheLiteCacheService',
        'org_tubepress_api_embedded_EmbeddedHtmlGenerator'=>'org_tubepress_impl_embedded_EmbeddedPlayerChain',
        'org_tubepress_api_environment_Detector'=>'org_tubepress_impl_environment_SimpleEnvironmentDetector',
        'org_tubepress_api_factory_VideoFactory'=>'org_tubepress_impl_factory_VideoFactoryChain',
        'org_tubepress_api_feed_FeedFetcher'=>'org_tubepress_impl_feed_CacheAwareFeedFetcher',
        'org_tubepress_api_feed_FeedInspector'=>'org_tubepress_impl_feed_FeedInspectorChain',
        'org_tubepress_api_filesystem_Explorer'=>'org_tubepress_impl_filesystem_FsExplorer',
        'org_tubepress_api_html_HeadHtmlGenerator'=>'org_tubepress_impl_html_DefaultHeadHtmlGenerator',
        'org_tubepress_api_http_HttpClient'=>'org_tubepress_impl_http_HttpClientChain',
        'org_tubepress_api_message_MessageService'=>'org_tubepress_impl_message_WordPressMessageService',
        'org_tubepress_api_exec_ExecutionContext'=>'org_tubepress_impl_exec_MemoryExecutionContext',
        'org_tubepress_api_options_OptionValidator'=>'org_tubepress_impl_options_SimpleOptionValidator',
        'org_tubepress_api_options_StorageManager'=>'org_tubepress_impl_options_WordPressStorageManager',
        'org_tubepress_api_plugin_PluginManager'=>'org_tubepress_impl_plugin_PluginManagerImpl',
        'org_tubepress_spi_patterns_cor_Chain'=>'org_tubepress_impl_patterns_cor_ChainGang',
        'org_tubepress_api_player_PlayerHtmlGenerator'=>'org_tubepress_impl_player_DefaultPlayerHtmlGenerator',
        'org_tubepress_api_provider_Provider'=>'org_tubepress_impl_provider_SimpleProvider',
        'org_tubepress_api_provider_ProviderCalculator'=>'org_tubepress_impl_provider_SimpleProviderCalculator',
        'org_tubepress_api_querystring_QueryStringService'=>'org_tubepress_impl_querystring_SimpleQueryStringService',
        'org_tubepress_api_shortcode_ShortcodeHtmlGenerator'=>'org_tubepress_impl_shortcode_ShortcodeHtmlGeneratorChain',
        'org_tubepress_api_shortcode_ShortcodeParser'=>'org_tubepress_impl_shortcode_SimpleShortcodeParser',
        'org_tubepress_api_template_TemplateBuilder' => 'org_tubepress_impl_template_SimpleTemplateBuilder',
        'org_tubepress_api_theme_ThemeHandler'=>'org_tubepress_impl_theme_SimpleThemeHandler',
        'org_tubepress_api_feed_UrlBuilder'=>'org_tubepress_impl_feed_UrlBuilderChain',
        );
    }

    /**
     * @expectedException Exception
     */
    function testNoBindCall()
    {
        $this->_sut->to('fa');
    }

    /**
     * @expectedException Exception
     */
    function testNeverBound()
    {
        $this->_sut->get('something');
    }

    function testGetTwice()
    {
        $result = $this->_sut->get('org_tubepress_impl_ioc_FreeWordPressPluginIocServiceTest');
        $this->assertNotNull($result);
        $result2 = $this->_sut->get('org_tubepress_impl_ioc_FreeWordPressPluginIocServiceTest');
        $this->assertEquals($result, $result2);
    }

    function testSingleton()
    {
        $this->assertNotNull($this->_sut->get('org_tubepress_impl_ioc_FreeWordPressPluginIocServiceTest'));
    }

    function testMapping()
    {
        $get_option = new PHPUnit_Extensions_MockFunction('get_option');
        $get_option->expects($this->any())->with('tubepress-version')->will($this->returnValue(226));

        foreach ($this->_expectedMapping as $key => $value) {
            $test = is_a($this->_sut->get($key), $value);
            if (!$test) {
                print "$value is not a $key\n";
            }
            $this->assertTrue($test);
        }
    }
}

