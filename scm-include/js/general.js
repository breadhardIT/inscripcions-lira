
function obrirFinestra (pagina, titol, w, h) {
	var opcions="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, width=" + w + ", height=" + h + ", top=85, left=140";
	window.open(pagina, titol, opcions);
} 

// -----------------------------------------------------------------
// ORDENACI� DE LLISTES
// -----------------------------------------------------------------	
function ordenar(sort) {
	document.forms[1].sort.value = sort;
	document.forms[1].submit();	
}

// -----------------------------------------------------------------
// PAGINACI� DE LLISTES
// -----------------------------------------------------------------	
function navegar(page) {
	document.forms[1].page.value = page;
	document.forms[1].submit();	
}

// -----------------------------------------------------------------
// CERCA
// -----------------------------------------------------------------	
function filtrar() {
	document.forms[1].page.value = '';
	document.forms[1].sort.value = '';	
	document.forms[1].submit();	
}

function netejarForm(oForm){

	var frm_elements = oForm.elements;
	for(i=0; i<frm_elements.length; i++) {
		frm_elements[i].value = "";
	}
}