<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Jenssegers\Date\Date;

/**
 * Beam-Template Helpers
 *
 * @package Beam-Template
 * @category Helper
 * @author Ardi Soebrata
 */
/**
 * Beam-Template Helpers
 */
if (!function_exists('messages'))
{
	/**
	 * Return formatted messages.
	 *
	 * @return string
	 */
	function messages()
	{
		if (FALSE === ($template = & _get_object('template')))
			return '';

		$template_messages = $template->get_messages();

		if (FALSE !== ($form_validation = & _get_object('form_validation')))
		{
			if ($form_validation->num_errors())
				$template_messages['error'][] = sprintf(lang('form_error'), $form_validation->num_errors());
		}

		$content = '<script>';
		$content .= '$(document).ready(function() {';
		foreach ($template_messages as $type => $messages)
		{
			$type_class = $type;
			if ($type == 'error')
				$type_class = 'danger';

			$icon = 'fa fa-info-circle';
			$delay = 10000;
			switch($type_class) {
				case 'success':
					$icon = 'fa fa-check';
					break;
				case 'warning':
					$icon = 'fa fa-exclamation-circle';
					$delay = 0;
					break;
				case 'danger':
					$icon = 'fa fa-ban';
					$delay = 0;
					break;
			}

			$title = lang($type);

			foreach ($messages as $message)
			{
				$content .= "
$.notify({
	icon: '$icon', 
	title: '<strong>$title</strong>',
	message: '$message'
},{
	type: '$type_class',
	delay: $delay
});";
			}
		}
		$content .= '});';
		$content .= '</script>';
		return $content;
	}
}

if (!function_exists('_get_object'))
{

	/**
	 * Get Object
	 *
	 * Determines what the class object was instantiated as, fetches
	 * the object and returns it.
	 *
	 * @param string $obj_name
	 * @return mixed
	 */
	function &_get_object($obj_name)
	{
		$CI =& get_instance();

		// We set this as a variable since we're returning by reference.
		$return = FALSE;

		if (FALSE !== ($object = $CI->load->is_loaded($obj_name)))
		{
			if (!isset($CI->$object) OR ! is_object($CI->$object))
			{
				return $return;
			}

			return $CI->$object;
		}

		return $return;
	}

}
