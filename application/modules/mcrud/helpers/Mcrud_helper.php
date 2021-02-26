<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function label($field)
{
  $ci = &get_instance();
  $show_in_label = $ci->mcrud_build->showInTableKey();
  return $show_in_label[$field];
}

function formType($field)
{
  $ci = &get_instance();
  $show_in_form_type = $ci->mcrud_build->formType();
  return $show_in_form_type[$field];
}

function optionValue($field)
{
  $ci = &get_instance();
  $optionValue = $ci->mcrud_build->optionValue($field);
  return $optionValue;
}

function optionRelation($field, $params)
{
  $ci = &get_instance();
  $optionRelation = $ci->mcrud_build->optionRelation($field, $params);
  return $optionRelation;
}

function showRules($field)
{
  $ci = &get_instance();
  $showRules = $ci->mcrud_build->showRules($field);
  if (count($showRules) > 0) {
    $str = "|".implode("|", $showRules);
  }else {
    $str = "";
  }
  return $str;
}
