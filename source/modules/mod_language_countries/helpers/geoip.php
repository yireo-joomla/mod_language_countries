<?php
/**
 * Joomla! module - Language Countries module
 *
 * @author    Yireo (info@yireo.com)
 * @copyright Copyright 2015 Yireo.com. All rights reserved
 * @license   GNU Public License
 * @link      http://www.yireo.com
 */

// Deny direct access
defined('_JEXEC') or die;

class ModLanguageCountriesGeoipHelper
{
	protected $currentCountryCode = false;

	public function getCurrentCountryCode()
	{
		if ($this->currentCountryCode != false)
		{
			return $this->currentCountryCode;
		}

		$this->currentCountryCode = true;

		// Call upon GeoIP library
		if (function_exists('geoip_country_code_by_name'))
		{
			$ip = $this->getCurrentIp();

			if (in_array($ip, array('127.0.0.1')))
			{
				return null;
			}

			$this->currentCountryCode = geoip_country_code_by_name($ip);
		}

		return $this->currentCountryCode;
	}

	public function getCurrentIp()
	{
		$vars = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR');

		foreach ($vars as $var)
		{
			if (!isset($_SERVER[$var]))
			{
				continue;
			}

			if (filter_var($_SERVER[$var], FILTER_VALIDATE_IP))
			{
				return $_SERVER[$var];
			}
		}
	}
}