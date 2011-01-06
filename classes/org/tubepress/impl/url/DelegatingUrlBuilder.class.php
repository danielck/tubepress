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

function_exists('tubepress_load_classes')
    || require(dirname(__FILE__) . '/../../../../tubepress_classloader.php');
tubepress_load_classes(array('org_tubepress_api_url_UrlBuilder',
    'org_tubepress_api_provider_Provider',
    'org_tubepress_ioc_IocDelegateUtils',
    'org_tubepress_api_url_UrlBuilder'));

/**
 * Builds URLs based on the urrent provider
 *
 */
class org_tubepress_impl_url_DelegatingUrlBuilder implements org_tubepress_api_url_UrlBuilder
{
    /**
     * Builds a URL for a list of videos
     *
     * @return string The request URL for this gallery
     */
    public function buildGalleryUrl($currentPage)
    {
        $ioc     = org_tubepress_impl_ioc_IocContainer::getInstance();
        $pc      = $ioc->get('org_tubepress_api_provider_ProviderCalculator');
        $builder = $ioc->get('org_tubepress_api_url_UrlBuilder', $pc->calculateCurrentVideoProvider());
        
        return $builder->buildGalleryUrl($currentPage);
    }

    /**
     * Builds a request url for a single video
     *
     * @param string $id The video ID to search for
     */
    public function buildSingleVideoUrl($id)
    {   
        $ioc     = org_tubepress_impl_ioc_IocContainer::getInstance();
        $pc      = $ioc->get('org_tubepress_api_provider_ProviderCalculator');
        $builder = $ioc->get('org_tubepress_api_url_UrlBuilder', $pc->calculateProviderOfVideoId($id));
        
        return $builder->buildSingleVideoUrl($id);
    }
}
