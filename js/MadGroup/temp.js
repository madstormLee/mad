document.observe('dom:loaded', function() {
		new BtnMadGroup;
		});

var BtnMadGroup = Class.create({
	initialize: function() {
		$$('.btnMadGroup').invoke('observe','click',this.toggle.bind(this));
	},
	toggle: function( ev ) {
		var el = ev.element();
		ev.stop();
		if ( $('MadGroupList') ) {
			$('MadGroupList').remove();
		} else {
			new MadGroup(el);
		}
	}
});

var MadGroup = Class.create({
	relNo: 0,
	initialize: function(el) {
		var url = el.href;
		this.tail = el.href.toQueryParams().tail;
		new Ajax.Request( url, {
		onSuccess: this.initWindow.bind(this)
		});
	},
	close: function() {
		$('MadGroupList').remove();
	},
	initWindow: function( transport ) {
		var text = transport.responseText;
		document.body.insert(text);
		this.initGroupList.bind(this)();
	},
	initGroupList: function() {
		$('addRootSub').observe('click', this.onAddRoot.bind(this));
		$('groups').observe('click',this.onClick.bind(this));
		// $('groups').observe('change',this.updateGroupName.bind(this));
		this.target = $('groups');
		this.getSubGroup.bind(this)();
		$$('#MadGroupList .btnClose').invoke('observe', 'click',this.close);
		$('MadGroupList').down('.btnOk').observe('click',this.onBtnOk.bind(this));
	},
	onBtnOk: function() {
		var selected = $('groups').select('.selected');
		selected.each(function(unit) {
		// this.receiver.insert(unit);
		}.bind(this));
	},
	getSubGroup: function() {
		new Ajax.Request('/mad/MadGroup/getSubGroup?tail='+this.tail,{
			parameters: { 'relNo' : this.relNo },
			onSuccess: this.insertSubGroup.bind(this)
		});
	},
	insertSubGroup: function(transport) {
		var text = transport.responseText;
		if( ! text.blank() ) {
			this.target.insert(text);
		}
	},
	onAddRoot: function( ev ) {
		this.relNo = 0;
		this.target = $('groups');
		this.onAddGroup.bind(this)();
		ev.stop();
	},
	onAddGroup: function() {
		new Ajax.Request('/mad/MadGroup/ins?tail='+this.tail,{
			parameters: { 'relNo' : this.relNo },
			onSuccess: this.insertSubGroup.bind(this)
			});
	},
	onSubGroup: function(el) {
		this.relNo = el.up('dt').className;
		if ( el.up('dl').select('dd').length > 0 ) {
			el.up('dl').select('dd').invoke('toggle');
		} else {
			this.target = el.up('dl');
			this.getSubGroup.bind(this)();
		}
	},
	updateGroupName: function( el ) {
		 var el = el.previous('input');
		 var name = el.value;
		 this.relNo = el.up('dt').className;
		 new Ajax.Request('/mad/MadGroup/up?tail='+this.tail, {
			parameters: {
				'no' : this.relNo,
				'name': encodeURIComponent('name');
			},
			onSuccess: function(transport) {
			var text = transport.responseText;
				if ( text != '1' ) {
					alert( text );
					alert('이름 변경에 실패하였습니다.');
				}
			}
		});
	},
	onDeleteGroup: function(el) {
		this.relNo = el.up('dt').className;
		this.target = el.up('dl');
		new Ajax.Request('/mad/MadGroup/del?tail='+this.tail,{
		parameters: { 'no' : this.relNo },
		onSuccess: this.deleteGroup.bind(this)
		});
	},
	deleteGroup: function( transport ) {
		var result = transport.responseText;
		if ( result == '1' ) {
			this.target.remove();
		} else {
			alert(result);
		}
	},
	onClick: function( ev ) {
		var el = ev.element();
		var action = el.className;
		if ( action == 'btnClose' ) {
			this.toggle.bind(this);
		}
		else if ( action == 'addGroup' ) {
					 this.relNo = el.up('dt').className;
					 this.target = el.up('dl');
					 this.onAddGroup.bind(this)();
		}
		else if ( action == 'removeGroup' ) {
			this.onDeleteGroup.bind(this)(el);
		}
		else if ( action == 'selectGroup' ) {
					 // el.up('dl').toggleClassName('selected');
					 this.updateGroupName.bind(this)(el);
		}
		else if ( action == 'subGroup' ) {
					 this.onSubGroup.bind(this)(el);
		}
		else if ( action == 'toUp' ) {
					 this.toUp.bind(this)(el);
		}
		else if ( action == 'toDown' ) {
					 this.toDown.bind(this)(el);
		}
		ev.stop();
	},
	toUp: function( el ) {
		this.el = el;
		var no = el.up('dt').className;
		var relNo = '0';
		if ( el.up('dd').previous('dt') ) {
			relNo = el.up('dd').previous('dt').className;
		}
		new Ajax.Request('/mad/MadGroup/toUp?tail='+this.tail,{
			parameters: {
				'relNo': relNo,
				'no': no
			},
			onSuccess: this.toUpElement.bind(this)
		});
	},
	toUpElement: function( transport ) {
		 var text = transport.responseText;
		 if ( text =='1') {
			var target = this.el.up('dd');
			var place = this.el.up('dd').previous('dd');
			place.insert( { 'before': target } );
		 } else {
			 alert(text);
		 }
	},
	toDown: function( el ) {
		 this.el = el;
		 var no = el.up('dt').className;
		 var relNo = '0';
		 if ( el.up('dd').previous('dt') ) {
			relNo = el.up('dd').previous('dt').className;
		 }
		new Ajax.Request('/mad/MadGroup/toDown?tail='+this.tail,{
			parameters: {
				'relNo': relNo,
				'no': no
			},
			onSuccess: this.toDownElement.bind(this)
		});
	},
	toDownElement: function( transport ) {
		 var text = transport.responseText;
		if ( text =='1') {
			var target = this.el.up('dd');
			var place = this.el.up('dd').next('dd');
			place.insert( { 'after': target } );
		}
	},
	select: function( ev ) {
		var el = ev.element()
		el.toggleClassName('selected');
		if ( el.nodeName == 'DT' ) {
			if ( el.hasClassName('selected') ) {
				el.up('dl').select('dd').each( function( unit ) {
					if ( ! unit.hasClassName('selected') ) {
						unit.addClassName('selected');
					}
				});
			} else {
				el.up('dl').select('dd.selected').each( function( unit ) {
					unit.removeClassName('selected');
				});
			}
		}
	}
});
