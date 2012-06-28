var gw;
document.observe('dom:loaded', function() {
	if ( $('title') ) {
		gw = new GalleryWrite();
	}
	// new UserList;
});
var GalleryWrite = Class.create({
	initialize: function() {
		$('title').observe('focus',this.selectValue.bind(this));
		$('content').observe('focus',this.selectValue.bind(this));
		$('uploader').down('.delx').observe('click',this.onDelX.bind(this));
		this.image = $('GalleryWrite').down('img');
		this.image.observe('click',this.toggle);
		$('GalleryWrite').observe('submit',this.onSubmit);
		// $('section1').observe('change',this.getSubSection.bind(this));
	},
	onSubmit: function( ev ) {
		if ( $F('image').blank() ) {
			alert('이미지를 업로드 해 주세요.');
			ev.stop();
		}
		if ( $F('firstSection') == '0' ) {
			alert('첫 번째 섹션을 지정 해 주세요.');
			ev.stop();
		}
	},
	getSubSection: function() {
		alert('tested');
	},
	selectValue: function( ev ) {
		ev.element().select();
	},
	onDelX: function( ev ) {
		ev.stop();
		this.toggle();
	},
	toggle: function() {
		$('uploader').toggle();
	},
	getUploadResult: function( url ) {
		$('image').value = url;
		this.image.src = url;
		this.toggle();
	}
});
var UserList = Class.create({
	selector: null,
	initialize: function() {
		$$('.btnChangeGroup').invoke('observe','click',this.toggleForm.bind(this));
	},
	toggleForm: function( ev ) {
		this.el = ev.element();
		ev.stop();
		this.target = ev.element();
		if ( this.selector == null ) {
			this.openSelector.bind(this)();
		} else {
			this.selector.toggle();
		}
	},
	openSelector: function() {
		var no = this.no = this.el.up('tr').down('.no').innerHTML;
		new Ajax.Request('/mad/group/selectForm?tail=parts',{
			parameters: {
				'no': no
			},
			onSuccess: this.insertSelector.bind(this)
		});
	},
	insertSelector: function( transport ) {
		var result = transport.responseText;
		$('container').insert( result );
		this.observeClick.bind(this)();
	},
	observeClick: function() {
		this.selector = $('selectForm');
		$$('#selectForm dt a').invoke('observe','click', this.onGroupToggle.bind(this));
		$$('#selectForm dt a').invoke('observe','dblclick', this.onGroupSelect.bind(this));
		$$('#selectForm .btnClose').invoke('observe','click', this.toggleForm.bind(this));
	},
	onGroupToggle: function( ev ) {
		ev.stop();
		var el = ev.element();
		var target;
		if( target = el.up('dt').next('dd') ) {
			Element.toggle.delay(0.3,target);
		}
	},
	onGroupSelect: function( ev ) {
		var el = ev.element();
		var groupNo = el.href.match(/[0-9]+/);
		new Ajax.Request('/main/User/changePart', {
			parameters: {
				'no': this.no,
				'groupNo': groupNo
			},
			onSuccess: function( transport ) {
				var result = transport.responseText;
				if ( result == '1' ) {
					this.el.innerHTML = el.innerHTML;
					this.selector.toggle();
				} else {
					alert( result );
				}
			}.bind(this)
		});
	}
});
