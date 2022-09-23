<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Jenssegers\Date\Date;

/**
 * CI-Beam Form Helpers
 *
 * @package		CI-Beam
 * @category	Helpers
 * @author		Ardi Soebrata
 */
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------

/**
 * Parse the form attributes
 *
 * Helper function used by some of the form helpers
 *
 * @access	private
 * @param	array
 * @param	array
 * @return	string
 */
if (!function_exists('_parse_form_attributes_ex')) {

	function _parse_form_attributes_ex($attributes, $default) 
	{
		if (is_array($attributes)) {
			foreach ($default as $key => $val) {
				if (isset($attributes[$key])) {
					$default[$key] = $attributes[$key];
					unset($attributes[$key]);
				}
			}

			if (count($attributes) > 0) {
				$default = array_merge($default, $attributes);
			}
		}

		$att = '';

		foreach ($default as $key => $val) {
			if ($key == 'value') {
				$val = form_prep($val, $default['name']);
			}

			if (strpos($val, '"') >= 0)
				$att .= $key . '=\'' . $val . '\' ';
			else
				$att .= $key . '="' . $val . '" ';
		}

		return $att;
	}

}

if (!function_exists('_generate_form_template')) {

	function _generate_form_template($name, $label, $required = false, $value = '', &$data)
	{
		$output = '';
		$settings = array(
			'is_horizontal' => true,
			'group-class' => 'form-group m-form__group row',
			'label-class' => 'col-form-label',
			'label-col-class' => 'col-md-4', 
			'col-class' => 'col-md-8', 
			'help' => '',
			'help-class' => 'm-form__help',
		);

		foreach($settings as $key => $value) {
			if (isset($data[$key])) {
				$settings[$key] = $data[$key];
				unset($data[$key]);
			}
		}

		$output = '<div class="' . $settings['group-class'] . ((form_error($name)) ? ' has-error' : '') . '">';

		// Label
		$label_class = $settings['label-class'];
		if ($settings['is_horizontal']) {
			$label_class .= ' ' . $settings['label-col-class'];
		}
		$output .= form_label($label . ($required ? ' <span class="required text-warning">*</span>' : ''), $name, array('class' => $label_class));

		// Input
		if ($settings['is_horizontal']) {
			$output .= '<div class="' . $settings['col-class'] . '">';
		}

		$output .= '{{content}}';

		// Error
		$output .= form_error($name, '<label for="' . $name . '" class="error">', '</span>');

		// Help
		if (!empty($settings['help'])) {
			$output .= '<span class="' . $settings['help-class'] . '">' . $settings['help'] . '</span>';
		}

		if ($settings['is_horizontal']) {
			$output .= '</div>';
		}
		$output .= '</div>';

		return $output;
	}
}

if (!function_exists('_generate_input_label')) {

	/**
	 * Generate Input Field with Label
	 * 
	 * @param string $name
	 * @param string $label
	 * @param boolean $required
	 * @param string $value
	 * @param array $data
	 * @return string 
	 */
	function _generate_input_label($type, $name, $label, $required = FALSE, $value = '', $data = array(), $append = FALSE) 
	{
		$template = _generate_form_template($name, $label, $required, $value, $data);
		
		if ($value instanceof DateTime) {
			if ($value->format('H:i:s') == '00:00:00')
				$value = $value->format('Y-m-d');
			else
				$value = $value->format('Y-m-d H:i:s');
		}

		$defaults = array('type' => $type, 'name' => $name, 'id' => $name, 'value' => set_value($name, $value), 'class' => 'form-control');

		$output = '';
		if ($append) {
			$output .= '<div class="input-group">';
		}
		
		$output .= "<input " . _parse_form_attributes_ex($data, $defaults) . " />";

		if ($append) {
			$output .= '<span class="input-group-addon">' . $append . '</span>';
			$output .= '</div>';
		}

		return str_replace('{{content}}', $output, $template);
	}

}

// ------------------------------------------------------------------------

