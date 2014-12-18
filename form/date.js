document.observe('dom:loaded', function() {
	new MadXDate();
});
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
