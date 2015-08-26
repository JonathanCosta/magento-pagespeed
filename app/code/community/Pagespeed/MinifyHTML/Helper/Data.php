<?php
/**
 * PAJ - MINIFY HTML
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the The MIT License (MIT)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://blog.gaiterjones.com/dropdev/magento/LICENSE.txt
 *
 * @category    PAJ
 * @package     PAJ_MinifyHTML
 * @copyright   Copyright (c) 2015 PAJ
 * @license     http://blog.gaiterjones.com/dropdev/magento/LICENSE.txt  The MIT License (MIT)
 */


class Pagespeed_MinifyHTML_Helper_Data extends Mage_Core_Helper_Abstract
{
	
	 /**
     * Configuration paths
     */
    const PAGESPEED_MINIFYHTML_ENABLED = 'pagespeed/minifyhtml/enable_minify';
	
	
    public function isEnabled()
    {
		return Mage::getStoreConfigFlag(self::PAGESPEED_MINIFYHTML_ENABLED);
    }

}