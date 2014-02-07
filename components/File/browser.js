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
