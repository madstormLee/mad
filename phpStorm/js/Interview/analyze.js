document.observe('dom:loaded', function() {
	new InterviewAnalyze;
});

var InterviewAnalyze = Class.create({
	initialize: function() {
		this.container = $('content');
		this.right = $('right');
		this.components = this.right.down('#components');
		// this.createComponent.bind(this)();
	},
	createComponent: function() {
		this.container.select('.component').each( function( unit ) {
			var data = { 'keyword': unit.innerHTML };
			var component = new Template("<section class='component'><h1>#{keyword}</h1></section>");
			this.components.insert( component.evaluate( data ) ); 
		}.bind(this));
	}
});
