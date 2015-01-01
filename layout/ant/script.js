/************************** jQuery extension **************************/
$.fn.extend({
	//### Prototype "up" method
	up: function(selector)
	{
		var found = "";
		selector = $.trim(selector || "");

		$(this).parents().each(function()
		{
			if (selector.length == 0 || $(this).is(selector))
			{
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

/******************* HeaderPopup *******************/
var HeaderPopup = function() {
	var my = this;
	my.popup = $('header section.popup');
	my.last = null;

	my.onClick = function( ev ) {
		if ( my.last == ev.target ) {
			my.popup.toggle();
			return false;
		}
		my.last = ev.target;
		my.popup.load( ev.target.href );
		my.popup.show();

		return false;
	};

	$('header a.popup').click( my.onClick );
};
/******************* right *******************/
var Right = function() {
	var my = this;

	my.onClick = function( ev ) {
		var el = $(ev.target);
		if ( ev.target.tagName == 'A' ) {
			ev.preventDefault();
			if ( el.up('section').hasClass('menu') ) {
				my.toggleSection( el );
			} else {
				ev.preventDefault();
				el.up('section').load( ev.target.href );
			}
			return false;
		}
	};
	my.toggleSection = function( el ) {
		if ( el.hasClass('opened') ) {
			el.removeClass('opened');
			$('#right section.' + el.html() ).remove();
			return false;
		}
		el.addClass('opened');
		var section = $('<section class="' + el.html() + '">');
		$('#right').append( section.load( el.attr('href') ) );
	};
	$('#right').click( my.onClick );
};

/******************* initialize *******************/
$( function() {
	$(document).foundation();
	// new HeaderPopup;
	// new Right;

	$('section[data-href]').each( function( num, unit ) {
		$(unit).load( $(unit).attr('data-href') );
	});
	/*
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
	$('#left').click( function( ev ) {
		var el = $(ev.target);
		if ( ev.target.tagName == 'A' ) {
			ev.preventDefault();
			$('main').load( ev.target.href );
		}
	});
	*/
});
