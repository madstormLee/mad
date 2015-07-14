$( function() {
	$('#dirView').click( function( ev ) {
		ev.preventDefault();
		if ( ! ev.target.href ) {
			return false;
		}
		var el = $(ev.target);
		if ( el.next('.subDir').length > 0 ) {
			return el.next('.subDir').toggle();
		}
		var href = ev.target.href + '&flag=onlydir&view=list&nosave=true';
		$.ajax({
			url: href,
			success( response ) {
				el.after( $("<div class='subDir'></div>").html(response) );
				$('#fileView').load(ev.target.href);
			}
		});
	});
	$('#fileView').click( function( ev ) {
		var el = $(ev.target);
		if ( ev.target.tagName == 'IMG' ) {
			el = el.up('a');
		}
		if ( href = el.attr('href') ) {
			$('#fileView').load(href);
		}
		return false;
	});
});
