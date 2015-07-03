$(function() {
	$(".sortable").sortable();

	$('.toggleSubs').click( function( ev ) {
		var el = $(ev.target);
		el.up('dt').next('dd').toggle();
		return false;
	});
	$('#order').submit( function( ev ) {
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
		return false;
	});
});
