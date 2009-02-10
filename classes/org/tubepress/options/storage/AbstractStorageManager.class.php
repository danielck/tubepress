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

/**
 * Handles persistent storage of TubePress options
 *
 */
abstract class org_tubepress_options_storage_AbstractStorageManager implements org_tubepress_options_storage_StorageManager
{   
	private $_validationService;
	private $_optionsReference;
	
    /**
     * Creates an option in storage
     *
     * @param unknown_type $optionName  The name of the option to create
     * @param unknown_type $optionValue The default value of the new option
     * 
     * @return void
     */
    protected abstract function create($optionName, $optionValue);    
    
    /**
     * Print out debugging info for this
     * storage manager
     *
     * @return void
     */
    public final function debug()
    {
    	$allOpts = $this->_optionsReference->getAllOptionNames();
        
        $result = "Should have " . sizeof($allOpts) . " options total";
        
        $result .= "<ol>";
        foreach ($allOpts as $opt) {
            if ($this->exists($opt)) {
                $result .= "<li><font color=\"green\">" .
                    "$opt exists and its value is \"" . $this->get($opt) .
                    "\"</font></li>";
            } else {
                $result .= "<li><font color=\"red\">" .
                    "$opt does not exist!</font></li>";
            }
            
        }
        $result .= "</ol>";
        return $result;
    }    
    
    /**
     * Deletes an option from storage
     *
     * @param unknown_type $optionName The name of the option to delete
     * 
     * @return void
     */
    protected abstract function delete($optionName);    
     
    /**
     * Initialize the persistent storage
     * 
     * @return void
     */
    public final function init()
    {
    	$allOptionNames = $this->_optionsReference->getAllOptionNames();
    	$vals = array();
    	foreach ($allOptionNames as $optionName) {
    	    $vals[$optionName] = $this->_optionsReference->getDefaultValue($optionName);
    	}
    	
    	foreach($vals as $val => $key) {
    		$this->_init($val, $key);
    	}
    }    

    private function _init($name, $value)
    {
    	if (!$this->exists($name)) {
    		$this->delete($name);
    		$this->create($name, $value);
    	}
    }
    
    /**
     * Sets an option value
     *
     * @param string       $optionName  The option name
     * @param unknown_type $optionValue The option value
     * 
     * @return void
     */
    public final function set($optionName, $optionValue)
    {
        $this->_validationService->validate($optionName, $optionValue);
        $this->setOption($optionName, $optionValue);
    }    
    
    /**
     * Sets an option to a new value, without validation
     *
     * @param string       $optionName  The name of the option to update
     * @param unknown_type $optionValue The new option value
     * 
     * @return void
     */
    protected abstract function setOption($optionName, $optionValue);
    
    /**
     * Set the org_tubepress_options_validation_InputValidationService
     *
     * @param org_tubepress_options_validation_InputValidationService $validationService The validation service
     */
    public function setValidationService(org_tubepress_options_validation_InputValidationService $validationService)
    {
    	$this->_validationService = $validationService;
    }
    
    /**
     * Set the org_tubepress_options_reference_OptionsReference
     *
     * @param org_tubepress_options_reference_OptionsReference $reference The options reference
     */
    public function setOptionsReference(org_tubepress_options_reference_OptionsReference $reference)
    {
        $this->_optionsReference = $reference;
    }
}