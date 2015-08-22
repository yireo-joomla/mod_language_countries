<?php
/**
 * Joomla! module - Bootstrap Accordion Menu
 *
 * @author    Yireo (info@yireo.com)
 * @copyright Copyright 2015 Yireo.com. All rights reserved
 * @license   GNU Public License
 * @link      http://www.yireo.com
 */

// Deny direct access
defined('_JEXEC') or die;

/*
 * Helper class
 */

class ModLanguageCountriesHelper
{
	/**
	 * @var JRegistry
	 */
	protected $params = null;

	/**
	 * @var ModLanguageCountriesCountryHelper
	 */
	protected $countryHelper = null;

	/**
	 * @var ModLanguageCountriesGeoipHelper
	 */
	protected $geoipHelper = null;

	/**
	 * Constructor
	 *
	 * @param null $params
	 */
	public function __construct($params = null)
	{
		$this->params = $params;
	}

	/**
	 * Method to load current languages
	 *
	 * @return array
	 */
	public function getLanguages()
	{
		$languages = JLanguageHelper::getLanguages();

		return $languages;
	}

	/**
	 * Method to load current languages including their mapping
	 *
	 * @return array
	 */
	public function getLanguagesWithMapping()
	{
		$languages = $this->getLanguages();
		$currentCountryCode = $this->getMatchedCountryCode();
		$currentLanguageTag = JFactory::getLanguage()
			->getTag();
		$foundMatchedCountry = false;

		foreach ($languages as $i => &$language)
		{
			$language->link = $this->getLanguageLink($language);

			if (empty($language->link))
			{
				unset($languages[$i]);
				continue;
			}

			$language->image = $this->getLanguageImage($language);
			$language->countries = $this->getCountriesByLanguageTag($language->lang_code);
			$language->current = ($currentLanguageTag == $language->lang_code) ? true : false;

			$language->match = false;

			foreach ($language->countries as $country)
			{
				if ($country->code == $currentCountryCode)
				{
					$language->match = true;
					$foundMatchedCountry = true;
					break;
				}
			}
		}

		if ($foundMatchedCountry == false)
		{
			foreach ($languages as $i => &$language)
			{
				foreach ($language->countries as $country)
				{
					if ($country->code == '*')
					{
						$language->match = true;
					}
				}
			}
		}

		return $languages;
	}

	/**
	 * Method to get the link of a certain language
	 */
	public function getLanguageLink($language)
	{
		if (isset($language->link))
		{
			return $language->link;
		}

		require_once JPATH_SITE . '/modules/mod_languages/helper.php';

		$languageArray = ModLanguagesHelper::getList($this->params);

		foreach ($languageArray as $languageItem)
		{
			if (isset($language->lang_code) && $languageItem->lang_code == $language->lang_code)
			{
				return $languageItem->link;
			}
			elseif (method_exists($language, 'getTag') && $languageItem->lang_code == $language->getTag())
			{
				return $languageItem->link;
			}
		}
	}

	/**
	 * Method to load the image of a specific language
	 *
	 * @param $language
	 *
	 * @return string
	 */
	public function getLanguageImage($language)
	{
		return JHtml::_('image', 'mod_languages/' . $language->image . '.gif', $language->title_native, array('title' => $language->title_native), true);
	}

	/**
	 * Method to load current mapping for a specific language-code
	 *
	 * @param string $language
	 *
	 * @return array
	 */
	public function getCountriesByLanguageTag($languageTag)
	{
		$mapping = $this->getMapping();

		if (isset($mapping[$languageTag]))
		{
			$languageMapping = $mapping[$languageTag];
			$countriesMapping = array();
			$countries = $this->getCountryHelper()
				->getCountries();

			foreach ($languageMapping as $countryCode)
			{
				if ($countryCode == '*')
				{
					$countryLabel = JText::_('MOD_LANGUAGE_COUNTRIES_COUNTRY_ALL');
				}
				else
				{
					$countryLabel = $countries[$countryCode];
				}

				$country = (object) null;
				$country->code = $countryCode;
				$country->label = $countryLabel;

				$countriesMapping[] = $country;
			}

			return $countriesMapping;
		}

		return array();
	}

	/**
	 * Method to load current mapping between countries and languages
	 *
	 * @return array
	 */
	public function getMapping()
	{
		$mapping = $this->params->get('mapping');
		$mapping = (array) $mapping;

		return $mapping;
	}

	/**
	 * Method to load the current country code based on IP
	 *
	 * @return string
	 */
	public function getMatchedCountryCode()
	{
		$fakeCountry = $this->params->get('fake_country');

		if (!empty($fakeCountry))
		{
			$matchedCountryCode = strtoupper($fakeCountry);
		}
		else
		{
			$matchedCountryCode = $this->getGeoipHelper()
				->getCurrentCountryCode();
		}

		return $matchedCountryCode;
	}

	/**
	 * Method to load the current location (country) based on IP
	 *
	 * @return string
	 */
	public function getMatchedCountry()
	{
		$matchedCountryCode = $this->getMatchedCountryCode();

		if (empty($matchedCountryCode))
		{
			return null;
		}

		$countries = $this->getCountryHelper()
			->getCountries();

		if (isset($countries[$matchedCountryCode]))
		{
			return $countries[$matchedCountryCode];
		}
	}

	/**
	 * Method to load the current language based on IP
	 *
	 * @return string
	 */
	public function getMatchedLanguage()
	{
		$matchedCountryCode = $this->getMatchedCountryCode();
		$mapping = $this->getMapping();

		foreach ($mapping as $languageCode => $countryCodes)
		{
			if (in_array($matchedCountryCode, $countryCodes))
			{
				$this->loadLanguageFile($languageCode);

				return JLanguage::getInstance($languageCode);
			}
		}

		foreach ($mapping as $languageCode => $countryCodes)
		{
			if (in_array('*', $countryCodes))
			{
				return JLanguage::getInstance($languageCode);
			}
		}
	}

