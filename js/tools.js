/************************* Script **************************/
var Script = {
	_loadedScripts: [],
	include: function(script){
		// include script only once
		if (this._loadedScripts.include(script)){
			return false;
		}

		// request file synchronous
		var code = new Ajax.Request(script, {
			asynchronous: false, method: "GET",
			evalJS: false, evalJSON: false
		}).transport.responseText;

		// eval code on global level
		if (Prototype.Browser.IE) {
			window.execScript(code);
		} else if (Prototype.Browser.WebKit) {
			$$("head").first().insert(Object.extend(
				new Element("script", {type: "text/javascript"}), {text: code}
				));
		} else {
			window.eval(code);
		}

		// remember included script
		this._loadedScripts.push(script);
	}
};

/******************** MadWindow ***********************/
var MadWindow = Class.create({
	win: null,
	options: {},
	initialize: function() {
	},
	setTitle: function( title ) {
		this.title = new Element('b', {'className':'title'}).update( title );
		return this;
	},
	getTitle: function() {
		return this.title;
	},
	getWindow: function() {
		if ( ! this.win ) {
			// create
			this.win = new Element('dl', {'className': 'madWindow'}).setStyle({'display':'none'});
			this.titleBar = new Element('dt');
			this.winButtons = new Element('ul', {'className': 'buttons'});
			this.closeButton = new Element('a', {'className':'close', 'href':'#close', 'title': 'close window'}).update('X');

			this.content = new Element('dd', {'className': 'content'});
			this.statusBar = new Element('dd', {'className': 'status'});

			// observes
			this.closeButton.observe('click', this.close.bind(this));
			this.content.observe('mouseover', this.contentOver.bind(this));
			this.content.observe('mouseout', this.contentOut.bind(this));

			// insert
			this.titleBar.insert( this.title );
			this.titleBar.insert( this.winButtons );
			this.winButtons.insert( new Element('li').insert(this.closeButton) );
			this.win.insert( this.titleBar );
			this.win.insert( this.content );
			this.win.insert( this.statusBar );
		}
		return this.win;
	},
	insertAt: function( position ) {
		position.insert( this.getWindow() );
	},
	contentOver: function( ev ) {
		if ( ev.element().title ) {
			this.statusBar.update( ev.element().title );
		}
	},
	contentOut: function( ev ) {
		this.statusBar.update('');
	},
	setContent: function( content ) {
		this.content.update( content );
	},
	show: function() {
		this.win.show();
	},
	close: function( ev ) {
		ev.stop();
		this.win.hide();
	},
	toString: function() {
		return this.getWindow();
	}
});
