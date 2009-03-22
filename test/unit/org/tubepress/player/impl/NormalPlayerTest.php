<?php

require_once dirname(__FILE__) . '/../../../../../../classes/org/tubepress/player/impl/NormalPlayer.class.php';

class org_tubepress_player_impl_NormalPlayerTest extends PHPUnit_Framework_TestCase {
    
	private $_sut;
	private $_tpeps;
	private $_tpom;
	private $_video;
	private $_ioc;
	
	function setUp()
	{
		$this->_sut = new org_tubepress_player_impl_NormalPlayer();
		$this->_tpeps = $this->getMock("org_tubepress_embedded_EmbeddedPlayerService");
		$this->_tpom = $this->getMock("org_tubepress_options_manager_OptionsManager");
		$this->_video = $this->getMock('org_tubepress_video_Video');
		$this->_ioc = $this->getMock('org_tubepress_ioc_IocService');
		$this->_sut->setContainer($this->_ioc);
		$this->_sut->setOptionsManager($this->_tpom);
	}
	
	function testGetPreGalleryHtml()
	{
		$this->_tpeps->expects($this->once())
		  			 ->method("toString")
		  			 ->will($this->returnValue("fakeembedcode"));
		$this->_tpom->expects($this->exactly(2))
					->method("get")
					->will($this->returnValue(10)); 
		$this->_ioc->expects($this->once())
		           ->method('safeGet')
		           ->will($this->returnValue($this->_tpeps)); 
		$this->_video->expects($this->once())
		             ->method("getTitle")
		             ->will($this->returnValue("faketitle"));
		  			 
		$this->assertEquals(<<<EOT
<div class="tubepress_normal_embedded_wrapper">
	<div class="tubepress_normal_embedded_inner" style="width: 10px">
    	<div id="tubepress_embedded_title_12" class="tubepress_embedded_title">faketitle</div>
        <div id="tubepress_embedded_object_12">fakeembedcode</div>
    </div><!-- tubepress_inner -->
</div> <!--tubepress_mainvideo--> <br />
EOT
			, $this->_sut->getPreGalleryHtml($this->_video, 12));
	}
}
?>