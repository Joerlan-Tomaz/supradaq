
function resetForm($form)
{
    $form.find('input:text, input:password, input:file, textarea').val('');
    $form.find('select option').removeAttr('selected');
    $form.find('select').prop('selectedIndex',0);
    $form.find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
}

function populateForm(frm, data) {   

    $.each(data, function(key, value){  

        var $ctrl = $('[name='+key+']', frm); 

        if($ctrl.is('select')){
            
            $("option",$ctrl).each(function(){
                if (this.value==value) { this.selected=true; }
            });
        }
        else {
            switch($ctrl.attr("type"))  
            {  
                case "text" :   case "hidden":  case "textarea":  
                    $ctrl.val(value);   
                    break;   
                case "radio" : case "checkbox":   
                    $ctrl.each(function(){
                       if($(this).attr('value') == value) {  $(this).attr("checked",value); } });   
                    break;
            } 
        } 
    });      
}; 

function populateFormSelectOption(campo, value){
    $("option",campo).removeAttr('selected');
    $("option",campo).each(function(){
        if ( $(this).val() == value ) {
            $(this).attr("selected", "selected");
            return;
        }
    });
}



function populateArrForm(frm, data) {   

    var keys = Object.keys(data);
    
    $.each(keys, function(keyArr, valueArr){  

        var arrDados = data[valueArr];
        
        $.each(arrDados, function(key, value){  

            var $ctrl = $('[name="'+valueArr+'['+key+']"'+']', frm); 
            if($ctrl.is('select')){
                
                $("option",$ctrl).each(function(){
                    if (this.value==value) { this.selected=true; }
                });
            }
            else {
                switch($ctrl.attr("type"))  
                {  
                    case "text" :   case "hidden":  case "textarea":  
                        $ctrl.val(value);   
                        break;   
                    case "radio" : case "checkbox":   
                        $ctrl.each(function(){
                        if($(this).attr('value') == value) {  $(this).attr("checked",value); } });   
                        break;
                } 
            } 
        });
    });      
}; 

function populateArrForm2(frm, data) {   

    var keys = Object.keys(data);
    
    $.each(keys, function(keyArr, valueArr){  

        var arrDados = data[valueArr];
        
        $.each(arrDados, function(key, value){  

            var $ctrl1 = $('[name="'+key+'[]"'+']', frm); 
            var $ctrl = $($ctrl1[valueArr]); 
            if($ctrl.is('select')){
                $("option",$ctrl).each(function(){
                    if (this.value==value) { this.selected=true; }
                });
            }
            else {
                switch($ctrl.attr("type"))  
                {  
                    case "text" :   case "hidden":  case "textarea":  
                        $ctrl.val(value);   
                        break;   
                    case "radio" : case "checkbox":   
                        $ctrl.each(function(){
                        if($(this).attr('value') == value) {  $(this).attr("checked",value); } });   
                        break;
                } 
            } 
        });
    });      
}; 
