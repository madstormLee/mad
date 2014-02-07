$( function() {
	$('a.help').mouseover( function( ev ) {
		ev.preventDefault();
		var el = $(ev.target);
		if ( el.find('p.manualWindow').length > 0 ) {
			var target = el.find('p.manualWindow');
		} else {
			var target = $("<p class='manualWindow'></p>");
			el.append( target );
		}
		target.show();

		if ( target.html().length == 0 ) {
			jQuery.ajax({
				url: el.attr('href'),
				success: function( result ) {
					target.html( result );
				}
			});
		}
	}).mouseout( function() {
		$('p.manualWindow').hide();
	});
});
