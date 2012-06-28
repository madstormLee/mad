document.observe('dom:loaded', function() {
	new SitemapTree;
});
var SitemapTree = Class.create({
	initialize: function() {
		this.data = $F('content').evalJSON();
		$('sitemapTree').observe('click', this.onClick.bind(this));
		this.writeForm = new SitemapWrite( this );

		this.writeTemplate = new Template("<a href='#{href}' class='label'>#{name}( #{label} ) :</a> <span class='action'>#{controller}::#{action}</span> <span class='menu'> <ul class='buttons'> <li><a class='view' href='view?href=#{href}'>보기</a><li> <li><a class='write' href='write?href=#{href}'>편집</a><li> <li><a class='writeSub' href='writeSub?href=#{href}'>추가</a><li> <li><a class='remove' href='remove?href=#{href}'>삭제</a><li> </ul> </span>");
		this.viewTemplate = new Template("<h1>사이트맵 보기</h1> <h2>#{label}</h2> <table id='content'> <tr> <td class='header'>Name</td> <td>#{name}</td> </tr> <tr> <td class='header'>Label</td> <td>#{label}</td> </tr> <tr> <td class='header'>Href</td> <td><a href='#{href}'>#{href}</a></td> </tr> <tr> <td class='header'>Controller</td> <td>#{controller}</td> </tr> <tr> <td class='header'>Action</td> <td>#{action}</td> </tr> </table>");
	},
	update: function( data ) {
		$('content').value = Object.toJSON( this.data );
	},
	onClick: function( ev ) {
		var el = ev.element();
		if ( el.tagName == 'A' && el.up('.buttons') ) {
			ev.stop();
			if ( el.hasClassName( 'view' ) ) {
				this.view( el );
			} else if ( el.hasClassName( 'remove' ) ) {
				this.remove( el );
				this.update();
			} else if ( el.hasClassName( 'write' ) ) {
				this.write( el );
			} else if ( el.hasClassName( 'writeSub' ) ) {
				this.writeSub( el );
			}
		}
	},
	initWrite: function( el ){
		$('view').hide();
		$('write').show();
		this.values = eval( this.getTarget( el ) );
		this.dt = el.up('dt');
	},
	write: function( el ) {
		this.initWrite( el );
		this.mode = 'write';
		this.writeForm.initForm( this.values );
	},
	writeSub: function( el ) {
		this.initWrite( el );
		this.mode = 'writeSub';
		this.writeForm.initSubForm( this.values );
	},
	onWrite: function ( values ) {
		for( var key in values ) {
			this.values[key] = values[key];
		}
		this.update();
		var dom = this.writeTemplate.evaluate( values );
		this.dt.update( dom );
	},
	onWriteSub: function ( values ) {
		if ( ! this.values.subDir ) {
			this.values.subDir = {};
		}
		this.values.subDir[values.name] = values;
		this.update();
		var dom = this.writeTemplate.evaluate( values );
		var dl = new Element('dl');
		var dt = new Element('dt', { 'className': values.name });
		dt.insert( dom );
		dl.insert( dt );
		if ( ! this.dt.next('dd') ) {
			this.dt.up('dl').insert( new Element('dd') );
		}
		this.dt.next('dd').insert( dl );
	},
	view: function( el ) {
		var values = eval( this.getTarget( el ) );
		$('view').update( this.viewTemplate.evaluate( values ) );
		$('view').show();
		$('write').hide();
		return;
		new Ajax.Updater( 'view', el.href );
	},
	getTarget: function( el ) {
		var target = [];
		var current = el.up('dt');
		while( 1 ) {
			target.unshift(current.className);
			if ( ! current.up('dd') ) {
				break;
			}
			current = current.up('dd').previous('dt');
		}
		return 'this.data.' + target.join('.subDir.');
	},
	remove: function( el ) {
		var target = this.getTarget( el );
		var statement = "delete " + target;
		el.up('dl').remove();
		eval( statement );
	}
});
var SitemapWrite = Class.create({
	initialize: function( tree ) {
		this.tree = tree;
		this.controllers = new Controllers;
		this.form = $('writeForm');
		this.form.observe('submit', this.onSubmit.bind(this));
		$('name').observe( 'blur', this.onNameBlur.bind(this) );
	},
	initForm: function ( values ) {
		$('name').value = values.name;
		$('label').value = values.label;
		$('href').value = values.href;
		$('controller').value = values.controller;
		$('action').value = values.action;
	},
	initSubForm: function ( values ) {
		$('name').value = '';
		$('label').value = '';
		$('href').value = '';
		$('controller').value = '';
		$('action').value = '';
	},
	onSubmit: function( ev ) {
		ev.stop();
		var values = this.form.serialize( true );

		if ( this.tree.mode == 'write' ) {
			this.tree.onWrite.bind( this.tree )( values );
		} else if ( this.tree.mode == 'writeSub' ) {
			this.tree.onWriteSub.bind( this.tree )( values );
		}
	},
	onNameBlur: function() {
		$('href').value = $('href').value + $F('name');
	}
});