if (!function_exists('form_inputlabel')) {

	/**
	 * Text Input Field with Label
	 * 
	 * @param string $name
	 * @param string $label
	 * @param boolean $required
	 * @param string $value
	 * @param array $data
	 * @return string 
	 * @uses _generate_input_label()
	 */
	function form_inputlabel($name, $label, $required = FALSE, $value = '', $data = '', $append = FALSE) {
		return _generate_input_label('text', $name, $label, $required, $value, $data, $append);
	}

}

// ------------------------------------------------------------------------

if (!function_exists('form_emaillabel')) {

	/**
	 * Email Input Field with Label
	 * 
	 * @param string $name
	 * @param string $label
	 * @param boolean $required
	 * @param string $value
	 * @param array $data
	 * @return string
	 * @uses _generate_input_label() 
	 */
	function form_emaillabel($name, $label, $required = FALSE, $value = '', $data = '') {
		return _generate_input_label('email', $name, $label, $required, $value, $data);
	}

}

// ------------------------------------------------------------------------

if (!function_exists('form_passwordlabel')) {

	/**
	 * Password Input Field with Label
	 * 
	 * @param string $name
	 * @param string $label
	 * @param boolean $required
	 * @param string $value
	 * @param array $data
	 * @return string
	 * @uses _generate_input_label() 
	 */
	function form_passwordlabel($name, $label, $required = FALSE, $value = '', $data = '') {
		return _generate_input_label('password', $name, $label, $required, $value, $data);
	}

}

if (!function_exists('form_actions')) {

	/**
	 * Form Buttons 
	 * 
	 * @param array $buttons
	 * @return string 
	 */
	function form_actions($buttons = array()) {
		if (count($buttons) == 0)
			return '';

		$output = '<div class="form-group">' . "\r\n";
		$output .= '<div class="col-md-offset-2 col-md-10">';
		foreach ($buttons as $name => $attributes) {
			$attributes['class'] = (isset($attributes['class'])) ? $attributes['class'] . ' btn' : 'btn btn-default';
			if (!isset($attributes['name']))
				$attributes['name'] = $attributes['id'];
			$output .= form_submit($attributes) . "\r\n";
		}
		$output .= '</div></div>';
		return $output;
	}

}

if (!function_exists('form_dropdownlabel')) {

	function form_dropdownlabel($name = '', $label, $required = FALSE, $options = array(), $selected = array(), $data = '') 
	{
		$is_horizontal = (isset($data['is_horizontal_form']) ? $data['is_horizontal_form'] : TRUE);
		unset($data['is_horizontal_form']);

		$output = '<div class="form-group m-form__group row' . ((form_error($name)) ? ' has-error' : '') . '">';

		// Label
		$label_class = 'col-form-label';
		if ($is_horizontal) {
			if (isset($data['label-class'])) {
				$label_class .= ' ' . $data['label-class'];
				unset($data['label-class']);
			} else {
				$label_class .= ' col-md-4';
			}
		}
		$output .= form_label($label . ($required ? ' <span class="required text-warning">*</span>' : ''), $name, array('class' => $label_class));

		// Input
		$col_class = '';
		if ($is_horizontal) {
			if (isset($data['col-class'])) {
				$col_class .= ' ' . $data['col-class'];
				unset($data['col-class']);
			} else {
				$col_class .= ' col-md-8';
			}
			$output .= '<div class="' . $col_class . '">';
		}
		
		$extras = '';
		if (empty($data)) {
			$extras = 'class="form-control"';
		} else {
			if (isset($data['class'])) {
				$extras = 'class="form-control ' . $data['class'] . '" ';
				unset($data['class']);
			} else {
				$extras = 'class="form-control" ';
			}

			foreach ($data as $key => $value) {
				$extras .= $key . '="' . $value . '" ';
			}
		}
		$extras .= 'id="' . $name . '" ';     
		$output .= form_dropdown($name, $options, set_value($name, $selected), $extras);

		$output .= form_error($name, '<label for="' . $name . '" class="error">', '</span>');
		
		if ($is_horizontal) $output .= '</div>';       
		$output .= '</div>';

		return $output;
	}

}

