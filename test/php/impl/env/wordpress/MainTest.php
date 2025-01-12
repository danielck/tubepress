<?php

require_once BASE . '/sys/classes/org/tubepress/impl/env/wordpress/Main.class.php';

class org_tubepress_impl_env_wordpress_MainTest extends TubePressUnitTest {

    function testContentFilter()
    {
        $ioc     = org_tubepress_impl_ioc_IocContainer::getInstance();

        $wpsm    = $ioc->get(org_tubepress_api_options_StorageManager::_);
        $wpsm->shouldReceive('get')->once()->with(org_tubepress_api_const_options_names_Advanced::KEYWORD)->andReturn('trigger word');

        $parser = $ioc->get(org_tubepress_api_shortcode_ShortcodeParser::_);
        $parser->shouldReceive('somethingToParse')->times(2)->with('the content', 'trigger word')->andReturn(true);
        $parser->shouldReceive('somethingToParse')->times(2)->with('html for shortcode', 'trigger word')->andReturn(true, false);

        $gallery = $ioc->get(org_tubepress_api_shortcode_ShortcodeHtmlGenerator::_);
        $gallery->shouldReceive('getHtmlForShortcode')->once()->with('the content')->andReturn('html for shortcode');
        $gallery->shouldReceive('getHtmlForShortcode')->once()->with('html for shortcode')->andReturn('html for shortcode');

        $context = $ioc->get(org_tubepress_api_exec_ExecutionContext::_);
        $context->shouldReceive('getActualShortcodeUsed')->times(4)->andReturn('<current shortcode>');
        $context->shouldReceive('reset')->twice();

        $ms      = $ioc->get(org_tubepress_api_message_MessageService::_);

        $this->assertEquals('html for shortcode', org_tubepress_impl_env_wordpress_Main::contentFilter('the content'));
    }

    function testHeadAction()
    {
        $is_admin = new PHPUnit_Extensions_MockFunction('is_admin');
        $is_admin->expects($this->once())->will($this->returnValue(false));

        $ioc = org_tubepress_impl_ioc_IocContainer::getInstance();
        $hh  = $ioc->get(org_tubepress_api_html_HeadHtmlGenerator::_);

        $hh->shouldReceive('getHeadInlineJs')->once()->andReturn('inline js');
        $hh->shouldReceive('getHeadHtmlMeta')->once()->andReturn('html meta');

        ob_start();
        org_tubepress_impl_env_wordpress_Main::headAction();
        $contents = ob_get_contents();
        ob_end_clean();

        $this->assertEquals('inline js
html meta', $contents);
    }

    function testInitAction()
    {
        $ioc = org_tubepress_impl_ioc_IocContainer::getInstance();
        $fs = $ioc->get(org_tubepress_api_filesystem_Explorer::_);
        $fs->shouldReceive('getTubePressInstallationDirectoryBaseName')->once()->andReturn('base_name');

	$plugins_url = new PHPUnit_Extensions_MockFunction('plugins_url');
	$plugins_url->expects($this->exactly(2))->will($this->_getPluginsUrlReturnMap());

        $is_admin = new PHPUnit_Extensions_MockFunction('is_admin');
        $is_admin->expects($this->once())->will($this->returnValue(false));

        $wp_register_script = new PHPUnit_Extensions_MockFunction('wp_register_script');
        $wp_register_script->expects($this->once())->with('tubepress', 'foobar');

        $wp_register_style = new PHPUnit_Extensions_MockFunction('wp_register_style');
        $wp_register_style->expects($this->once())->with('tubepress', 'fooey');

        $wp_enqueue_script = new PHPUnit_Extensions_MockFunction('wp_enqueue_script');
        $wp_enqueue_script->expects($this->exactly(2))->will($this->_getEnqueueScriptReturnMap());

        $wp_enqueue_style = new PHPUnit_Extensions_MockFunction('wp_enqueue_style');
        $wp_enqueue_style->expects($this->once())->with('tubepress');

        org_tubepress_impl_env_wordpress_Main::initAction();
    }

    private function _getPluginsUrlReturnMap()
    {
         $returnMapBuilder = new PHPUnit_Extensions_MockObject_Stub_ReturnMapping_Builder();

         $returnMapBuilder->addEntry()->with(array('base_name/sys/ui/static/js/tubepress.js', 'base_name'))->will($this->returnValue('foobar'));
         $returnMapBuilder->addEntry()->with(array('base_name/sys/ui/themes/default/style.css', 'base_name'))->will($this->returnValue('fooey'));

         return $returnMapBuilder->build();
    }

    private function _getEnqueueScriptReturnMap()
    {
         $returnMapBuilder = new PHPUnit_Extensions_MockObject_Stub_ReturnMapping_Builder();

         $returnMapBuilder->addEntry()->with(array('jquery'));
         $returnMapBuilder->addEntry()->with(array('tubepress'));

         return $returnMapBuilder->build();
    }
}
