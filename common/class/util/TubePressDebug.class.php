﻿<?php
/**
 * Copyright 2006, 2007, 2008 Eric D. Hough (http://ehough.com)
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
 * Performs various debugging functions
 *
 */
class TubePressDebug
{
    /**
     * Executes the debugging. Amazing!
     *
     * @param TubePressOptionsManager $tpom The TubePress options manager
     * @param TubePressStorageManager $tpsm The TubePress storage manager
     * 
     * @return void
     */
    public static final function execute(TubePressOptionsManager $tpom, 
        TubePressStorageManager $tpsm)
    {
        global $tubepress_base_url;
        $tpomAsString = print_r($tpom, true);
        $tpsmAsString = $tpsm->debug();

        echo "<ol>";
        echo "<li>tubepress_base_url<code><pre>" .
            "$tubepress_base_url</pre></code></li>";
        echo "<li>Your options manager: <code><pre>" .
            "$tpomAsString</pre></code></li>";
        echo "<li>Your storage manager: <code><pre>" .
            "$tpsmAsString</pre></code></li>";
        echo "<li>Click <a href=\"" . $tubepress_base_url . 
            "/common/class/util/TubePressConnectionTest.php\">here</a> to view the results of the YouTube connection test.</li>"; 
        echo "</ol>";
    }
    
    /**
     * Determines if we are in debug mode
     *
     * @param TubePressOptionsManager $tpom The TubePress options manager
     * 
     * @return boolean True if we're in debug mode, false otherwise
     */
    public static final function areWeDebugging(TubePressOptionsManager $tpom)
    {
        $enabled = $tpom->get(TubePressAdvancedOptions::DEBUG_ON);
        return $enabled
            && isset($_GET['tubepress_debug'])
            && ($_GET['tubepress_debug'] == 'true');
    }
    
}