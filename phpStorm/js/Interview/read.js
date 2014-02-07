document.observe('dom:loaded', function() {
	new Interview;
});
var Interview = Class.create({
	ckEditorOptions: {
		contentsCss : ['/mad/phpStorm/css/Interview/editor.css'],
		extraPlugins : 'autogrow',
		autoGrow_maxHeight : 800,
		removePlugins : 'resize'
	},
	initialize: function() {
		CKEDITOR.replace( 'content', this.ckEditorOptions );
		this.editor = CKEDITOR.instances.content;
		$('markers').observe('click', this.onMarkersClick.bind(this));
		// 일단은 analyze를 따로 떼어 보자.
	},
	onMarkersClick: function( ev ) {
		var value = this.editor.getSelection().getSelectedText();
		value = "<span class='" + ev.element().id + "'>" + value + "</span>";
		this.editor.fire('insertHtml',value );
	}
});
