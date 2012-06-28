document.observe('dom:loaded', function() {
	var container = new Container;
});
var Container = Class.create({
	initialize: function() {
		this.container = $('container');
		this.menu = new Menu;
		this.leftNavi = new LeftNavi;
		this.right = new Right;
		// this.main = new Main;
	}
});
var Right = Class.create({
	initialize: function() {
		$$('#right dt').each( function( unit ) {
			new Ajax.Updater( unit.next('dd'), unit.down('a').href );
		});
	}
});
var Main = Class.create({
	initialize: function() {
		this.container = $('main');
		var url = '/mad/window';
		new Ajax.Request( url, {
			parameters: {
				titleBar: 'none',
				title: this.container.down('h1').innerHTML,
				content: this.container.innerHTML
			},
			onComplete: this.observeActions.bind(this)
		});
		/*
		this.win = new MadWindow;
		this.win.addTab( title );
		this.win.setContent( this.container.innerHTML );
		this.container.update( this.win.toString() );
		*/
	},
	observeActions: function() {
	}
});
var Menu = Class.create({
	currentMenu: null,
	initialize: function() {
		$$('#mainNavi dt a').invoke('observe', 'click', this.onClick.bind(this));
		$$('#mainNavi dd a').invoke('observe', 'click', this.onCall.bind(this));
		this.tabBar = $('mainWindow').down('.tabBar');
		this.tabBar.observe('click', this.tabBarClick.bind(this));
		this.tabBar.observe('mouseover', this.tabBarMouseOver.bind(this));
		this.content = $('mainWindow').down('.content');

		this.closeTabButton = new Element('b', {'className':'btnCloseTab'}).update('X').observe('click', this.onCloseTab.bind(this));
	},
	tabBarClick: function( ev ) {
		ev.stop();
		var el = ev.element();
		if ( el.tagName == 'A' && ! el.hasClassName('current') ) {
			this.changeTab( el );
		}
	},
	changeTab: function( el ) {
		this.tabBar.select('a').invoke('removeClassName','current');
		el.addClassName('current');
		new Ajax.Updater( this.content, el.href );
	},
	tabBarMouseOver: function( ev ) {
		var el = ev.element();
		if ( el.tagName == 'A' ) {
			el.insert( this.closeTabButton );
		}
	},
	onCloseTab: function( ev ) {
		ev.stop();
		var target = ev.element().up('a');
		if ( target.hasClassName('current') ) {
			this.content.update('');
		}
		target.remove();
	},
	onClick: function( ev ) {
		ev.stop();
		var clickedMenu = null;
		var el = ev.element();
		if ( el.up('dt').next('*') && el.up('dt').next().tagName == 'DD') {
			clickedMenu = el.up('dt').next('dd') 
			clickedMenu.setStyle({
				"left" : el.up('dt').positionedOffset().left + 'px'
				});
			clickedMenu.toggle();
		} else {
			location.assign( ev.element().href );
		}
		if ( this.currentMenu != clickedMenu ) {
			if ( this.currentMenu ) {
				this.currentMenu.hide();
			}
			this.currentMenu = clickedMenu;
		}

	},
	onCall: function( ev ) {
		this.el = ev.element();
		if ( ! this.el.target ) {
			location.assign( this.el.href );
			return false;
		}
		ev.stop();
		this.currentMenu.hide();
		new Ajax.Request( this.el.href, {
			onComplete: this.display.bind(this)
		});
	},
	display: function( transport ) {
		var result = transport.responseText;
		if ( this.el.target == 'content' ) {
			this.addTab( result );
		}
	},
	addTab: function( result ) {
		this.tabBar.select('a').invoke('removeClassName', 'current');
		var a = new Element('a', { 'href': this.el.href, 'className':'current' } ).update( this.el.innerHTML );
		this.tabBar.down('ul').insert( new Element('li').insert( a ) );
		this.content.update(result);
	}
});
/*********************** LeftNavi ***********************/
var LeftNavi = Class.create({
	initialize: function() {
		this.container = $('leftNavi');
		this.controllers = new Controllers;
		this.tabBar = this.container.down('.tabBar');
		this.content = this.container.down('.content');
		this.updateContent( this.tabBar.down('.current') );

		this.tabBar.observe('click', this.onTabClick.bind(this));
		this.content.observe('click', this.onContentClick.bind(this));
		this.actionListener = this.controllers;
	},
	onContentClick: function( ev ) {
		this.actionListener.onClick.bind(this.actionListener)( ev );
	},
	onTabClick: function( ev ) {
		ev.stop();
		this.updateContent( ev.element() );
	},
	test2: function( el ) {
		alert( el.innerHTML + ' tested' );
	},
	updateContent: function( el ) {
		new Ajax.Updater( this.content, el.href );
	}
});
/********************** Controllers *********************/
var Controllers = Class.create({
	initialize: function() {
		this.mode = 'explorer';
	},
	onClick: function( ev ) {
		ev.stop();
		this.el = ev.element();
		if ( this.el.tagName != 'A' ) {
			return false;
		}
		// make current
		$('controllersContainer').select('a').invoke('removeClassName','current');
		this.el.addClassName('current');

		if ( this.el.up().tagName == 'DT' ) {
			this.getActions.bind(this)();
		} else {
			if ( this.mode == 'selectAction' ) {
				$('action').value = el.innerHTML;
			}
		}
	},
	getActions: function() {
		if ( this.mode == 'selectController' ) {
			/*
			var controller = el.innerHTML;
			$('controller').value = controller;
			$('action').value = '';
			*/
		}
		var dt = this.el.up('dt');
		if ( dt.next() && dt.next().tagName == 'DD' ) {
			dt.next().toggle();
		} else {
			new Ajax.Request( this.el.href, {
				onSuccess: this.addActions.bind( this )
			});
		}
	},
	addActions: function( transport ) {
		var result = transport.responseText;
		this.el.up('dt').insert( { 'after': result } );
	}
});
