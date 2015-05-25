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

class JFormFieldMapping extends JFormField
{
	/**
	 * @var ModLanguageCountriesCountryHelper
	 */
	protected $countryHelper = null;

	/**
	 * @var ModLanguageCountriesHelper
	 */
	protected $helper = null;

	/*
	 * Form field type
	 */
	public $type = 'Language Mapping';

	/*
	 * Method to construct the HTML of this element
	 *
	 * @param null
	 * @return string
	 */
	protected function getInput()
	{
		$value = $this->value;

		$html = array();
		$html[] = '<table class="table table-striped">';

		$languages = $this->getLanguages();

		if (!empty($languages))
		{
			foreach ($languages as $language)
			{
				$languageTag = $language->lang_code;
				$selectName = $this->name . '[' . $languageTag . '][]';
				$selectValue = (isset($value[$languageTag])) ? $value[$languageTag] : array();

				$html[] = '<tr>';
				$html[] = '<td>' . $language->title . '</td>';
				$html[] = '<td>' . $this->getCountrySelect($selectName, $selectValue) . '</td>';
				$html[] = '</tr>';
			}
		}

		$html[] = '</table>';

		return implode("\n", $html);
	}

	/**
	 * Method to load current languages
	 */
	protected function getLanguages()
	{
		$languages = $this->getHelper()->getLanguages();

		return $languages;
	}

	/**
	 * Method to generate a HTML select box for countries
	 *
	 * @param string $name
	 * @param string $value
	 *
	 * @return string
	 */
	protected function getCountrySelect($name, $value)
	{
		$countries = $this->getCountryHelper()->getCountries();

		$html = array();
		$html[] = '<select name="' . $name . '" multiple="multiple">';

		foreach ($countries as $countryCode => $countryLabel)
		{
			$selected = (in_array($countryCode, $value)) ? 'selected="selected"' : null;
			$html[] = '<option value="' . $countryCode . '" ' . $selected . '>' . $countryLabel . '</option>';
		}

		$html[] = '</select>';

		return implode("\n", $html);
	}

	/**
	 * Method to return the generic helper
	 *
	 * @return ModLanguageCountriesHelper
	 */
	protected function getHelper()
	{
		if ($this->helper == false)
		{
			require_once dirname(__DIR__) . '/helper.php';
			$this->helper = new ModLanguageCountriesHelper;
		}

		return $this->helper;
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
			require_once dirname(__DIR__) . '/helpers/country.php';
			$this->countryHelper = new ModLanguageCountriesCountryHelper;
		}

		return $this->countryHelper;
	}
}
