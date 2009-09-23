<?php
/**
 * Copyright 2006, 2007, 2008, 2009 Eric D. Hough (http://ehough.com)
 * 
 * This file is part of TubePress (http://tubepress.org)
 * 
 * TubePress is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * TubePress is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with TubePress.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

function_exists('tubepress_load_classes')
    || require(dirname(__FILE__) . '/../../../../tubepress_classloader.php');
tubepress_load_classes(array('org_tubepress_options_category_Gallery',
    'org_tubepress_options_Category',
    'org_tubepress_options_form_WidgetPrinter',
    'org_tubepress_message_MessageService',
    'org_tubepress_options_reference_OptionsReference',
    'org_tubepress_options_storage_StorageManager',
    'net_php_pear_HTML_Template_IT'));

/**
 * Gets the HTML for an option category
 *
 */
class org_tubepress_options_form_CategoryPrinter
{
    private $_tpl;
    private $_optionsReference;
    private $_messageService;
    private $_tpsm;
    private $_wp;

    public function getHtml($optionCategoryName) {

        $this->_loadTemplateFile($optionCategoryName);

        $this->_tpl->setVariable("OPTION_CATEGORY_TITLE", 
                $this->_messageService->_("options-category-title-$optionCategoryName"));

        $this->_parseOptionCategory($optionCategoryName);        
                
        return $this->_tpl->get();
    }

    private function _parseOptionCategory($optionCategoryName)
    {
        switch ($optionCategoryName) {
            case org_tubepress_options_Category::META:
                $this->_parseMetaOptionsCategory();
                break;
            case org_tubepress_options_Category::GALLERY:
                $this->_parseGalleryOptionsCategory();
                break;
            default:
                $this->_parseRegularOptionsCategory($optionCategoryName);
        }
    }

    private function _parseGalleryOptionsCategory()
    {
        $modeNames = $this->_optionsReference->getValidEnumValues(org_tubepress_options_category_Gallery::MODE);
        foreach ($modeNames as $modeName) {
            
            $this->_tpl->setVariable("OPTION_TITLE",
                $this->_messageService->_("options-title-$modeName"));
            $this->_tpl->setVariable("OPTION_DESC",
                $this->_messageService->_("options-desc-$modeName"));
                
            $html = $this->_wp->getHtmlForRadio($modeName);
            
            if ($this->_optionsReference->isOptionName($modeName . "Value")) {
                $newName = $modeName . "Value";
                $html .= $this->_wp->getHtml($newName);
            }
            $this->_tpl->setVariable("OPTION_WIDGET", $html);
            $this->_tpl->parse('optionRow');
        }        
    }
    
    private function _parseMetaOptionsCategory()
    {
        $optionNames = $this->_optionsReference->getOptionNamesForCategory(org_tubepress_options_Category::META);
        
        $index = 1;
        foreach ($optionNames as $optionName) {
            
            $this->_parseCommonOptionInfo($optionName);
                
            if ($index % 4 == 0) {
                $this->_tpl->parse('optionRow');
            } else {
                $this->_tpl->parse('option');
            }
            $index++;
        }
    }  
    
    private function _parseRegularOptionsCategory($optionCategoryName)
    {
        $optionNames = $this->_optionsReference->getOptionNamesForCategory($optionCategoryName);
        
        foreach ($optionNames as $optionName) {
            
            $this->_parseCommonOptionInfo($optionName);
            $this->_tpl->parse('optionRow');
        }
    }    
    
    private function _parseCommonOptionInfo($optionName)
    {
        $this->_tpl->setVariable("OPTION_TITLE",
                $this->_messageService->_("options-title-$optionName"));
        $this->_tpl->setVariable("OPTION_DESC",
                $this->_messageService->_("options-desc-$optionName"));
        $this->_tpl->setVariable("OPTION_WIDGET",
                $this->_wp->getHtml($optionName));
	
	if ($this->_optionsReference->isOptionProOnly($optionName)) {
		$this->_tpl->setVariable("OPTION_PRO_ONLY", "*");
	}
    }
    
    private function _loadTemplateFile($optionCategoryName)
    {
        $this->_tpl = new net_php_pear_HTML_Template_IT(dirname(__FILE__) . "/../../../../../ui/options_page/html_templates");
        
        $name = $optionCategoryName == org_tubepress_options_Category::META ? "options_group_meta" : "options_group_regular";
        
        if (!$this->_tpl->loadTemplatefile("$name.tpl.html", true, true)) {
            throw new Exception("Could not load template for $optionCategoryName category");
        }
    }
    
    public function setMessageService(org_tubepress_message_MessageService $messageService) { $this->_messageService = $messageService; }
    public function setOptionsReference(org_tubepress_options_reference_OptionsReference $reference) { $this->_optionsReference = $reference; }
    public function setStorageManager(org_tubepress_options_storage_StorageManager $storageManager) { $this->_tpsm = $storageManager; }
    public function setWidgetPrinter(org_tubepress_options_form_WidgetPrinter $widgetPrinter) { $this->_wp = $widgetPrinter; }
}
