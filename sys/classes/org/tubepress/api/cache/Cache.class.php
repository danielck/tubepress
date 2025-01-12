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
 * String cache for TubePress
 */
interface org_tubepress_api_cache_Cache
{
    const _ = 'org_tubepress_api_cache_Cache';

    /**
     * Get a value from the cache
     *
     * @param string $key The key of the data to retrieve
     *
     * @return string The data at the given key, or false if not there
     */
    function get($key);

    /**
     * Save the given data with the given key
     *
     * @param string $key  The key at which to save the data
     * @param string $data The data to save at the key
     *
     * @return void
     */
    function save($key, $data);
}
