document.observe('dom:loaded', function() {
	new JsonTree;
});
var FloatMenu = Class.create({
	initialize: function( jsonTree ) {
		this.jsonTree = jsonTree;
		this.menu = $('floatMenu');
		this.menu.observe('click', this.onClick.bind(this));
	},
	setPosition: function ( position ) {
		this.menu.show();
		this.menu.setStyle({
			'top': + position + 'px'
		});
	},
	onClick: function( ev ) {
		ev.stop();
		var el = ev.element();
		if ( el.id == 'remove' ) {
			this.jsonTree.currentDt.next('dd').remove();
			this.jsonTree.currentDt.remove();
			this.menu.hide();
		}
		if ( el.id == 'addSub' ) {
			if ( ! this.jsonTree.currentDt.next('dd') || ! this.jsonTree.currentDt.next('dd').down('dl') ) {
				alert('추가할 수 없습니다.');
				return false;
			}
			var dl = this.jsonTree.currentDt.next('dd').down('dl');
			var defaultValue = dl.select('dd').length;
			var value = prompt( '키를 넣으세요.', defaultValue );
			if ( ! value ) {
				value = defaultValue;
			}
			var dt = new Element( 'dt' ).update( value );
			var dd = new Element( 'dd' ).update( '내용을 넣어 주세요.');
			dl.insert( dt );
			dl.insert( dd );
		}
	}
});
var JsonTree = Class.create({
	currentDt: null,
	initialize: function() {
		this.form = $('JsonWrite');
		this.form.observe('submit', this.onSubmit.bind(this));
		this.menu = new FloatMenu( this );
		$('jsonTree').observe('click', this.onClick.bind(this));
		$('jsonTree').observe('mouseover', this.onMouseover.bind(this));
		// $('jsonTree').observe('doubleclick', this.onDoubleClick.bind(this));
	},
	onMouseover: function( ev ) {
		var el = ev.element();
		this.currentDt = el;
		if ( el.tagName == 'DT' ) {
			this.menu.setPosition( el.positionedOffset().top );
		}
	},
	onSubmit: function( ev ) {
		ev.stop();
		var el = ev.element();
		var url = el.action;
		new Ajax.Request( url, {
			parameters : {
				file : $F('file'),
				data : $('jsonTree').innerHTML
			},
			onComplete: this.onSaved.bind(this)
		});
	},
	onSaved: function( transport ) {
		var result = transport.responseText;
		if ( result = 1 ) {
			alert('저장되었습니다.');
		} else {
			alert('저장중 문제가 발생하였습니다.');
		}
	},
	onClick: function( ev ) {
		var el = ev.element();
		if ( el.tagName == 'DT' ) {
			el.next('dd').toggle();
		}
		if ( el.tagName == 'DD' ) {
			var textForm = new Element('input', {'type':'text'});
			textForm.value = el.innerHTML;
			textForm.observe( 'change', this.onBlur.bind(this) );
			textForm.observe( 'blur', this.onBlur.bind(this) );
			el.update( textForm );
			textForm.select();
		}
	},
	onBlur: function( ev ) {
		var el = ev.element();
		var value = el.value;
		// 아마 observe없애야 할 수도...
		var dd = el.up('dd')
		el.remove();
		dd.update( value );
	},
	onDoubleClick: function( ev ) {
		var el = ev.element();
	}
});
