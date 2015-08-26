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

class Pagespeed_MinifyHTML_Model_Observer
{

    public function alterOutput($observer)
    {
	
		// retrieve html body
		$response = $observer->getResponse();       
		$html     = $response->getBody();

		
		// do not minify json
		if(substr($html, 0, 1) === '{') { return; }
		
		$helper = Mage::helper('minifyhtml/data');
		
		if ($helper->isActive())
		{	
			$timeStart = microtime(true);

			// minify
			$html=Pagespeed_MinifyHTML_Model_Minify::minify($html,array('jsCleanComments' => true));
			// timestamp
			$_timeStamp="\n".'<!-- +PS MIN_HTML '. date("d-m-Y H:i:s"). ' '. round(((microtime(true) - $timeStart) * 1000)). ' -->';
			// send Response
			$response->setBody($html.$_timeStamp);

			//Mage::log(round(((microtime(true) - $timeStart) * 1000)) . ' ms taken to minify html');			
		}
    }
	
	protected function sanitize($_html) {
	   
		return (preg_replace('#\R+#', ' ', $_html));
	}

}