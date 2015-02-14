/************************** jQuery extension **************************/
$.fn.extend({
	//### Prototype "up" method
	up: function(selector) {
		var found = "";
		selector = $.trim(selector || "");

		$(this).parents().each(function() {
			if (selector.length == 0 || $(this).is(selector)) {
				found = this;
				return false;
			}
		});

		return $(found);
	},
	down: function() {
		var el = this[0] && this[0].firstChild;
		while (el && el.nodeType != 1)
			el = el.nextSibling;
		return $(el);
	}
});

function htmlEntities(str) {
	 return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}


/******************* initialize *******************/
$( function() {
	$(document).foundation();

	$('section[data-href]').each( function( num, unit ) {
		$(unit).load( $(unit).attr('data-href') );
	});

	$('a[data-target]').click( function( ev ) {
		ev.preventDefault();
		var target = $(ev.target).attr('data-target');
		$(target).load( ev.target.href );
		return false;
	});

	$('a[data-confirm]').click( function( ev ) {
		if ( false === confirm( $(ev.target).attr('data-confirm') ) ) {
			ev.preventDefault();
			return false;
		}
	});
});
