$(function() {
	$(".sortable").sortable();

	$('.toggleSubs').click( function( ev ) {
		var el = $(ev.target);
		el.up('dt').next('dd').toggle();
		return false;
	});
});
