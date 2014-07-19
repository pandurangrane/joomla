<?php
/**
 *  @copyright  Copyright (c) 2009-2013 TechJoomla. All rights reserved.
 *  @license    GNU General Public License version 2, or later
 */
defined('_JEXEC') or die('Restricted access');

	jimport('joomla.html.html');
	jimport( 'joomla.plugin.helper' );
	jimport('joomla.html.parameter');
class plgPaymentEpaydkHelper
{ 	
	
	//gets the Epaydk URL
	function buildEpaydkUrl($secure = true)
	{
		$plugin = JPluginHelper::getPlugin('payment', 'epaydk');
		$params=json_decode($plugin->params);
		$sandbox=$params->sandbox;
		if(!empty($sandbox)) {
			// SANDBOX MODE == ON
			$url =  'sandbox.epaydk.co.za/eng/process';
		} else {
			$url =  'www.epaydk.co.za/eng/process';
		}
		if ($secure) {
			$url = 'https://' . $url;
		}
		return $url;
	}
	
	
	function Storelog($name,$logdata)
	{
		jimport('joomla.error.log');
		$options = "{DATE}\t{TIME}\t{USER}\t{DESC}";
		$path= dirname(__FILE__);
		$my = JFactory::getUser();     
	
		JLog::addLogger(
			array(
				'text_file' => $logdata['JT_CLIENT'].'_'.$name.'.log',
				'text_entry_format' => $options ,
				'text_file_path' => $path
			),
			JLog::INFO,
			$logdata['JT_CLIENT']
		);

		$logEntry = new JLogEntry('Transaction added', JLog::INFO, $logdata['JT_CLIENT']);
		$logEntry->user= $my->name.'('.$my->id.')';
		$logEntry->desc=json_encode($logdata['raw_data']);

		JLog::add($logEntry);
//		$logs = &JLog::getInstance($logdata['JT_CLIENT'].'_'.$name.'.log',$options,$path);
//    $logs->addEntry(array('user' => $my->name.'('.$my->id.')','desc'=>json_encode($logdata['raw_data'])));

	}

}
