<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Template {

    var $template_data = array();

    function set($name, $value) {
        $this->template_data[$name] = $value;
    }

    function load($template = '', $view = '', $view_data = array(), $return = FALSE) {
        $this->CI = & get_instance();
        $this->set('contents', $this->CI->load->view($view, $view_data, TRUE));
        return $this->CI->load->view($template, $this->template_data, $return);
    }

    function load_insideBlue($view = '', $view_data = array(), $return = FALSE) {
        #$this->set('nav_list', array('Home', 'Photos', 'About', 'Contact'));
        $this->load('templates/template_inside-blue', $view, $view_data, $return);
    }

    function load_mainSupra($view = '', $view_data = array(), $return = FALSE) {
        #$this->set('nav_list', array('Home', 'Photos', 'About', 'Contact'));
        $this->load('templates/template_main-supra', $view, $view_data, $return);
    }

    function load_modal($view = '', $view_data = array(), $return = FALSE) {
        #$this->set('nav_list', array('Home', 'Photos', 'About', 'Contact'));
        $this->load('templates/template_modal', $view, $view_data, $return);
    }
}

/* End of file Template.php */
/* Location: ./system/application/libraries/Template.php */