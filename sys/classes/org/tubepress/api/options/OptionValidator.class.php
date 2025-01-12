<?php
/**
 * Copyright 2006 - 2011 Eric D. Hough (http://ehough.com)
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
 * Performs validation on option values
 */
interface org_tubepress_api_options_OptionValidator
{
    const _ = 'org_tubepress_api_options_OptionValidator';

    /**
     * Validates an option value. Will throw an Exception if validation
     * fails.
     *
     * @param string       $optionName The option name
     * @param unknown_type $candidate  The candidate option value
     *
     * @return void
    */
    function validate($optionName, $candidate);
}
