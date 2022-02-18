<?php

/**
 * Módulo de criação de formulários para CodeIgniter
 * A função desta biblioteca é criar os elementos, popula-los, e valida-los utilizando as ferramentas default do framework
 *
 * @author Herisson Silva <herisson.cleiton.r@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2006, genilhu ltda. 
 * @access public  
 * @package Libraries 
 */
Class Form_Model extends CI_Model {

    /**
     * Variável que recebe as helpers e libraries default do framework
     * @access protected 
     * @name $CI 
     */
    protected $CI;

    /**
     * Variável que receberá os elementos do formulário 
     * @access private 
     * @name $item 
     * 
     */
    public $item = array();

    /**
     * Função que inicializará a classe carregando em $CI as helpers e libraries necessárias
     * @access public 
     * @return void 
     */
    public $mensagem = null;

    /**
     * Função que inicializará a classe carregando em $CI as helpers e libraries necessárias
     * @access public 
     * @return void 
     */
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->helper('form');
        $this->CI->load->library('form_validation');
    }

    /**
     * Função para adicionar elementos ao formulário
     * @access public 
     * @author Herisson Silva <herisson.cleiton.r@gmail.com>
     * @version 0.1 
     * @copyright  GPL © 2006, genilhu ltda. 
     * @param String $element_form Tipo de item de formulário conforme os parametros do CodeIgniter: form_input, form_password, form_textarea, form_dropdown...
     * @param String $item_name Nome que o elemento assumirá na classe e no formulário HTML
     * @param Array() $element_form_paraments Atributos a serem adicionados no elemento 
     * @return void 
     */
    public function addElement($element_form, $item_name, $element_form_paraments) {
        if (!isset($element_form_paraments["name"]))
            $element_form_paraments["name"] = $item_name;
        $this->item[$item_name] = array('element_form' => $element_form, 'element_form_paraments' => $element_form_paraments);

        return;
    }

    /**
     * Função para adicionar atributo a um elemento do formulário
     * @access public 
     * @author Herisson Silva <herisson.cleiton.r@gmail.com>
     * @version 0.1 
     * @copyright  GPL © 2006, genilhu ltda. 
     * @param String $item_name Nome do elemento na classe e no formulário HTML
     * @param String $attribute Nome do Atributo: id, class, style, onClick...
     * @param String $value Valor do atributo 
     * @return void 
     */
    public function addAttribute($item_name, $attribute, $value) {
        $item[$item_name]['element_form_paraments'][$attribute] = $value;
        return;
    }

    /**
     * Função para adicionar opções a um elemento do tipo select(form_dropdown)
     * @access public
     * @author Herisson Silva <herisson.cleiton.r@gmail.com>
     * @version 0.1 
     * @copyright  GPL © 2006, genilhu ltda.  
     * @param String $item_name Nome do elemento na classe e no formulário HTML
     * @param Array() $options Valor do atributo 
     * @return bool 
     */
    public function addOptions($item_name, $options) {
        if ($this->item[$item_name]['element_form'] != 'form_dropdown') {
            throw new Exception('O elemento ' . $item_name . ' não é do tipo form_dropdown');

            return false;
        }

        foreach ($options as $key => $value) {
            $this->item[$item_name]['options'][$key] = $value;
        }
        return true;
    }

    /**
     * Função para retornar um elemento do formulário
     * @author Herisson Silva <herisson.cleiton.r@gmail.com>
     * @version 0.1 
     * @copyright  GPL © 2006, genilhu ltda. 
     * @access public 
     * @param String $item_name Nome do elemento na classe e no formulário HTML
     * @return string|html
     */
    public function getElementHtml($item_name) {
        switch ($this->item[$item_name]['element_form']) {
            case 'form_dropdown':
                return call_user_func_array($this->item[$item_name]['element_form'], array(isset($this->item[$item_name]['element_form_paraments']['name']) ? $this->item[$item_name]['element_form_paraments']['name'] : $item_name, $this->item[$item_name]['options'], isset($this->item[$item_name]['default_option']) ? $this->item[$item_name]['default_option'] : '', $this->item[$item_name]['element_form_paraments']));
                break;
            case 'form_hidden':
                if (isset($this->item[$item_name]['element_form_paraments']['value'])) {
                    $paraments = $this->item[$item_name]['element_form_paraments']['value'];
                } else {
                    $paraments = "";
                }
                return call_user_func_array($this->item[$item_name]['element_form'], array($item_name, $paraments));
                break;
            default :
                return call_user_func_array($this->item[$item_name]['element_form'], array($this->item[$item_name]['element_form_paraments']));
                break;
        }
    }

    /**
     * Função para popular todos os elementos criados
     * @author Herisson Silva <herisson.cleiton.r@gmail.com>
     * @version 0.1 
     * @copyright  GPL © 2006, genilhu ltda. 
     * @access public 
     * @param Array() $data Dados a serem populados onde a chave do array refere-se ao nome do elemento e o valor do array ao valor do elemento
     * @return void
     */
    public function populate($data) {
        $this->CI->form_validation->set_data($data);
        foreach ($data as $key => $value) {
            if (isset($this->item[$key])) {
                if ($this->item[$key]['element_form'] == 'form_dropdown') {
                    $this->item[$key]['default_option'] = $value;
                } else {
                    $this->item[$key]['element_form_paraments']['value'] = $value;
                }
            }
        }
        return;
    }

    /**
     * Função para criar as regras de validação do formulário
     * @author Herisson Silva <herisson.cleiton.r@gmail.com>
     * @version 0.1 
     * @copyright  GPL © 2006, genilhu ltda. 
     * @access public 
     * @param String $item_name Nome do elemento na classe e no formulário HTML
     * @param String $label Elemento da função set_rules do codenighter
     * @param String $rules regras de validação do codenighter
     * @param Array() $errors mensagens da validação conforme o codenighter
     * @return void
     */
    public function set_rules($item_name, $label, $rules, $errors = array()) {
        $this->item[$item_name]['validator'] = array("label" => $label, "rules" => $rules, "errors" => $errors);
        return;
    }

    /**
     * Função para validar os dados do formulário
     * @author Herisson Silva <herisson.cleiton.r@gmail.com>
     * @version 2 
     * @copyright  GPL © 2006, genilhu ltda. 
     * @access public 
     * @return Boolean|Array()
     */
    public function validate($bool = false) {
        foreach ($this->item as $key => $item) {

            if (isset($item['validator'])) {
                $this->CI->form_validation->set_rules($key, $item['validator']['label'], $item['validator']['rules'], $item['validator']['errors']);
            }
        }
        if ($this->CI->form_validation->run()) {
            return true;
        } else {
            if ($bool == false) {
                return array("status" => false, "mensagem" => "Por favor, preencha devidamente todos os campos.", "elements" => $this->getErrorsForm());
            } else {
                $this->mensagem = "Por favor, preencha devidamente todos os campos.";
                return false;
            }
        }
    }

    /**
     * Função para obter os erros do formulário após o validate
     * @author Herisson Silva <herisson.cleiton.r@gmail.com>
     * @version 0.1 
     * @copyright  GPL © 2006, genilhu ltda. 
     * @access public 
     * @return Array()
     */
    public function getErrorsForm() {
        return $this->CI->form_validation->error_array();
    }

}