if (!function_exists('form_checkboxlabel')) {

	function form_checkboxlabel($name, $label, $required = FALSE, $options = array(), $selected = array(), $data = '') 
	{
		$is_horizontal = (isset($data['is_horizontal_form']) ? $data['is_horizontal_form'] : TRUE);
		unset($data['is_horizontal_form']);

		$output = '<div class="form-group' . ((form_error($name)) ? ' has-error' : '') . '">';

		// Label
		$label_class = 'col-form-label';
		if ($is_horizontal) {
			if (isset($data['label-class'])) {
				$label_class .= ' ' . $data['label-class'];
				unset($data['label-class']);
			} else {
				$label_class .= ' col-md-4';
			}
		}
		$output .= form_label($label . ($required ? ' <span class="required text-warning">*</span>' : ''), $name, array('class' => $label_class));

		// Input
		$col_class = '';
		if ($is_horizontal) {
			if (isset($data['col-class'])) {
				$col_class .= ' ' . $data['col-class'];
				unset($data['col-class']);
			} else {
				$col_class .= ' col-md-8';
			}
			$output .= '<div class="' . $col_class . '">';
		}

		if ($is_horizontal) {
			if (isset($extra['label-class'])) {
				$output .= form_label($label . ($required ? ' <span class="required text-warning">*</span>' : ''), $name, array('class' => $data['label-class'].' control-label'));
				unset($extra['label-class']);
			} else
				$output .= form_label($label . ($required ? ' <span class="required text-warning">*</span>' : ''), $name, array('class' => 'col-md-3 control-label'));
			
			if (isset($extra['col-class'])) {
				$output .= '<div class="' . $extra['col-class'] . '"> ';
				unset($extra['col-class']);
			} else
				$output .= '<div class="col-md-8"> ';
		} else {
			$output .= form_label($label . ($required ? ' <span class="required text-warning">*</span>' : ''), $name, array('class' => 'control-label'));
			$output .= '<div class=""> ';
		}
		
		$extras = '';
		if (is_array($extra)) {
			foreach ($extra as $key => $value) {
				if (!empty($key))
					$extras.= $key . '="' . $value . '" ';
			}
		}
		
		if (!is_array($selected)) 
			$selected = array();
		
		$first = '';
		$output .= '<div class="mt-checkbox-list">';
		foreach ($options as $key => $value) {
			if ($key != "") {
				$first = $key;				
				$output .= '<label class="mt-checkbox mt-checkbox-outline">';
				$output .= '<input type="checkbox" id="' . $name . '_' . $key . '" name="' . $name . '[]" value="' . $key . '" ' . $extras . set_checkbox($name, $key, in_array($key, $selected)) . ' />';
				$output .= $value;
				$output .= '<span></span>';				
				$output .= '</label>';
				
			}
		}
		$output .= '</div>';
		$output .= form_error($name, '<label for="' . $name . '_'.$first.'" class="error">', '</span>');
		$output .= '</div>';
		$output .= '</div>' . "\r\n";

		return $output;
	}
}

