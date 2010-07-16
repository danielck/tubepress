<?php
/**
 * Copyright 2006 - 2010 Eric D. Hough (http://ehough.com)
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
 * HTTP client detection service.
 */
class org_tubepress_browser_BrowserDetector
{
    const IPHONE  = 'iphone';
    const IPOD    = 'ipod';
    const UNKNOWN = 'unknown';

    const HTTP_USER_AGENT = 'HTTP_USER_AGENT';

    /**
     * Determines which HTTP client is in use.
     * 
     * @param array $serverVars The PHP $_SERVER variable.
     *
     * @return string iphone, ipod, or unknown.
     */
    public static function detectBrowser($serverVars)
    {
        if (!is_array($serverVars)
            || !array_key_exists(self::HTTP_USER_AGENT, $serverVars)) {
            return self::UNKNOWN;
        }

        $agent = $serverVars[self::HTTP_USER_AGENT];

        if (strstr($agent, 'iPhone')) {
            return self::IPHONE;
        }

        if (strstr($agent, 'iPod')) {
            return self::IPOD;
        }

        return self::UNKNOWN;
    }
}

