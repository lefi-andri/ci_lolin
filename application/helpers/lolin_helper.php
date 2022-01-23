<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Project name
 *
 * Returns the "project_name" from your common_config file
 *
 * @access public
 * @return string
 */
if ( ! function_exists('project_name'))
{
 function project_name()
 {
  $CI =& get_instance();
  return $CI->config->item('project_name');
 }
}


/**
 * Project Title
 *
 * Returns the "project_title" from your common_config file
 *
 * @access public
 * @return string
 */
if ( ! function_exists('project_title'))
{
 function project_title()
 {
  $CI =& get_instance();
  return $CI->config->item('project_title');
 }
}


/**
 * System Version
 *
 * Returns the "system_version" from your common_config file
 *
 * @access public
 * @return string
 */
if ( ! function_exists('system_version'))
{
 function system_version()
 {
  $CI =& get_instance();
  return $CI->config->item('system_version');
 }
}


/**
 * Date Version
 *
 * Returns the "date_version" from your common_config file
 *
 * @access public
 * @return string
 */
if ( ! function_exists('date_version'))
{
 function date_version()
 {
  $CI =& get_instance();
  return $CI->config->item('date_version');
 }
}

/**
 * Programmer
 *
 * Returns the "programmer" from your common_config file
 *
 * @access public
 * @return string
 */
if ( ! function_exists('programmer'))
{
 function programmer()
 {
  $CI =& get_instance();
  return $CI->config->item('programmer');
 }
}

/**
 * University
 *
 * Returns the "company" from your common_config file
 *
 * @access public
 * @return string
 */
if ( ! function_exists('company'))
{
 function company()
 {
  $CI =& get_instance();
  return $CI->config->item('company');
 }
} 




# FUNGSI KONFIGURASI EMAIL
if (!function_exists('email_fordward')){
  function email_fordward(){
    $CI =& get_instance();
    return $CI->config->item('email_fordward');
  }
}
if (!function_exists('email_pengirim')){
  function email_pengirim(){
    $CI =& get_instance();
    return $CI->config->item('email_pengirim');
  }
}
if (!function_exists('email_username')){
  function email_username(){
    $CI =& get_instance();
    return $CI->config->item('email_username');
  }
}
if (!function_exists('email_password')){
  function email_password(){
    $CI =& get_instance();
    return $CI->config->item('email_password');
  }
}
if (!function_exists('email_host')){
  function email_host(){
    $CI =& get_instance();
    return $CI->config->item('email_host');
  }
}
if (!function_exists('email_port')){
  function email_port(){
    $CI =& get_instance();
    return $CI->config->item('email_port');
  }
}