if (!function_exists('form_radiolabel')) {

	function form_radiolabel($name, $label, $required = FALSE, $options = array(), $selected = array(), $extra = '') {
		$output = '<div class="form-group m-form__group row' . ((form_error($name)) ? ' has-error' : '') . '">';
		$output .= form_label($label . ($required ? ' <span class="required text-warning">*</span>' : ''), $name, array('class' => 'col-md-3 control-label'));
		$output .= '<div class="col-md-8">';

		$extras = '';
		if (is_array($extra)) {
			foreach ($extra as $key => $value) {
				if (!empty($key))
					$extras.= $key . '="' . $value . '" ';
			}
		}
		
		if (!is_array($selected)) 
			$selected = array();
		
		$first = '';
		foreach ($options as $key => $value) {
			if ($key != "") {
				$first = $key;
				$output .= '<div class="radio">';
				$output .= '<label class="i-checks">';
				$output .= '<input type="radio" id="' . $name . '_' . $key . '" name="' . $name . '[]" value="' . $key . '" ' . $extras . set_checkbox($name, $key, in_array($key, $selected)) . ' />';
				$output .= '<i></i> ';
				$output .= $value;
				$output .= '</label>';
				$output .= '</div>';
			}
		}
		
		$output .= form_error($name, '<label for="' . $name . '_'.$first.'" class="error">', '</span>');
		$output .= '</div>';
		$output .= '</div>' . "\r\n";

		return $output;
	}

}
if (!function_exists('form_uneditablelabel')) {

	function form_uneditablelabel($name, $label, $value, $options = array(), $extra = array()) 
	{
		$is_horizontal = (isset($extra['is_horizontal_form']) ? $extra['is_horizontal_form'] : TRUE);
		unset($extra['is_horizontal_form']);
		$defaults = array('name' => $name, 'id' => $name);

		// if ($value instanceof Date)
		$matches = null;
		if (preg_match("/\d{4}-\d{2}-\d{2}/", $value, $matches)) {
			$date_array = explode('-', $value);
			$date = FALSE;
			if (count($date_array) == 3)
				$date = strtotime($date_array[2] . '-' . $date_array[1] . '-' . $date_array[0]);
			if ($date === FALSE)
				$date = strtotime($value);
			if ($date)
				$value = date('d-m-Y', $date);
			if ($value != '0000-00-00') {
				$value = $value;
			} else {
				$value = "";
			}
		} elseif (!empty($options) && isset($options[$value])) {
			$value = $options[$value];
		} elseif (!empty(lang($value))) {
			$value = lang($value);
		}

		$output = '<div class="form-group m-form__group row">';

		// Label
		$label_class = 'col-form-label';
		if ($is_horizontal) {
			if (isset($extra['label-class'])) {
				$label_class .= ' ' . $extra['label-class'];
				unset($extra['label-class']);
			} else {
				$label_class .= ' col-md-4';
			}
		}
		$output .= form_label($label, $name, array('class' => $label_class));

		$col_class = '';
		if ($is_horizontal) {
			if (isset($extra['col-class'])) {
				$col_class .= ' ' . $extra['col-class'];
				unset($extra['col-class']);
			} else {
				$col_class .= ' col-md-8';
			}
			$output .= '<div class="' . $col_class . '">';
		}

		if (!isset($extra['class']))
			$extra['class'] = '';
		$extra['class'] .= ' form-control-static';

		$output .= '<p ' . _parse_form_attributes_ex($extra, $defaults) . '>' . $value . '</p>';

		$output .= '</div>';
		$output .= '</div>' . "\r\n";
		return $output;
	}

}
if (!function_exists('form_uneditable')) {

	function form_uneditable($label, $value, $class = "", $options = array()) {
		if ($value instanceof DateTime) {
			if ($value->format('H:i:s') == '00:00:00')
				$value = $value->format('d F Y');
			else
				$value = $value->format('d F Y H:i:s');
		} elseif (!empty($options) && isset($options['value'])) {
			$value = $options['value'];
			unset($options['value']);
		} elseif (!empty(lang($value))) {
			$value = lang($value);
		}

		$output = '<div class="form-group">';
		$output .= form_label($label, '', array('class' => 'col-md-2 control-label'));
		$output .= '<div class="col-md-10">';
		$output .= '<p class="form-control-static ' . $class . '" ' . _parse_form_attributes_ex($options, array()) . '>' . $value . '</p>';
		$output .= '</div>';
		$output .= '</div>' . "\r\n";
		return $output;
	}

}

