<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');
/**
 * Extended Forms with Validation
 * 
 * @package CI-Beam
 * @category Library
 * @author Ardi Soebrata 
 */

/**
 * Extends Forms with Validation
 */
class MY_Form_validation extends CI_Form_validation 
{
	/**
	 * List of fields
	 * 
	 * @var array
	 */
	protected $fields = array();
	protected $is_horizontal_form = TRUE;
	protected $is_view_form = FALSE;
	protected $group_class = 'form-group m-form__group row';
	
	/**
	 * Default data as data object.
	 * 
	 * @var object
	 */
	protected $obj_data;

	/**
	 * Initialize form fields
	 * 
	 * Field list:
	 * 		array(
	 * 			'<field_name>' => array(
	 * 				'helper' => '<field_helper>',
	 * 				'label'	=> '<field_label>',		// optional: for hidden fields.
	 * 				'rules' => '<field_rules>',		// optional: for hidden fields.
	 * 				'value' => '<field_value>',		// optional: force field value.
	 * 				'extra' => array(<field_extra>) // optional: field extras.
	 * 			),
	 * 			...
	 * 		);
	 * 
	 * @param array $fields
	 * @return \MY_Form_validation 
	 */
	public function init($fields) 
	{
		$this->fields = $fields;
		foreach ($this->fields as $name => $field) {
			if (isset($field['label']) && isset($field['rules'])) {
				if (isset($field['is_array']) && $field['is_array'])
					$name .= '[]';
				$this->set_rules($name, $field['label'], $field['rules']);
			}
		}

		return $this;
	}
	public function set_view_form($is_view)
	{
		$this->is_view_form = $is_view;
		return $this;
	}
	
	public function set_horizontal($is_horizontal)
	{
		$this->is_horizontal_form = $is_horizontal;
		return $this;
	}
	
	public function set_group_class($group_class)
	{
		$this->group_class = $group_class;
		return $this;
	}

	/**
	 * Set default values from data object.
	 * 
	 * @param object $obj
	 * @return \MY_Form_validation 
	 */
	public function set_default($obj) {
		$this->obj_data = $obj;
		return $this;
	}

	/**
	 * Get default object.
	 * 
	 * @return object
	 */
	public function get_default() {
		return $this->obj_data;
	}

