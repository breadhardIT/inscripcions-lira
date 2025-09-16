/*
 * Translated default messages for the jQuery validation plugin.
 * Locale: CA (Catalan; català)
 */
(function ($) {
	$.extend($.validator.messages, {
		required: "Aquest camp &eacute;s obligatori.",
		remote: "Registre duplicat, aquest valor ja est&agrave; donat d'alta al sistema.",
		email: "Si us plau, escriu una adre&ccedil;a de correu-e v&agrave;lida",
		url: "Si us plau, escriu una URL v&agrave;lida.",
		date: "Si us plau, escriu una data v&agrave;lida.",
		dateISO: "Si us plau, escriu una data (ISO) v&agrave;lida.",
		number: "Si us plau, escriu un n&ugrave;mero enter v&agrave;lid.",
		digits: "Si us plau, escriu nom&egrave;s d&iacute;gits.",
		creditcard: "Si us plau, escriu un n&uacute;mero de tarjeta v&agrave;lid.",
		equalTo: "Si us plau, escriu el mateix valor de nou.",
		accept: "Si us plau, escriu un valor amb una extensi&oacute; acceptada.",
		maxlength: $.validator.format("Si us plau, no escriguis m&eacute;s de {0} caracters."),
		minlength: $.validator.format("Si us plau, no escriguis menys de {0} caracters."),
		rangelength: $.validator.format("Si us plau, escriu un valor entre {0} i {1} caracters."),
		range: $.validator.format("Si us plau, escriu un valor entre {0} i {1}."),
		max: $.validator.format("Si us plau, escriu un valor menor o igual a {0}."),
		min: $.validator.format("Si us plau, escriu un valor major o igual a {0}.")
	});
}(jQuery));