	/**
	 * Method to see if the matched language is the same as the current language
	 *
	 * @return string
	 */
	public function isMatchedLanguageCurrent()
	{
		$matchedLanguage = $this->getMatchedLanguage();
		$currentLanguage = JFactory::getLanguage();

		if ($matchedLanguage instanceof JLanguage)
		{
			if ($matchedLanguage->getTag() == $currentLanguage->getTag())
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Method to load the current language based on IP
	 *
	 * @return string
	 */
	public function getMatchedLanguageName()
	{
		$matchedLanguage = $this->getMatchedLanguage();

		if ($matchedLanguage instanceof JLanguage)
		{
			return $matchedLanguage->getName();
		}
	}

	/**
	 * Method to load the current language based on IP
	 *
	 * @return string
	 */
	public function matchedLanguageLink()
	{
		/** @var JLanguage */
		$matchedLanguage = $this->getMatchedLanguage();

		return $this->getLanguageLink($matchedLanguage);
	}

	/**
	 * Method to add a stylesheet
	 *
	 * @param $css
	 *
	 * @return bool
	 * @throws Exception
	 */
	public function addStylesheet($css)
	{
		if ($this->params->get('load_css', 1) == 0)
		{
			return false;
		}

		$template = JFactory::getApplication()
			->getTemplate();
		$document = JFactory::getDocument();

		if (file_exists(JPATH_SITE . '/templates/' . $template . '/css/mod_language_countries/' . $css))
		{
			$document->addStylesheet('templates/' . $template . '/css/mod_language_countries/' . $css);
		}
		else
		{
			$document->addStylesheet('media/mod_language_countries/css/' . $css);
		}

		return true;
	}

	/**
	 * Method to add a JavaScript file
	 *
	 * @param $js
	 *
	 * @return bool
	 * @throws Exception
	 */
	public function addScript($js)
	{
		if ($this->params->get('load_js', 1) == 0)
		{
			return false;
		}

		$template = JFactory::getApplication()
			->getTemplate();
		$document = JFactory::getDocument();

		if (file_exists(JPATH_SITE . '/templates/' . $template . '/js/mod_language_countries/' . $js))
		{
			$document->addScript('templates/' . $template . '/js/mod_language_countries/' . $js);
		}
		else
		{
			$document->addScript('media/mod_language_countries/js/' . $js);
		}

		return true;
	}

	/**
	 * Method to return the country helper
	 *
	 * @return ModLanguageCountriesCountryHelper
	 */
	protected function getCountryHelper()
	{
		if ($this->countryHelper == false)
		{
			require_once __DIR__ . '/helpers/country.php';
			$this->countryHelper = new ModLanguageCountriesCountryHelper;
		}

		return $this->countryHelper;
	}

	/**
	 * Method to return the Geoip helper
	 *
	 * @return ModLanguageCountriesGeoipHelper
	 */
	protected function getGeoipHelper()
	{
		if ($this->geoipHelper == false)
		{
			require_once __DIR__ . '/helpers/geoip.php';
			$this->geoipHelper = new ModLanguageCountriesGeoipHelper;
		}

		return $this->geoipHelper;
	}

	/**
	 * Method to check whether the bypass-cookie is set
	 *
	 * @return bool
	 * @throws Exception
	 */
	public function hasCookieBypass()
	{
		$cookie = JFactory::getApplication()->input->cookie->get('languagecountries');

		if ($cookie == 1)
		{
			return true;
		}

		return false;
	}

	/**
	 * Load language files in another language
	 */
	public function loadLanguageFile($languageCode)
	{
		$lang = JFactory::getLanguage();
		$extension = 'mod_language_countries';
		$baseDir = JPATH_SITE;
		$lang->load($extension, $baseDir, $languageCode, true);
	}

	/**
	 * Convery a mixed variable into a language code
	 *
	 * @param mixed $language
	 *
	 * @return string
	 */
	public function objectToCode($language)
	{
		if (is_object($language))
		{
			if (method_exists($language, 'getTag'))
			{
				$language = $language->getTag();
			}
			else
			{
				$language = $language->lang_code;
			}
		}

		return $language;
	}

	/**
	 * Replacement of JText::sprintf()
	 *
	 * @param $string
	 * @param $languageCode
	 *
	 * @return mixed|string
	 */
	public function sprintf($string, $languageCode)
	{
		$args = func_get_args();
		array_shift($args);
		array_shift($args);

		$string = $this->_($string, $languageCode);
		array_unshift($args, $string);

		$string = call_user_func_array('sprintf', $args);

		return $string;
	}

	/**
	 * Replacement of JText::_()
	 *
	 * @param $string
	 * @param $languageCode
	 *
	 * @return string
	 */
	public function _($string, $languageCode)
	{
		$languageCode = $this->objectToCode($languageCode);

		if (empty($languageCode))
		{
			return JText::_($string);
		}

		$language = $this->loadStaticLanguage($languageCode);

		return $language->_($string);
	}

	/**
	 * Load a static list of languages
	 *
	 * @param $languageCode
	 *
	 * @return JLanguage
	 */
	public function loadStaticLanguage($languageCode)
	{
		static $languages = array();

		if (!isset($languages[$languageCode]))
		{
			$language = new JLanguage($languageCode);
			$language->load('mod_language_countries');
			$languages[$languageCode] = $language;
		}
		else
		{
			$language = $languages[$languageCode];
		}

		return $language;
	}
}

