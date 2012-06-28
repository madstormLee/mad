document.observe('dom:loaded', function() {
	new MadXFormManager();
	new MadXDate();
	new MadXTerm;
});
var MadXFormManager = Class.create({
	xForm : null,
	blocker : null,
	currentForm: null,
	initialize: function() {
		var forms = $$('.MadXForm');
		if ( forms.length > 0 ) {
			this.xForm = forms[0];
			this.xForm.observe('click',this.select.bind(this));
			if ( $('MadXFormManager') ) {
				$('MadXFormManager').observe('click',this.clickByHref.bind(this));
			}
		}
	},
	select: function ( ev ) {
		var el = ev.element();
		if ( el.tagName == 'DT' ) {
			el.next('dd').toggleClassName('selected');
			el.toggleClassName('selected');
		}
	},
	clickByHref: function( ev ) {
		var el = ev.element();
		ev.stop();
		if ( ! el.href ) {
			return ;
		}
		var url = el.href;
		if ( url.match('edit') ) {
			new Ajax.Request(url, {
				onSuccess: this.openAddForm.bind(this)
			});
		} else if ( url.match('del') ) {
			var selectedInputs = this.xForm.select('.selected input');
			var removeIds = [];
			selectedInputs.each( function( unit, i) {
				removeIds[i] = unit.id;
			}.bind(removeIds));

			new Ajax.Request(url, {
				parameters: {
					'removeIds' : removeIds.join(',')
				},
				onSuccess: this.removeSelected.bind(this)
			});
		}
	},
	removeSelected: function( transport ) {
		var text = transport.responseText;
		alert(text);
		// this.xForm.select('.selected').invoke('remove');
	},
	openAddForm: function ( transport ) {
		var height = $('container').getHeight();
		height += 'px';
		this.blocker = new Element('div',{'id': 'blocker'});
		this.blocker.setStyle({
			'height':height
			});
		$('container').insert(this.blocker);

		var text = transport.responseText;
		this.currentForm = new Element('form',{'id':'MadXFormWriter','class':'madXFormWriter'}).update(text);
		$('container').insert( this.currentForm );
		this.currentFormObserve.bind(this)();
	},
	currentFormObserve: function () {
		this.currentForm.observe( 'submit',this.addForm.bind(this) );
		this.currentForm.observe( 'reset',this.closeAddForm.bind(this) );
	},
	addForm: function( ev ) {
		ev.stop();
		var query = this.currentForm.serialize();
		new Ajax.Request( '/mad/xForm/ins?'+query, {
			onSuccess: this.updateForm.bind(this)
		});
	},
	closeAddForm: function( ev ) {
		this.blocker.remove();
		this.currentForm.remove();
		ev.stop();
	},
	updateForm: function( transport ) {
		var text = transport.responseText
		this.xForm.down('dl').insert(text);
		this.closeAddForm.bind(this)();
	}
});

