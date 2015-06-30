var Controllers = function() {
	// initialize
	var my = this;
	this.sitemap = new Sitemap;

	// events assign
	$('#controllers').click( function( ev ) {
		ev.preventDefault();
		my.sitemap.add( $(ev.target) );
	});
};

var SitemapWrite = function() {
	var my = this;
	this.container = $('#SitemapWrite');

	this.container.submit( function( ev ) {
		ev.preventDefault();
		var el = $(ev.target);
		$('#content').val( $('#SitemapIndex .content').html() );
		jQuery.ajax({
			url: el.attr('action'),
			type: el.attr('method'),
			data: el.serialize(),
			success: function( result ) {
				$('#console').html( result );
			}
		});
	});
}

var Sitemap = function() {
	// initialize
	var my = this;
	this.container = $('#SitemapIndex');
	this.current = this.container.find('dt.root');
	// assign events
	this.container.click( function ( ev ) {
		ev.preventDefault();
		var el = $(ev.target);
		if ( ( el.hasClass('hasDic') || el.hasClass('hasValue') ) && el.html() != 'subs' ) {
			my.container.find('.current').removeClass('current');
			el.addClass('current');
			my.current = el;

			$('#floatMenu').css({
				top: el.position().top
			});
		}
	});
	$('#remove').click( function( ev ){
		my.remove( $(ev.target) );
	})
	$('#addSub').click( function( ev ){
		alert( 'not yet' );
	})
	this.container.dblclick( function ( ev ) {
		ev.preventDefault();
		var el = $(ev.target);
		var input = $("<input type='text' value='"+el.html()+"' />");
		input.blur( function( ev ) {
			$(ev.target).up().html( $(ev.target).val() );
		});
		input.keypress( function( ev ) {
			var code =  (ev.keyCode ? ev.keyCode : ev.which);
			if ( code == 13 ) {
				this.blur();
			}
		});
		el.html( input );
		input.select();
	});

	// methods
	this.remove = function( el ) {
		if ( my.current.hasClass('root') ) {
			alert('you cannot remove root');
			return false;
		}
		my.current.next('dd').remove();
		my.current.remove();
	};

	this.add = function ( el ) {
		if ( ! my.hasSubs() ) {
			my.createSub();
		}
		var domain = el.html().charAt(0).toLowerCase() + el.html().slice(1);
		var value = el.html();
		my.getSubs().append( $('<dt class="hasDic">' + domain + '</dt><dd class="dic"><dl><dt class="hasValue">controller</dt><dd class="value">' + value + '</dd></dl></dd>') );
	};
	this.hasSubs = function() {
		var rv = false;
		my.current.next('dd').find('.hasDic').each( function( num, unit ) {
			if ( unit.innerHTML == 'subs' ) {
				rv = true;
				return false;
			}
		});
		return rv;
	};
	this.getSubs = function() {
		var rv = undefined;
		my.current.next('dd').find('.hasDic').each( function( num, unit ) {
			if ( unit.innerHTML == 'subs' ) {
				rv = $(unit).next('dd').children('dl');
				return false;
			}
		});
		return rv;
	};
	this.createSub = function() {
		if ( my.current.next('dd').children('dl').length == 0 ) {
			my.current.next('dd').append( $('<dl></dl>') );
		}
		var target = my.current.next('dd').children('dl');
		target.append( $('<dt class="hasDic">subs</dt><dd class="dic"><dl></dl></dd>') );
	};
}

// initialize 
$( function() {
	var controllers = new Controllers;
	var sitemapWrite = new SitemapWrite;
});

// from new sitemap;
$( function() {
	$('#AddKey').submit( function( ev ) {
		ev.preventDefault();
		var template = $('#template').val();
		var $key = $('#key').val();
		var $value = $('#value').val()
		var row = template
			.replace(/\$key/g, $key )
			.replace( /\$value/g, $value );
		$('#keys').append( row )
	});

	$('#keys').click( function(ev) {
		ev.preventDefault();
		var el = $(ev.target);
		var href = el.attr('href');
		if ( href == '#remove' ) {
			el.up('.row').remove();
		}
	});
	$('[data-load]').each( function() {
		$(this).load( $(this).attr('data-load') );
	});
});