if (!function_exists('form_datelonglabel')) {

	function form_datelonglabel($name, $label, $required = FALSE, $value = '', $data = '') {
		$defaults = array('name' => $name, 'id' => $name, 'value' => set_value($name, $value));

		$output = '<div class="control-group' . ((form_error($name)) ? ' error' : '') . '">';
		$output .= form_label($label, $name, array('class' => 'control-label'));
		$output .= '<div class="controls">';

		$output .= "<input " . _parse_form_attributes($data, $defaults) . " />";

		if ($required)
			$output .= '<div class="input-append">';

		if ($required)
			$output .= '<span class="add-on"><i class="icon-asterisk"></i></span></div>';

		$output .= form_error($name, '<span class="help-inline">', '</span>');
		$output .= '</div>';
		$output .= '</div>' . "\r\n";

		return $output;
	}

}

/**
 * Modal confirmation window link button.
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	string
 * @return	string
 */
if (!function_exists('form_confirmwindow')) {

	function form_confirmwindow($name, $link_title, $window_title, $window_content, $target_url, $class = 'btn-danger', $modal_class = '') {
		$cancel = lang('cancel');
		if (empty($cancel))
			$cancel = 'Cancel';
		$ok = lang('ok');
		if (empty($ok))
			$ok = 'OK';

		if (empty($modal_class))
			$modal_class = $class;

		$out = '<a href="#' . $name . '" role="button" class="btn ' . $class . '" data-toggle="modal">' . $link_title . '</a>';
		$out .= '<div class="modal fade" id="' . $name . '" tabindex="-1" role="dialog" aria-labelledby="' . $name . 'Label" aria-hidden="true">';
		$out .= '<div class="modal-dialog">';
		$out .= '<div class="modal-content">';
		$out .= '<div class="modal-header">';
		$out .= '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
		$out .= '<h3 id="' . $name . 'Label" class="modal-title">' . $window_title . '</h3>';
		$out .= '</div>';
		$out .= '<div class="modal-body">';
		$out .= $window_content;
		$out .= '</div>';
		$out .= '<div class="modal-footer text-right">';
		$out .= '<a href="' . $target_url . '" class="btn ' . $modal_class . '">OK</a>';
		$out .= '<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">' . $cancel . '</button>';
		$out .= '</div>';
		$out .= '</div>';
		$out .= '</div>';
		$out .= '</div>';

		return $out;
	}

}

if (!function_exists('form_datelabel')) {

	/**
	 * Date Input Field with Label
	 * 
	 * @param string $name
	 * @param string $label
	 * @param boolean $required
	 * @param string $value
	 * @param array $data
	 * @return string 
	 * @uses _generate_input_label()
	 */
	function form_datelabel($name, $label, $required = FALSE, $value = '', $data = '') {
		{
			if (!isset($data['class'])) $data['class'] = '';
			$data['class'] .= ' span2 datepicker';
			return _generate_input_label('date', $name, $label, $required, $value, $data);
		}

		$defaults = array('type' => 'text', 'name' => $name, 'id' => $name, 'value' => set_value($name, $value), 'class' => 'form-control');
		$is_horizontal = (isset($data['is_horizontal_form']) ? $data['is_horizontal_form'] : TRUE);
		$output = '<div class="form-group m-form__group row' . ((form_error($name)) ? ' has-error' : '') . '">';
		if ($is_horizontal) {
			if (isset($data['label-class'])) {
				$output .= form_label($label . ($required ? ' <span class="required text-warning">*</span>' : ''), $name, array('class' => $data['label-class'].' control-label'));
				unset($data['label-class']);
			} else
				$output .= form_label($label . ($required ? ' <span class="required text-warning">*</span>' : ''), $name, array('class' => 'col-md-3 control-label'));
			
			if (isset($data['col-class'])) {
				$output .= '<div class="' . $data['col-class'] . '"> ';
				unset($data['col-class']);
			} else
				$output .= '<div class="col-md-8"> ';
		} else {
			$output .= form_label($label . ($required ? ' <span class="required text-warning">*</span>' : ''), $name, array('class' => 'control-label'));
			$output .= '<div class=""> ';
		}
		

		$output .= '<div class="input-group date" data-date="' . set_value($name, $value) . '">';
		$output .= "<input " . _parse_form_attributes_ex($data, $defaults) . " />";

		$output .= '<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span></div>';

		$output .= form_error($name, '<label for="' . $name . '" class="error">', '</span>');
		$output .= '</div>';
		if ($is_horizontal)  $output .= '</div>';
		$output .= '</div>' . "\r\n";

		return $output;
	}

}

