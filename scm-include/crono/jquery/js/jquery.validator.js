jQuery.validator.addMethod("chipgroc", function(value, element){
"use strict";    
    value=value.toUpperCase();

    if(value == '') return!0;
    if(/^[A,a,B,b,C,c][A,a,B,b,C,c,D,d,E,e,F,f,G,g,H,h]\d{5}$/.test(value))return!0;
    if(/^[d-zD-Z][a-zA-Z][0-9][0-9a-zA-Z][0-9a-zA-Z][0-9a-zA-Z][Z,9,7,B,N,4,X,S,V,E,5,6,A,W,Y,M,1,T,P,K,8,H,2,G,D,C,F,3,R]$/.test(value)){
        var n=["Z","9","7","B","N","4","X","S","V","E","5","6","A","W","Y","M","1","T","P","K","8","H","2","G","D","C","F","3","R"];
        var o=value[0].charCodeAt(0)-55+(value[1].charCodeAt(0)-55)+parseInt(value[2]);                       
        o+=value[3].charCodeAt(0)<58?value[3].charCodeAt(0)-48:value[3].charCodeAt(0)-55;
        o+=value[4].charCodeAt(0)<58?value[4].charCodeAt(0)-48:value[4].charCodeAt(0)-55;
        o+=value[5].charCodeAt(0)<58?value[5].charCodeAt(0)-48:value[5].charCodeAt(0)-55;
        var rem=o%29;
        //console.debug(rem);
    
        return value[6]==n[rem]?!0:!1;
    }
    return!1;

}, "Codi de xip incorrecte." );        

// M�tode de validaci� del NIF i el NIE
jQuery.validator.addMethod( "nifES", function ( value, element ) {
 "use strict";
 
 value = value.toUpperCase();
 
 // Basic format test NIF
 if ( !value.match('((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)') ) {
  return false;
 }
 
 // Test NIF
 if ( /^[0-9]{8}[A-Z]{1}$/.test( value ) ) {
  return ( "TRWAGMYFPDXBNJZSQVHLCKE".charAt( value.substring( 8, 0 ) % 23 ) === value.charAt( 8 ) );
 }
 // Test specials NIF (starts with K, L or M)
 if ( /^[KLM]{1}/.test( value ) ) {
  return ( value[ 8 ] === String.fromCharCode( 64 ) );
 }
 
 // Basic format test NIE
 if ( !value.match('((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)') ) {
  return false;
 }
 
 // Test NIE
 //T
 if ( /^[T]{1}/.test( value ) ) {
  return ( value[ 8 ] === /^[T]{1}[A-Z0-9]{8}$/.test( value ) );
 } 

 //XYZ
 if ( /^[XYZ]{1}/.test( value ) ) {
  return (
   value[ 8 ] === "TRWAGMYFPDXBNJZSQVHLCKE".charAt(
    value.replace( 'X', '0' )
     .replace( 'Y', '1' )
     .replace( 'Z', '2' )
     .substring( 0, 8 ) % 23
   )
  );
 }

 return false;
 
 
}, "Format del NIF / NIE incorrecte." );
 
// M�tode de validaci� nom�s del NIF 
jQuery.validator.addMethod( "nif", function ( value, element ) {
 "use strict";
 
 value = value.toUpperCase();
 
 // Basic format test NIF
 if ( !value.match('((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)') ) {
  return false;
 }
 
 // Test NIF
 if ( /^[0-9]{8}[A-Z]{1}$/.test( value ) ) {
  return ( "TRWAGMYFPDXBNJZSQVHLCKE".charAt( value.substring( 8, 0 ) % 23 ) === value.charAt( 8 ) );
 }
 // Test specials NIF (starts with K, L or M)
 if ( /^[KLM]{1}/.test( value ) ) {
  return ( value[ 8 ] === String.fromCharCode( 64 ) );
 }

 return false;
 
}, "Format del NIF incorrecte." ); 
 
// M�tode de validaci� nom�s del NIE 
jQuery.validator.addMethod( "nie", function ( value, element ) {
 "use strict";
 
 value = value.toUpperCase();
 
 // Basic format test NIE
 if ( !value.match('((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)') ) {
  return false;
 }
 
 // Test NIE
 //T
 if ( /^[T]{1}/.test( value ) ) {
  return ( value[ 8 ] === /^[T]{1}[A-Z0-9]{8}$/.test( value ) );
 } 

 //XYZ
 if ( /^[XYZ]{1}/.test( value ) ) {
  return (
   value[ 8 ] === "TRWAGMYFPDXBNJZSQVHLCKE".charAt(
    value.replace( 'X', '0' )
     .replace( 'Y', '1' )
     .replace( 'Z', '2' )
     .substring( 0, 8 ) % 23
   )
  );
 } 
 return false;
 
}, "Format del NIE incorrecte." );
 
 
function calculaPreu() {

    //inscripcio normal --> preubasic 
    // si NO federat --> preubasic + preuasseguransa
    // si NO xip informat --> preubasic + preuxip
    
    var preu_basic = parseInt($('input[name=preubasic]').val());
    var preu_asseguransa = parseInt($('input[name=preuasseguransa]').val());
    var preu_xip = parseInt($('input[name=preuxip]').val());    
    var preu = preu_basic;
    
    if (( $('#federat option:selected').val() == '')  || ( $('#federat option:selected').val() == 'N')) preu  += preu_asseguransa;
    if ( $('input[name=xip]').val() == '') preu += preu_xip;
    
    // total
    $('input[name=preuinscripcio]').val(preu);								
    $("#preuinscripcio").html("&nbsp;<b>" + preu + " &euro;</b>");		
}

function activaLlicencia() {

	if ( $('#federat option:selected').val() == 'S') {		
		$("#llicencia").prop('disabled', false);
		$("#tipusllicencia").prop('disabled', false);
		$("#federacio").prop('disabled', false);	

		// assignar estils
		$("#llicencia").rules( "add", {
			required: true,
			minlength: 1,
			digits: true
		});	
		$("#tipusllicencia").rules( "add", {
			required: true,
			minlength: 1
		});
		$("#federacio").rules( "add", {
			required: true
		});		
	}
	else {
		$("#llicencia").prop('disabled', true);
		$("#tipusllicencia").prop('disabled', true);
		$("#federacio").prop('disabled', true);		

		//estils
		$("#llicencia" ).rules( "remove" );
		$("#tipusllicencia" ).rules( "remove" );
		$("#federacio" ).rules( "remove" );		
	}
} 

function preompleEntitat() {
	if ( $('#soci option:selected').val() == 'S') {	
		$('input[name=entitat]').val('Grup Muntanyenc Lira Vendrellenca');	
	}
	else {
		$('input[name=entitat]').val('');	
		$("#entitat").html('');						
	}
}

function activaAutoritzacio() {
    
    var data_naixement = $('input[name=naixement]').val();   
    var ara = new Date();
    
    if ( (ara.getFullYear() - data_naixement.substring(6)) >= 18 ) $('#autoritzaciopaterna').hide("linear");
    else $('#autoritzaciopaterna').show("linear");
    
}