	/**
	 * Display form field.
	 * 
	 * @param string $field_name
	 * @param string $value
	 * @return string 
	 */
	public function field ($field_name, $value = '') 
	{
		// Set field value
		if (isset($this->fields[$field_name]['value']))
			$value = $this->fields[$field_name]['value'];
		if (!empty($this->obj_data) && !empty($this->obj_data->$field_name))
			$value = $this->obj_data->$field_name;

		// Is field required?
		$is_required = (isset($this->fields[$field_name]['rules'])) ? (strpos($this->fields[$field_name]['rules'], 'required') !== FALSE) : FALSE;
		// Get extra field attributes.
		$extra = (isset($this->fields[$field_name]['extra'])) ? $this->fields[$field_name]['extra'] : array();
		$append = (isset($this->fields[$field_name]['append'])) ? $this->fields[$field_name]['append'] : FALSE;
		$file_path = (isset($this->fields[$field_name]['file_path'])) ? $this->fields[$field_name]['file_path'] : FALSE;
		// Get options.
		$options = (isset($this->fields[$field_name]['options'])) ? $this->fields[$field_name]['options'] : array();
		foreach($options as $key => $option) {
			if (strpos($option, 'lang:') === 0) {
				$options[$key] = lang(substr($option, 5));
			}
		}
		if (!isset($extra['is_horizontal_form']))
			$extra['is_horizontal_form'] = $this->is_horizontal_form === TRUE;
		if (!isset($extra['group-class']))
			$extra['group-class'] = $this->group_class;
		// Get label.
		if (isset($this->fields[$field_name]['label']))
			$label = $this->_translate_fieldname($this->fields[$field_name]['label']);
		else
			$label = $field_name;
		
		if ($this->is_view_form) {
			foreach ($this->fields as $index => $field) {
				if ($field['helper'] != 'form_hidden')
					$this->fields[$index]['helper'] = 'form_uneditablelabel';
			}
			/*
			$output = '<div class="form-group' . ((form_error($field_name)) ? ' has-error' : '') . '">';
			if ($this->is_horizontal_form) {
				if (isset($extra['label-class'])) {
					$output .= form_label($label, $field_name, array('class' => $extra['label-class'].' control-label'));
					unset($extra['label-class']);
				} else
					$output .= form_label($label, $field_name, array('class' => 'col-md-3 control-label'));
				if (isset($extra['col-class'])) {
					$output .= '<div class="' . $extra['col-class'] . '"> ';
					unset($extra['col-class']);
				} else
					$output .= '<div class="col-md-8"> ';
			} else {
				$output .= form_label($label, $field_name, array('class' => 'control-label'));
				$output .= '<div class=""> ';
			}
			if($value){
				if(isset($this->fields[$field_name]['options'])){
					if(isset($this->fields[$field_name]['options'][$value]))
						$value = $this->fields[$field_name]['options'][$value];
				}
			}else{
				$value ="-";
			}
			if(isset($this->fields[$field_name]['file_path'])){
				if ($value != "" && file_exists('./'.$this->fields[$field_name]['file_path'] . $value)) {
					$output .= '<a href="' . base_url() . $this->fields[$field_name]['file_path'] . $value . '" target="_blank">';
					$output .= '<span class="fa fa-file"></span> ' . basename($value);
					$output .= '</a>';
				}
			}else{
				$output .= '<p class="value">'.$value.'</p>';
			}
			$output .= '</div>';
			//if ($this->is_horizontal_form)  $output .= '</div>';
			$output .= '</div>' . "\r\n";
			return $output;
			*/
		}
		// Execute form helpers
		switch ($this->fields[$field_name]['helper']) {
			case 'form_input':
			case 'form_password':
			case 'form_textarea':
				$extra['id'] = $field_name;
				$extra['name'] = $field_name;
				$extra['value'] = set_value($field_name, $value);
				$extra['class'] = 'form-control';
				$extra['row'] = 5;
				
				$output = '<div class="form-group' . ((form_error($field_name)) ? ' has-error' : '') . '">';
				if ($this->is_horizontal_form) {
					if (isset($extra['label-class'])) {
						$output .= form_label($label . ($is_required && !empty($label) && $label != '&nbsp;' ? ' <span class="required">*</span>' : ''), $field_name, array('class' => $extra['label-class'].' control-label'));
						unset($extra['label-class']);
					} else
						$output .= form_label($label . ($is_required && !empty($label) && $label != '&nbsp;' ? ' <span class="required">*</span>' : ''), $field_name, array('class' => 'col-md-3 control-label'));
					if (isset($extra['col-class'])) {
						$output .= '<div class="' . $extra['col-class'] . '"> ';
						unset($extra['col-class']);
					} else
						$output .= '<div class="col-md-8"> ';
				} else {
					$output .= form_label($label . ($is_required ? ' <span class="required">*</span>' : ''), $field_name, array('class' => 'control-label'));
					$output .= '<div class=""> ';
				}
				
				$output .= call_user_func($this->fields[$field_name]['helper'], $extra);
				$output .= form_error($field_name, '<label for="' . $field_name . '" class="error">', '</span>');
				$output .= '</div>';
				if ($this->is_horizontal_form)  $output .= '</div>';
				$output .= '</div>' . "\r\n";

				return $output;
			case 'form_textarealabel':
				return call_user_func($this->fields[$field_name]['helper'], $field_name, $label, $is_required, $value, $extra);
			case 'form_hidden':
				return call_user_func($this->fields[$field_name]['helper'], $field_name, $value);
			case 'form_editorlabel':
					return call_user_func($this->fields[$field_name]['helper'], $field_name, $label, $value);
			case 'form_inputlabel':
			case 'form_emaillabel':
			case 'form_datelabel':
			case 'form_mappicker': 
				return call_user_func($this->fields[$field_name]['helper'], $field_name, $label, $is_required, $value, $extra, $append);
			case 'form_monthlabel':
				return call_user_func($this->fields[$field_name]['helper'], $field_name, $label, $is_required, $value, $extra, $append);
			case 'form_uneditablelabel':
				return call_user_func($this->fields[$field_name]['helper'], $field_name, $label, $value, $options, $extra);
			case 'form_passwordlabel':
				return call_user_func($this->fields[$field_name]['helper'], $field_name, $label, $is_required, $value, $extra);
			case 'form_dropdownlabel':
			case 'form_checkboxlabel':
			case 'form_radiolabel':
				return call_user_func($this->fields[$field_name]['helper'], $field_name, $label, $is_required, $options, $value, $extra);
			case 'form_filelabel':
				return call_user_func($this->fields[$field_name]['helper'], $field_name, $label, $is_required, $value, $file_path, $extra);
			default:
				show_error('Cannot find helper "' . $this->fields[$field_name]['helper'] . '" for ' . $field_name . '.');
				return '';
		}
	}
	
	/**
	 * Display form fields. 
	 * 
	 * @param array $field_names Array of field names to display. Display all fields if empty.
	 * @return string
	 */
	public function fields($field_names = array()) 
	{
		if (empty($field_names))
			$field_names = array_keys($this->fields);

		$output = '';
		foreach ($field_names as $field_name)
			$output .= $this->field($field_name) . "\r\n";
		return $output;
	}

	/**
	 * Get updated values in data object from form values.
	 * 
	 * @param object $obj_data data object to update. Use object from default if empty.
	 * @return array 
	 */
	public function get_values() 
	{
		$values = array();
		foreach ($this->fields as $field_name => $field) {
			$value = null;
			if (isset($this->_field_data[$field_name])) {
				$value = $this->_field_data[$field_name]['postdata'];
			} else {
				if (isset($field['is_array']) && $field['is_array'] && isset($this->_field_data[$field_name . '[]']))
					$value = $this->_field_data[$field_name . '[]']['postdata'];
			}

			if (!is_null($value))
				$values[$field_name] = $value;
		}
		return array_filter($values);
	}

	/**
	 * Return number of errors.
	 * 
	 * @return int
	 */
	public function num_errors() 
	{		
		return count($this->_error_array);
	}

	public function has_error($field) 
	{
		$result = FALSE;
		if (is_array($field)) {
			foreach ($field as $item) {
				$result = $result || isset($this->_error_array[$item]);
			}
		} else {
			$result = isset($this->_error_array[$field]);
		}
		return $result;
	}

	public function set_value($field = '', $default = '') 
	{
		if (empty($default)) {
			if (!empty($this->obj_data) && isset($this->obj_data->{$field}))
				$default = $this->obj_data->{$field};
			elseif (isset($this->fields[$field]['value']))
				$default = $this->fields[$field]['value'];
		}
		return parent::set_value($field, $default);
	}

}
