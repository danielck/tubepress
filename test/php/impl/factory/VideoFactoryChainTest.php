<?php

require_once BASE . '/sys/classes/org/tubepress/impl/factory/VideoFactoryChain.class.php';

class org_tubepress_impl_factory_VideoFactoryChainTest extends TubePressUnitTest {

    private $_sut;

    function setUp()
    {
        parent::setUp();
        $this->_sut = new org_tubepress_impl_factory_VideoFactoryChain();
    }

    function testNobodyCanHandle()
    {
        $ioc = org_tubepress_impl_ioc_IocContainer::getInstance();

        $pc = $ioc->get(org_tubepress_api_provider_ProviderCalculator::_);
        $pc->shouldReceive('calculateCurrentVideoProvider')->once()->andReturn('providerrr');

        $mockChainContext = \Mockery::mock('stdClass');
        $mockChainContext->returnValue = array('one', 'two');

        $chain = $ioc->get(org_tubepress_spi_patterns_cor_Chain::_);
        $chain->shouldReceive('execute')->once()->with(anInstanceOf('stdClass'), array(
                'org_tubepress_impl_factory_commands_YouTubeFactoryCommand',
                'org_tubepress_impl_factory_commands_VimeoFactoryCommand'
        ))->andReturn(false);
        $chain->shouldReceive('createContextInstance')->once()->andReturn($mockChainContext);

        $this->assertEquals(array(), $this->_sut->feedToVideoArray('bla'));
    }

    function testConvert()
    {
        $ioc = org_tubepress_impl_ioc_IocContainer::getInstance();

        $pm  = $ioc->get(org_tubepress_api_plugin_PluginManager::_);
        $pm->shouldReceive('hasFilters')->once()->with(org_tubepress_api_const_plugin_FilterPoint::VIDEO)->andReturn(true);
        $pm->shouldReceive('runFilters')->once()->with(org_tubepress_api_const_plugin_FilterPoint::VIDEO, 'one', 'providerrr')->andReturn('modified one');
        $pm->shouldReceive('runFilters')->once()->with(org_tubepress_api_const_plugin_FilterPoint::VIDEO, 'two', 'providerrr')->andReturn('modified two');

        $pc = $ioc->get(org_tubepress_api_provider_ProviderCalculator::_);
        $pc->shouldReceive('calculateCurrentVideoProvider')->once()->andReturn('providerrr');

        $mockChainContext = \Mockery::mock('stdClass');
        $mockChainContext->returnValue = array('one', 'two');

        $chain = $ioc->get(org_tubepress_spi_patterns_cor_Chain::_);
        $chain->shouldReceive('execute')->once()->with(anInstanceOf('stdClass'), array(
            'org_tubepress_impl_factory_commands_YouTubeFactoryCommand',
            'org_tubepress_impl_factory_commands_VimeoFactoryCommand'
        ))->andReturn(true);
        $chain->shouldReceive('createContextInstance')->once()->andReturn($mockChainContext);

        $this->assertEquals(array('modified one', 'modified two'), $this->_sut->feedToVideoArray('bla'));
    }
}