if (!function_exists('form_editorlabel')) {

	function form_editorlabel($name, $label, $value = '', $rows = 10, $data = '', $required = FALSE) {
		if (empty($data))
			$data = 'class="tinymce"';
		else
			$data = preg_replace('/(class\s?=\s?")([^"]+?)"/i', '${1}${2} tinymce"', $data);

		return form_textarealabel($name, $label, $value, $rows, $data, $required);
	}

}
if ( ! function_exists('form_textarealabel'))
{
	function form_textarealabel($name, $label, $required = FALSE, $value = '', $data = '', $rows = 3)
	{
		$rows = 3;
		$is_horizontal = (isset($data['is_horizontal_form']) ? $data['is_horizontal_form'] : TRUE);
		unset($data['is_horizontal_form']);
		$help = (isset($data['help']) ? $data['help'] : '');
		unset($data['help']);
		$group_class = (isset($data['group-class']) ? $data['group-class'] : 'form-group m-form__group row');
		unset($data['group-class']);
		
		if(isset($data['rows']))
			$rows = $data['rows'];
			
		$defaults = array('name' => $name, 'id' => $name, 'value' => set_value($name, $value), 'rows' => $rows);
		
		if(isset($data['disabled']))
			$defaults['disabled'] = $data['disabled'];
			
		$output = '<div class="' . $group_class . ((form_error($name)) ? ' has-error' : '') . '">';
		
		if ($is_horizontal) {
			if (isset($data['label-class'])) {
				$output .= form_label($label . ($required && !empty($label) && $label != '&nbsp;' ? ' <span class="required text-warning">*</span>' : ''), $name, array('class' => $data['label-class'] . ' col-form-label'));
				unset($data['label-class']);
			} else {
				$output .= form_label($label . ($required && !empty($label) && $label != '&nbsp;' ? ' <span class="required text-warning">*</span>' : ''), $name, array('class' => 'col-md-4 col-form-label'));
			}
			if (isset($data['col-class'])) {
				$output .= '<div class="' . $data['col-class'] . '"> ';
				unset($data['col-class']);
			} else {
				$output .= '<div class="col-md-8"> ';
			}
		} else {
			$output .= form_label($label . ($required ? ' <span class="required text-warning">*</span>' : ''), $name, array('class' => 'col-form-label'));
		}
		
		$output .= form_textarea($defaults,  set_value($name, $value), 'class="form-control"');
		$output .= form_error($name, '<label for="' . $name . '" class="error">', '</span>');
		if ($is_horizontal)  $output .= '</div>';
		$output .= '</div>' . "\r\n";
		
		return $output;
	}
}
/**
 * Has Error
 * 
 * Returns true if there is an error for a specific form field. This is a helper for the
 * form validation class.
 * 
 * @param string|array
 * @return boolean
 */
if (!function_exists('has_error')) {

	function has_error($field) {
		if (FALSE === ($OBJ = & _get_validation_object())) {
			return '';
		}

		if ($OBJ->has_error($field))
			return ' has-error';
		else
			return '';
	}

}

/**
 * Form Error
 *
 * Returns the error for a specific form field.  This is a helper for the
 * form validation class.
 *
 * @access	public
 * @param	string
 * @param	string
 * @param	string
 * @return	string
 */
if (!function_exists('form_error')) {

	function form_error($field = '') {
		if (FALSE === ($OBJ = & _get_validation_object())) {
			return '';
		}

		return $OBJ->error($field, '<label for="' . $field . '" class="error">', '</label>');
	}

}

