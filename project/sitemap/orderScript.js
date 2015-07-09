$(function() {
	$("#index").sortable();
	$("dl.subs dd").sortable();

	$('dt').click( function( ev ) {
		var el = $(ev.target);
		el.next('dd').toggle();
		el.next('dd').contains('subs').next('dd').toggle();
		return false;
	});
	$('#reorder').submit( function( ev ) {
		ev.preventDefault();
		var form = $(ev.target);
		$('#contents').html( $('#index').html() );

		jQuery.ajax({
			url: form.attr('action'),
			data: form.serialize(),
			method: 'POST',
			success: function( result ) {
				alert( result );
			}
		});
	});
});
