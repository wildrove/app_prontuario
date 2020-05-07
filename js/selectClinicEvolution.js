
function id( el ){
    return document.getElementById( el );
}
function mostraSelect( el ){
    id( el ).style.display = 'block';
}
function escondeSelect( el, tagName ){
    var tags = el.getElementsByTagName( tagName );
    for( var i=0; i<tags.length; i++ )
    {
        tags[i].style.display = 'none';
    }
}
window.onload = function(){
    id('consultorio').style.display = 'none';
    id('evolucao').style.display = 'none';

    id('radioResumo1').onchange = function(){
        esconde_todos( id('evoType'), 'div' );
        mostraSelect( this.value );
    }
    id('radioResumo5').onchange = function(){
        esconde_todos( id('clinicEvoType'), 'div' );
        mostraSelect( this.value );
    }
    var radios = document.getElementsByTagName('input');
    for( var i=0; i<radios.length; i++ ){
        if( radios[i].type=='radio' ){
            radios[i].onclick = function(){
                escondeSelect( id('evoType'), 'div' );
                escondeSelect( id('clinicEvoType'), 'div' );
                mostraSelect( this.value );
            }
        }else {
            radios[i].onclick = function(){
                
                
            }
        }
    }
}