var SetDate = Class.create({
	initialize: function() {
		this.button = $('btnSetDate');
		this.menu = $('setDate');
		this.button.observe('click',this.toggleMenu.bind(this));
		this.menu.select('a').invoke('observe','click', this.onClick.bind(this));
	},
	onClick: function( ev ) {
		this.madDate = new MadDate;
		ev.stop();
		var el = ev.element();
		var duration = el.className;
		var from = this.getFrom( duration );
		var to = this.madDate.getBase();
		$('sdate').value = from;
		$('edate').value = to;
		this.menu.toggle();
	},
	getFrom: function( duration ) {
		var rv = '';
		if ( duration == 'today' ) {
			rv = this.madDate.setDate(-1).get();
		} else if ( duration == 'threeDays' ) {
			rv = this.madDate.setDate(-3).get();
		} else if ( duration == 'week' ) {
			rv = this.madDate.setDate(-7).get();
		} else if ( duration == 'tenDays' ) {
			rv = this.madDate.setDate(-10).get();
		} else if ( duration == 'month' ) {
			rv = this.madDate.setMonth(-1).get();
		} else if ( duration == 'quarter' ) {
			rv = this.madDate.setMonth(-3).get();
		} else if ( duration == 'halfYear' ) {
			rv = this.madDate.setMonth(-6).get();
		} else if ( duration == 'year' ) {
			rv = this.madDate.setMonth(-1).get();
		}
		return rv;
	},
	toggleMenu: function( ev ) {
		ev.stop();
		this.menu.toggle();
	},
	hideMenu: function( ev ) {
		ev.stop();
		this.menu.hide();
	},
	setdate: function(fmdate){
		with(document.list){
			sdate.value=fmdate;
			edate.value='';
		}
	}
});
var MadDate = Class.create({
	initialize: function() {
		this.baseDate = new Date();
		this.targetDate = new Date();
	},
	getBase: function() {
		var result = this.baseDate.getFullYear().toString() + '-' + (this.baseDate.getMonth()+1).toString() + '-' + this.baseDate.getDate().toString();
		return result;
	},
	get: function( distance ) {
		var result = this.targetDate.getFullYear().toString() + '-' + (this.targetDate.getMonth()+1).toString() + '-' + this.targetDate.getDate().toString();
		return result;
	},
	setYear: function( distance ) {
		this.targetDate.setYear( this.baseDate.getFullYear() + distance );
		return this;
	},
	setMonth: function( distance ) {
		var currentMonth = this.baseDate.getMonth();
		var sum = currentMonth + distance;
		if ( sum > 11 ) {
			this.setYear.bind(this)( 1 );
		} else if ( sum < 0 ) {
			this.setYear.bind(this)( -1 );
		}
		var target = sum % 12;
		this.targetDate.setMonth( target );
		return this;
	},
	setDate: function( distance ) {
		var currentDate = this.baseDate.getDate();
		var sum = currentDate  + distance;
		var lastDayOfMonth = 31;
		if ( sum > lastDayOfMonth ) {
			this.setMonth.bind(this)( 1 );
		} else if ( sum < 1 ) {
			this.setMonth.bind(this)( -1 );
		}
		var target = sum % lastDayOfMonth;
		this.targetDate.setDate( target );
		return this;
	}
});