if (!function_exists('form_filelabel')) {

	function form_filelabel($name, $label, $required = FALSE, $value = '', $upload_path = '', $data = '') {
		
		// $is_horizontal = (isset($data['is_horizontal_form']) ? $data['is_horizontal_form'] : TRUE);
//		unset($data['is_horizontal_form']);
//		$help = (isset($data['help']) ? $data['help'] : '');
//		unset($data['help']);
		$group_class = (isset($data['group-class']) ? $data['group-class'] : 'form-group m-form__group row');
//		unset($data['group-class']);
			
//		$defaults = array('name' => $name, 'id' => $name, 'value' => set_value($name, $value));
		
//		if(isset($data['disabled']))
//			$defaults['disabled'] = $data['disabled'];
			
		$output = '<div class="' . $group_class . ((form_error($name)) ? ' has-error' : '') . '">';
		// if ($is_horizontal) {
		// 	if (isset($data['label-class'])) {
		// 		$output .= form_label($label . ($required && !empty($label) && $label != '&nbsp;' ? ' <span class="required">*</span>' : ''), $name, array('class' => $data['label-class'] . ' col-form-label'));
		// 		unset($data['label-class']);
		// 	} else {
				$output .= form_label($label . ($required && !empty($label) && $label != '&nbsp;' ? ' <span class="required text-warning">*</span>' : ''), $name, array('class' => 'col-md-4 col-form-label'));
		// 	}
		// 	if (isset($data['col-class'])) {
		// 		$output .= '<div class="' . $data['col-class'] . '"> ';
		// 		unset($data['col-class']);
		// 	} else {
				$output .= '<div class="col-md-8"> <div class="custom-file">';
		// 	}
		// } else {
			// $output .= form_label($label . ($required ? ' <span class="required">*</span>' : ''), $name, array('class' => 'col-form-label'));
		// }
		$output .= '<input type="file"  id="' . $name . '" name="' . $name . '" class="custom-file-input"  />';

//		$output .= form_error($name, '<label for="' . $name . '" class="error">', '</span>');
		
//		if ($value != "" && file_exists('./'.$upload_path . $value)) {
//			$output .= '<br />';
//			$output .= '<a href="' . base_url() . $upload_path . $value . '" target="_blank">';
//			$output .= '<span class="fa fa-file"></span> ' . basename($value);
//			$output .= '</a>';
//		}
		$output .= '<label class="custom-file-label" for="customFile"> Choose file </label></div></div>';
		// if ($is_horizontal)  $output .= '</div>';
		$output .= '</div>' . "\r\n";

		return $output;
	}
}

if (!function_exists('form_mappicker')) {

	function form_mappicker($name, $label, $required = false, $value = '', $data = '') 
	{
		$template = _generate_form_template($name, $label, $required, $value, $data);

		$stroke = (isset($data['stroke'])) ? $data['stroke'] : '#2e40d4';
		$fill = (isset($data['fill'])) ? $data['fill'] : '#5867dd';

		$output = '
		<div id="' . $name . '-mappicker" class="mappicker" data-fill="' . $fill . '" data-stroke="' . $stroke . '" data-title="' . $label . '">
			<input type="hidden" id="' . $name . '" name="' . $name . '" value=\'' . $value . '\' class="mappicker-input" />
			<div class="mappicker-trigger">
				<div class="mappicker-pin">
					<svg height="40" width="25" viewbox="-10 -41 20 40">
						<path d="M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z" stroke="#7b7e8a" stroke-width="1" fill="#7b7e8a" />
					</svg>
				</div>
				<div class="mappicker-text">
					<p class="pin-point-note"></p>
				</div>
				<div class="mappicker-button">
					<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#map-modal" data-source="#' . $name . '-mappicker">' . lang('change_location') . '</button>
				</div>
			</div>
		</div>';
		
		return str_replace('{{content}}', $output, $template);
	}
}
