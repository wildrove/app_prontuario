jQuery(function(){
    jQuery('#enviarFiltro').bind('click',checkRadio);
 })

 function checkRadio() {
    var isChecked = jQuery("input[name=tipoResumo]:checked").val();
    var booleanVlaueIsChecked = false;
    if (!isChecked) {
        booleanVlaueIsChecked = true;
        alert('Selecione um tipo de Resumo!');
     
        return false;
    }
 }
