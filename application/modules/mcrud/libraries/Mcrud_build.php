<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Mcrud
 */
class Mcrud_build
{

  var $mcrud = [];
  public function __construct($config = [])
	{
		$this->ci =& get_instance();
    foreach ($config as $key => $val)
		{
			$this->{$key} = $val;
		}
	}

  function validate()
  {
		$this->errors = [];

    foreach ($this->mcrud as $conts) {
      $field_name = array_keys($conts)[0];
      $form_type = $conts[$field_name]['form_type'];

      if (empty($conts[$field_name]['field_label'])) {
        $this->errors[] = 'The '.ucwords($field_name).' label value must be filled.';
      }

      if (in_array($form_type, ["select","option"])) {
        foreach ($conts[$field_name]['option'] as $idx => $field_option) {
  					$error = false;
  					if ($field_option['value'] == "" OR $field_option['label'] == ""  )
  					{
  						$error = true;
  					}
  				}
  				if ($error) {
  					$this->errors[] = 'The '.ucwords($field_name).' option label and value must be filled.';
  				}
      }

      if (in_array($form_type, ["select_relation","option_relation"])) {
				if (empty($conts[$field_name]['relation_table'])
					OR empty($conts[$field_name]['relation_value'])
					OR empty($conts[$field_name]['relation_label']) )
				{
					$this->errors[] = 'The '.ucwords($field_name).' relation table, value and label must be filled.';
				}
			}


    }

      return $this;
  }


  function optionValue($params)
  {
    $arr = [];
    foreach ($this->mcrud as $conts) {
      $field_name = array_keys($conts)[0];
      if (in_array($field_name , [$params])) {
        foreach ($conts[$field_name]['option'] as $idx => $field_option) {
              $arr[] = ["label" => $field_option['label'], "value" => $field_option['value']];
  				}
      }
    }
    return $arr;
  }

  function optionRelation($field, $params)
  {
    foreach ($this->mcrud as $conts) {
      $field_name = array_keys($conts)[0];
      if (in_array($field_name , [$field])) {
        $val = $conts[$field_name][$params];
      }
    }
    return $val;
  }


  function checkoptionRelation()
  {
    foreach ($this->mcrud as $conts) {
      $field_name = array_keys($conts)[0];
      $form_type = $conts[$field_name]['form_type'];
      if (in_array($form_type, ["select_relation","option_relation"])) {
        return true;
      }
    }
    return false;
  }

  function formType()
  {
    $fields = [];
    foreach ($this->mcrud as $conts)
		{
			$field = array_keys($conts)[0];
      $fields[$field] = $conts[$field]['form_type'];
    }

    return $fields;
  }

  function showInTableKey()
	{
		$fields = [];
		foreach ($this->mcrud as $conts)
		{
			$field = array_keys($conts)[0];
			if (isset($conts[$field]['field_name']) AND $conts[$field]['field_name']) {
          $fields[$field] = $conts[$field]['field_label'];
			}
		}
		return $fields;
	}

  function showInTable($label = false)
	{
		$fields = [];
		foreach ($this->mcrud as $conts)
		{
			$field = array_keys($conts)[0];
			if (isset($conts[$field]['show_in_table']) AND $conts[$field]['show_in_table']) {
        if ($label) {
          $fields[] = $conts[$field]['field_label'];
        }else {
          $fields[] = $field;
        }
			}
		}
		return $fields;
	}

  function showInAdd()
	{
		$fields = [];
		foreach ($this->mcrud as $conts)
		{
			$field = array_keys($conts)[0];
			if (isset($conts[$field]['show_in_add']) AND $conts[$field]['show_in_add']) {
					$fields[] = $field;
			}
		}
		return $fields;
	}

  function showInUpdate()
	{
		$fields = [];
		foreach ($this->mcrud as $conts)
		{
			$field = array_keys($conts)[0];
			if (isset($conts[$field]['show_in_update']) AND $conts[$field]['show_in_update']) {
					$fields[] = $field;
			}
		}
		return $fields;
	}

  function showInView()
	{
		$fields = [];
		foreach ($this->mcrud as $conts)
		{
			$field = array_keys($conts)[0];
			if (isset($conts[$field]['show_in_view']) AND $conts[$field]['show_in_view']) {
					$fields[] = $field;
			}
		}
		return $fields;
	}

  function showInFilter($label = false)
	{
		$fields = [];
		foreach ($this->mcrud as $conts)
		{
			$field = array_keys($conts)[0];
			if (isset($conts[$field]['show_in_filter']) AND $conts[$field]['show_in_filter']) {
        if ($label) {
          $fields[] = $conts[$field]['field_label'];
        }else {
          $fields[] = $field;
        }
			}
		}
		return $fields;
	}

  public function isError()
	{
		$errors = false;
		if (isset($this->errors) AND count($this->errors)) {
			return true;
		}
		return $errors;
	}

  public function getErrorMessage()
	{
		$errors = false;
		if (isset($this->errors) AND count($this->errors)) {
			foreach ($this->errors as $error) {
				$errors .= "\n* ".$error;
			}
		}
		return $errors;
	}

  public function showRules($params)
  {
    $arr = [];
    foreach ($this->mcrud as $conts) {
      $field_name = array_keys($conts)[0];
      if (in_array($field_name , [$params])) {
        if (isset($conts[$field_name]['rules']) AND $conts[$field_name]['rules']) {
          foreach ($conts[$field_name]['rules'] as $field_rules) {
                $arr[] = $field_rules;
    				}
        }
      }
    }
    return $arr;
  }


public function selectTable()
{
  $ci = &get_instance();
  $fields = [];
  $table = $ci->input->post('table');
  $show_table = $this->showInTable();
  foreach ($show_table as $key) {
    $fields[] = "$table.$key";
  }
  return $fields;
}

}
