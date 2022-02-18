var last_insert_id = null;
var data_full = null;
/**
 * Função para enviar o formulário via ajax e reportar os erros para o usuário
 * @access public 
 * @author Herisson Silva <herisson.cleiton.r@gmail.com>
 * @version 0.2 
 * @copyright  GPL © 2006, genilhu ltda. 
 * @param String id atributo id do formulário
 * @return void 
 */

function formSubmitAjax(id, notify = true) {
    $('.is-invalid').removeClass('is-invalid');
    ckSetAll();
    var form = $('#' + id);
    var formData = new FormData(form[0]);
    var url = form.attr('action');
    var retorno = null;
    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        contentType: false,
        processData: false, //this is requireded please see answers above
        dataType: 'json',
        async: false,
        error: function (jqXHR, textStatus, errorMessage) {
            console.log(errorMessage); // Optional
            if (notify)
                $.notify('Ocorreu um erro: ' + errorMessage, "warning");
            retorno = false;
        },
        success: function (data)
        {
            if (data.status) {
                if (notify)
                    $.notify('Cadastrado com sucesso!', "success");
                $('.has-error').removeClass('has-error');
                if (data.last_insert_id !== 'undefined') {
                    last_insert_id = data.last_insert_id; 
                    data_full = data;
                }
                retorno = true;
            } else {
                if (notify)
                    $.notify('Ocorreu um erro: ' + data.mensagem, "warning");

                if (data.hasOwnProperty('elements')) {
                    $.each(data.elements, function (key, item) {
                        $.each(item, function (ky, iten) {
                            var formGroup = $("[name='" + ky + "']");
                            console.log(form.formGroup);
                            formGroup.addClass('is-invalid');
//                                $("[name='"+key+"']").after('<span class="help-block">'+item+'.</span>');
                        });
                    });
                }

                retorno = false;
            }

        }
    });
    return retorno;
}
;
/**
 * Função para salvar todos elementos da lib CKEditor
 * @access public 
 * @author Herisson Silva <herisson.cleiton.r@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2006, genilhu ltda.
 * @return void 
 */
function ckSetAll() {
    for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }
}

/**
 * Função para zerar todos elementos da lib CKEditor
 * @access public 
 * @author Herisson Silva <herisson.cleiton.r@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2006, genilhu ltda.
 * @return void 
 */
function ckInit() {
    for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].setData("");
    }
}

/**
 * Função para obter um datePicker em yyyy-mm-dd
 * @access public 
 * @author Herisson Silva <herisson.cleiton.r@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2006, genilhu ltda.
 * @param String id atributo id do input datePicker
 * @return string 
 */
function getDatePickerYMD(id_element) {
    var dt = $(id_element).datepicker('getDate');
    if (dt.toString() == "Invalid Date") {
        $(id_element).datepicker("setDate", new Date());
        return false;
    }
    
    var day = (dt.getDate() != 'undefined' ? ((dt.getDate()) > 9 ? (dt.getDate()) : "0" + (dt.getDate())) : "01");
    var m = ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1));
    var y = dt.getFullYear();
    var dateYMD = y + "-" + m + "-" + day;
    return dateYMD;
}

function setDAtePickerMY(id_element, dataYMD) {
    if ($(id_element).val() != '') {
        //Por motivo desconhecido, ao adicionar a data no datepicker há a redução de um m~es. A solução abaixo supre essa surpresa.
        var timeZone = (new Date()).getTimezoneOffset()/60;
        console.log(timeZone);
        var data = new Date(dataYMD + 'T0'+ timeZone +':00:00.000Z');
        data.setMonth(data.getMonth());
        $(id_element).datepicker("setDate", data);
    } else {
        $(id_element).datepicker("setDate", new Date());
    }
}

function submitAjaxFormData(formData, action, notify = true) {
    var retorno = null;
    $('#spinner').show();
    $.ajax({
        type: "POST",
        url: action,
        data: formData,
        contentType: false,
        processData: false, //this is requireded please see answers above
        dataType: 'json',
        async: false,
        error: function (jqXHR, textStatus, errorMessage) {
            console.log(errorMessage); // Optional
            if (notify)
                $.notify('Ocorreu um erro: ' + errorMessage, "warning");

            retorno = false;
        },
        success: function (data)
        {
            if (data.status) {
                if (notify)
                    $.notify('Cadastrado com sucesso!', "success");

                $('.has-error').removeClass('has-error');
                if (data.last_insert_id !== 'undefined') {
                    last_insert_id = data.last_insert_id; 
                    data_full = data;
                }
                retorno = true;
            } else {
                if (notify)
                    $.notify('Ocorreu um erro: ' + data.mensagem, "warning");

                if (data.hasOwnProperty('validators')) {
                    $.each(data.validators, function (index, value) {
//
//                        console.log('My array has at position ' + index + ', this value: ' + value);
                        if (value.hasOwnProperty('elements')) {
                            $.each(value.elements, function (key, item) {
                                var formGroup = $("[name='" + key + "']").parent();
                                formGroup.addClass('has-error');
//                                $("[name='"+key+"']").after('<span class="help-block">'+item+'.</span>');
                            });
                        }
                    });
                }
                retorno = false;
            }

        }, 
        complete : function(){
            $('#spinner').hide();
        }
    });

    return retorno;
}
