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
 * @author		PAJ <modules@gaiterjones.com>
 * @package     PAJ_MinifyHTML
 * @copyright   Copyright (c) 2015 PAJ
 * @license     http://blog.gaiterjones.com/dropdev/magento/LICENSE.txt  The MIT License (MIT)
 */

class Pagespeed_MinifyHTML_Model_Observer
{

    public function alterOutput($observer)
    {
		$helper = Mage::helper('minifyhtml');
		
		if (!$helper->isEnabled()){ return; }
		

		
		// controller_front_send_response_before
		$response = $observer->getFront()->getResponse();   
		
		// http_response_send_before
		//$response = $observer->getResponse(); 

		// get html body		
		$html     = $response->getBody();

		
		// do not minify json
		if(substr($html, 0, 1) === '{') { return; }

		$timeStart = microtime(true);
		$_timeStamp='';
		
		// get JS time stamp
		if (preg_match("/(?<=". preg_quote("<!-- +PS JS ").").*?(?=". preg_quote(" -->").")/s", $html, $_result))
		{
			$_timeStamp.="\n".'<!-- +PS JS '. $_result[0]. ' -->';
		}
		// get CSS time stamp
		if (preg_match("/(?<=". preg_quote("<!-- +PS CSS ").").*?(?=". preg_quote(" -->").")/s", $html, $_result))
		{
			$_timeStamp.="\n".'<!-- +PS CSS '. $_result[0]. ' -->';
		}		
		
		// get FPC time stamp
		//if (preg_match("/(?<=". preg_quote("<!-- +FPC ").").*?(?=". preg_quote(" -->").")/s", $html, $_result))
		//{
		//	$_timeStamp.="\n".'<!-- +FPC '. $_result[0]. ' -->';
		//}		

		// minify
		$html=Pagespeed_MinifyHTML_Model_Minify::minify($html,array('jsCleanComments' => true));
		// timestamp
		$_timeStamp.="\n".'<!-- +PS MIN_HTML '. date("d-m-Y H:i:s"). ' '. round(((microtime(true) - $timeStart) * 1000)). 'ms -->';
		// send Response
		$response->setBody($html.$_timeStamp);

		//Mage::log(round(((microtime(true) - $timeStart) * 1000)) . ' ms taken to minify html');			

    }
	
	protected function sanitize($_html) {
	   
		return (preg_replace('#\R+#', ' ', $_html));
	}

}