/*********************** MadXDate *********************/
var MadXDate = Class.create({
	calendar: null,
	current: null,
	initialize: function() {
		$$('.btnMadXDate').invoke('observe','click',this.toggle.bind(this));
	},
	toggle: function( ev ) {
		ev.stop();
		var el = ev.element();
		if ( this.calendar == null ) {
			this.openCalendar( el );
		} else if ( this.current == el ) {
			this.calendar.toggle();
		} else {
			this.current = el;
			this.calendar.show( el );
		}
	},
	openCalendar: function( el ) {
		this.calendar = new MadDateSelector( el );
	}
});
var MadDateSelector = Class.create({
	calendar: null,
	eventer: null,
	initialize: function( el ) {
		this.calendar = new Element('div',{
			'id': 'MadDateSelector'
		}).observe('click', this.byClick.bind(this));
		document.body.insert( this.calendar )

		var today = new Date();
		this.month = today.getMonth();
		this.year = today.getFullYear();

		this.selectMonYear.bind(this)();

		this.show.bind(this)(el);
	},
	nextMonth: function () {
		++ this.month;
		if ( this.month == 11 ) {
			this.month = 0;
			++ this.year;
		}
		this.selectMonYear.bind(this)();
	},
	prevMonth: function () {
		-- this.month;
		if ( this.month < 0 ) {
			this.month = 11;
			-- this.year;
		}
		this.selectMonYear.bind(this)();
	},
	selectMonYear: function ( month, year ) {
		this.calendar.innerHTML = '';
		var today = new Date( this.year, this.month, 1 );
		var prev = new Element('a', {
			'href': '#prevMonth',
			'class': 'prevMonth'
		}).update('&lt;');
		var next = new Element('a', {
			'href': '#nextMonth',
			'class': 'nextMonth'
		}).update('&gt;');
		var monthYear = new Element('span').update( today.getFullYear() + '³â' + ( today.getMonth() + 1) + '¿ù' );
		var monthYearSelector = new Element('div', {'class':'monthYearSelector'});
		monthYearSelector.insert(prev);
		monthYearSelector.insert(monthYear);
		monthYearSelector.insert(next);
		this.calendar.insert(monthYearSelector);
		var lastDay = this.getLastDayOfMonth( today.getMonth(), today.getFullYear() );
		var firstDay = today.getDay();
		if ( firstDay != 0 ) {
			var emptyDays = $R(1,firstDay);
			emptyDays.each( function( unit ) {
				this.calendar.insert( new Element('span', {'class': 'emptyDay' }));
			}.bind(this) );
		}
		var days = $R(1,lastDay );
		days.each( function( unit ) {
			this.calendar.insert( new Element('a', {'href': '#' + unit, 'class': 'day' }).update(unit));
		}.bind(this) );
	},
	getLastDayOfMonth: function( month, year ) {
		var dd = new Date(year,month,0);
		return dd.getDate();
	},
	byClick: function( ev ) {
		ev.stop();
		var el = ev.element();
		if ( el.hasClassName('day') ) {
			this.eventer.previous('input').value = this.year + '-' + (this.month + 1) + '-' + el.innerHTML;
			this.calendar.toggle();
		} else if ( el.hasClassName( 'nextMonth' ) ) {
			this.nextMonth.bind(this)();
		} else if ( el.hasClassName( 'prevMonth' ) ) {
			this.prevMonth.bind(this)();
		}
	},
	toggle: function() {
		this.calendar.toggle();
	},
	show: function( el ) {
		this.eventer = el;
		var pos = el.positionedOffset();
		this.calendar.setStyle({
			'left' : pos.left + 'px',
			'top' : pos.top + 15 + 'px'
		});
		this.calendar.show();
	}
});
/************************* MadXTerm *******************/
var MadXTerm = Class.create({
	eventer: null,
	initialize: function() {
		if ( $('MadXTerm') ) {
			this.menu = $('MadXTerm');
			$$('.btnMadXTerm').invoke('observe','click',this.toggleMenu.bind(this));
			this.menu.select('a').invoke('observe','click', this.onClick.bind(this));
		}
	},
	onClick: function( ev ) {
		this.madDate = new MadDate;
		ev.stop();
		var el = ev.element();
		var duration = el.className;
		var from = this.getFrom( duration );
		var to = this.madDate.getBase();
		this.eventer.previous('input').previous('input').value = from;
		this.eventer.previous('input').value = to;
		this.menu.toggle();
	},
	getFrom: function( duration ) {
		var rv = '';
		if ( duration == 'today' ) {
			rv = this.madDate.setDate(-1).get();
		} else if ( duration == 'threeDays' ) {
			rv = this.madDate.setDate(-3).get();
		} else if ( duration == 'week' ) {
			rv = this.madDate.setDate(-7).get();
		} else if ( duration == 'tenDays' ) {
			rv = this.madDate.setDate(-10).get();
		} else if ( duration == 'month' ) {
			rv = this.madDate.setMonth(-1).get();
		} else if ( duration == 'quarter' ) {
			rv = this.madDate.setMonth(-3).get();
		} else if ( duration == 'halfYear' ) {
			rv = this.madDate.setMonth(-6).get();
		} else if ( duration == 'year' ) {
			rv = this.madDate.setMonth(-1).get();
		}
		return rv;
	},
	toggleMenu: function( ev ) {
		ev.stop();
		var el = ev.element();
		var po = el.positionedOffset();
		var left = po.left;
		var top = po.top + 15;
		this.eventer = ev.element();
		this.menu.setStyle({
			'left': left + 'px',
			'top': top + 'px'
		});
		this.menu.toggle();
	},
	hideMenu: function( ev ) {
		ev.stop();
		this.menu.hide();
	},
	setdate: function(fmdate){
		with(document.list){
			sdate.value=fmdate;
			edate.value='';
		}
	}
});
var MadDate = Class.create({
	initialize: function() {
		this.baseDate = new Date();
		this.targetDate = new Date();
	},
	getBase: function() {
		var result = this.baseDate.getFullYear().toString() + '-' + (this.baseDate.getMonth()+1).toString() + '-' + this.baseDate.getDate().toString();
		return result;
	},
	get: function( distance ) {
		var result = this.targetDate.getFullYear().toString() + '-' + (this.targetDate.getMonth()+1).toString() + '-' + this.targetDate.getDate().toString();
		return result;
	},
	setYear: function( distance ) {
		this.targetDate.setYear( this.baseDate.getFullYear() + distance );
		return this;
	},
	setMonth: function( distance ) {
		var currentMonth = this.baseDate.getMonth();
		var sum = currentMonth + distance;
		if ( sum > 11 ) {
			this.setYear.bind(this)( 1 );
		} else if ( sum < 0 ) {
			this.setYear.bind(this)( -1 );
		}
		var target = sum % 12;
		this.targetDate.setMonth( target );
		return this;
	},
	setDate: function( distance ) {
		var currentDate = this.baseDate.getDate();
		var sum = currentDate  + distance;
		var lastDayOfMonth = 31;
		if ( sum > lastDayOfMonth ) {
			this.setMonth.bind(this)( 1 );
		} else if ( sum < 1 ) {
			this.setMonth.bind(this)( -1 );
		}
		var target = sum % lastDayOfMonth;
		this.targetDate.setDate( target );
		return this;
	}
});
