var MadJson = function( data ) {
	var my = this;
	this.init = function( data ) {
		this.setData( data );
	};
	this.setData = function( data ) {
		my.data = data;
		return my;
	};
	this.getData = function() {
		return my.data; 
	};
	this.html = function( data ) {
		if ( data ) {
			my.data = my.makeSub( data );
		}
		return my.makeHtml( this.data );
	};
	this.text = function() {
		return JSON.stringify( this.data );
	};
	this.get = function( key ) {
		return my.data[key];
	};
	this.set = function( key, value ) {
		my.data[key] = value;
		return my;
	};
	this.makeSub = function( data ) {
		data.children().each( function( i, unit ) {
			if ( unit.tagName == 'OL' ) {
				rv = my.makeOl( $(unit) );
			} else if ( unit.tagName == 'DL' ) {
				rv = my.makeDl( $(unit) );
			}
		});
		return rv;
	};
	this.makeOl = function( data ) {
		var rv = [];
		data.children().each( function( i, unit ) {
			if( $(unit).children().length > 0 ) {
				rv.push( my.makeSub($(unit)) );
			} else {
				rv.push( $(unit).html() );
			}
		});
		return rv;
	};
	this.makeDl = function( data ) {
		var rv = {};
		data.children().each( function( i, unit ) {
			if ( unit.tagName == 'DT' ) {
				key = $(unit).html();
			} else if ( unit.tagName == 'DD' ) {
				if( $(unit).children().length > 0 ) {
					rv[key] = my.makeSub( $(unit) );
				} else {
					rv[key] = $(unit).html();
				}
			}
		});
		return rv;
	};
	this.makeHtml = function( data ) {
		if ( $.type( data ) == 'array' ){
			var rv = $('<ol>');
			var item = 'li';
		} else {
			var rv = $('<dl>');
			var item = 'dd';
		}
		$.each( data, function( key, value ) {
			if ( item == 'dd' ) {
				rv.append( $('<dt>').html( key ) );
			}
			if ( $.type( value ) == 'string' ){
				var tag = $('<'+item+' class="string">').html( value );
			} else {
				var tag = $('<'+item+' class="sub">').html( my.makeHtml( value ) );
			}
			rv.append( tag );
		});
		return rv;
	};
	this.init( data );
};
/******************** controller *******************/
var controller = (function() {
	var my = this;
	my.id = $('#id');
	my.contents = $('#contents');
	my.console = $('#right');
	my.json = new MadJson( { id: "default", title: "", item: [] } );

	this.init = function() {
		var data = jQuery.parseJSON($('#contents').val());
		if ( data.hasOwnProperty( 'id' ) ) {
			my.save( data );
		}
		my.update();

		my.json.html( $('article') );
		// add events
		$('#add').click( my.addItem );
		$('article.editable').dblclick( my.edit );
	};
	this.edit = function( ev ) {
		ev.preventDefault();
		var el = $(ev.target);
		if ( el[0].tagName == 'DT' ) {
			el.next().toggle();
			return false;
		}
		if ( ! el.hasClass('string') ) {
			return false;
		}
		var value = el.html();
		var rv = window.prompt( value, value );
		if ( rv === null ) {
			return false;
		}
		if ( rv === '' && el.prev().html() == 'title' ) {
			el.up('li').remove();
		} else {
			el.html( rv );
		}
		my.json.html( $('article') );
		my.update();
		return false;
	};
	this.save = function( data ) {
		my.json.setData( data );
	};
	this.update = function() {
		my.id.val( my.json.get('id') );
		my.contents.val( my.json.text() );
		$('#Backlog article').html( my.json.html() );
	};
	this.addItem = function( ev ) {
		ev.preventDefault();
		my.json.get('item').push( {"title": $('#log').val(), "status": $('#status').val()} );
		my.update();
	};

	this.init();
})();
