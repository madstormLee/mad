var FileBrowser = function( target ) {
	this.my = this;
	this.container = target;

	this.update = function() {
		my.target.load( my.target.attr('data-href') );
	};
	this.getFiles = function( el ) {
		jQuery.ajax({
			url: el.attr('href'),
			success: function( result ) {
				if ( el.hasClass('dir') ) {
					el.after( result );
					return ;
				}
				$('#main').html( result );
			}
		});
	};
	this.updateNext = function( ev ) {
		ev.preventDefault();
		var el = $(ev.target);
		var next = el.next();
		if( next.length > 0 && next[0].tagName == 'H1' ) {
			next.next().toggle();
			return;
		}
		my.getFiles( el );
	};

	/************** assign ***************/
	my.container.click( my.updateNext );
};

$( function() {
	new FileBrowser( $('#FileBrowser') );
}
// from index
var FileBrowser = Class.create({
	initialize: function() {
		this.container = $('FileBrowser');
		this.path = $('path');
		this.dirView = this.container.down('.dirView')
		this.fileView = this.container.down('.fileView');
		this.dirView.observe('click', this.onClick.bind(this));
		this.fileView.observe('click', this.onClick.bind(this));
	},
	onClick: function( ev ) {
		ev.stop();
		var el = ev.element();
		this.el = el;
		if ( el.tagName == 'A' ) {
			alert( el.href.toQueryParams().path );
			new Ajax.Updater( this.fileView, el.href );
			new Ajax.Updater( this.dirView, el.href );
		}
	}
});



var FileBrowser = function( href ) {
	var me = this;
	this.init = function() {
		var target = $('#FileBrowser');
		target.draggable();
		me.browser = target;

		target.find( '[data-href]' ).each( function( i, unit ) {
			me.update( $(unit) );
		})

		target.find('a.btnClose').click( me.toggle );
		target.find('section.files').click( me.onFilesClick );
		target.find('section.dir').click( me.onDirClick );

		Swfuploader.create( $('#FileWrite') );
		$('form.dirWrite').submit( me.onSaveDir );
	};

	jQuery.ajax({
		url: href,
		success: function( result ) {
			var data = $( result );
			me.browser = data;

			data.find( '[data-href]' ).each( function( i, unit ) {
				me.update( $(unit) );
			})
			data.draggable();
			data.find('a.btnClose').click( me.toggle );
			data.find('section.files').click( me.onFilesClick );
			data.find('section.dir').click( me.onDirClick );

			dest.append( data );
		}
	})

	this.show = function() {
		me.browser.show();
	};
	this.hide = function() {
		me.browser.hide();
	};
	this.toggle = function() {
		me.browser.toggle();
	};
	this.update = function( el ) {
		jQuery.ajax({
			url: el.attr( 'data-href' ),
			success: function( result ) {
				el.html( result );
			}
		});
	};
	this.remove = function( ev ) {
		ev.preventDefault();
		$('#FileBrowser').remove();
	};
	this.onFilesClick = function( ev ) {
		ev.preventDefault();
		var el = $(ev.target);
		if ( el[0].tagName != 'IMG' ) {
			return false;
		}
		me.hide();
		var src = el.attr('src');
		var img = new Image();
		img.src = src;

		$('#image').val( src );
		$('#image').css({
			backgroundImage : 'url(' + src + ')',
			width: img.width,
			height: img.height
		}).next().html( src  );
	};
	this.onSaveDir = function( ev ) {
		ev.preventDefault();
		var form = $(ev.target);
		jQuery.ajax({
			url: form.attr('action'),
			type: 'post',
			data: form.serialize(),
			success: function( result ) {
				if ( result == 1 ) {
					var name = form.find('#dirName').val();
					var file = $('#baseDir').val() + '/' + name;
					var li = $('<li> <a href="?file=' + file + '">'+name+'</a> </li>');
					$('#FileBrowser ul.dir').append( li );
				} else {
					alert('error occured');
				}
			}
		});
	};
	this.onDirClick = function( ev ) {
		ev.preventDefault();
		var el = $(ev.target);
		if ( ! el.attr('href') ) {
			return false;
		}

		jQuery.ajax({
			url: el.attr('href'),
			success: function( result ) {
				$('section.dir').html( result );
				me.updateList( el.attr('href').match(/file=([a-zA-Z0-9\/]*)/)[1] );
			}
		});
	};
	this.updateList = function( target ) {
		var href = '/store/admin/file/imageList?file=' + target;
		jQuery.ajax({
			url: href,
			success: function( result ) {
				$('section.files').html( result );
			}
		});
	}

	this.init();
}


$( function() {
	Swfuploader.create( $('#FileWrite') );
	var browser = new FileBrowser();
	$('#image').click( browser.toggle );
});
