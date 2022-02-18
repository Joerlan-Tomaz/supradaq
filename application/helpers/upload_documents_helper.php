<?php

if (!defined('BASEPATH'))
    exit('Nenhum acesso de script direto permitido');

if (!function_exists('upload_documents')) 
{
    
    function adddoc($path, $fileType , $nameFILE, &$pageThis)
    {
        $pageThis->view['is_ajax'] = $pageThis->getViewVars()['is_ajax'];
        $errors = array();
        $config['upload_path'] = FCPATH . $path;
        $config['allowed_types'] = $fileType;

        $pageThis->load->library('upload');
        $pageThis->upload->initialize($config);
        
        if (!is_dir($config['upload_path']))
            mkdir($config['upload_path'], 0777, TRUE);

        if (!$this->upload->do_upload($nameFILE)) 
        {
            $errors = array('error' => $this->upload->display_errors());
            return $errors;
        }
        else 
        {
            return $this->upload->data();
        }
    }

}
