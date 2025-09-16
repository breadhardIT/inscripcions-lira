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
jQuery.validator.addMethod( "nie", function ( value, element ) {
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
    var preu = 0;

    //ets soci de la lira o III vegeueria --> preu1
    //no ets soci de la lira o no III vegueria --> preu2
 
    // si no està federat --> preu + preu_fecc    
    // si hi ha autocar --> preu + preu_autocar    
    
    var preu_soci = parseInt($('input[name=p1]').val());
    var preu_nosoci = parseInt($('input[name=p2]').val());    
    var preu_fecc = parseFloat($('input[name=p_fecc]').val());
    var preu_autocar = parseInt($('input[name=p_aut]').val());    
    
    if ( ( $('#soci option:selected').val() == 'S') || ( $('#vegueria option:selected').val() == 'S') )preu = preu_soci;			
    else preu = preu_nosoci;

    if ( ( $('#ef option:selected').val() == '')  || ( $('#ef option:selected').val() == 'N') ) {
       preu += preu_fecc;
    }
    
    if ( $('#autocar option:selected').val() == 'S') {
       preu += preu_autocar;
    }
    
    
    
    // total
    $('input[name=preuinscripcio]').val(preu);								
    $("#preuinscripcio").html("&nbsp;<b>" + preu + " &euro;</b>");		
}

function activaLlicencia() {

	if ( $('#ef option:selected').val() == 'S') {		
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