var Manual = Class.create({
	initialize: function() {
		$('manualIndex').observe('click', this.onClick.bind(this));
		$('newForm').observe('submit', this.onNewSubmit.bind(this));
	},
	onClick: function( ev ) {
		var el = ev.element();
		if ( el.tagName == 'A' && el.hasClassName('btnNew') ) {
			ev.stop();
			#('manualNewForm').show();
		}
	}
});
var ManualWrite = Class.create({
	initialize: function() {
		CKEDITOR.replace( 'content', {
			language: 'ko'
		});
	},
	onClick: function( ev ) {
		ev.stop();
		alert('tested');
	}
});

/******************** document load ********************/
$( function() {
	new Manual;
	new ManualWrite;

	$('#ManualWrite').submit( function( ev ) {
		$('#contents').val( $('#ManualView').html() );
	});

	$('#ManualView .explain').dblclick( function( ev ) {
		if ( ! $('#ManualView').hasClass('changed') ) {
			$('#ManualView').addClass('changed');
		}
		var el = $(ev.target);
		var textarea = $("<textarea>" + el.html() + "</textarea>");
		textarea.blur( function( ev ) {
			var el = $(ev.target);
			el.up('.explain').html( htmlEntities( el.val() ) );
			el.remove();
		});

		el.html( textarea );
	});

	$('dl.index').draggable({handle: 'b'});

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
