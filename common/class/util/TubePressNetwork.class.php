<?php
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
 * Represents an HTML-embeddable YouTube player
 *
 */
class TubePressNetwork
{
    
    /**
     * Fetches the RSS from YouTube (or from cache)
     * 
     * @param TubePressOptionsManager $tpom The TubePress options manager
     * 
     * @return DOMDocument The raw RSS from YouTube
     */
    public static function getRss(TubePressOptionsManager $tpom)
    {
        /* First generate the request URL */
        $request = TubePressGalleryUrl::get($tpom);
        
        /* get a handle to the cache */
        $cache = new Cache_Lite(array("cacheDir" => sys_get_temp_dir()));

        /* cache miss? */
        if (!($data = $cache->get($request))) {
        	
        	/* go out and grab the response */
            $req =& new HTTP_Request($request);
            if (!PEAR::isError($req->sendRequest())) {
                $data = $req->getResponseBody();
            }
            /* and save it to the cache for next time */
            $cache->save($data, $request);
        }
        
        $doc = new DOMDocument();
        
        /*
         * Make sure we're looking at XML. This is a
         * bit hacky.
         */
        //TODO: find a better way to validate the response
        if (substr($data, 0, 5) != "<?xml") {
            return $doc;
        }
    
        $doc->loadXML($data);
        return $doc;
    }
}