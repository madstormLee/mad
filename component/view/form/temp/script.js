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

var MadDateSelector = {
	is_selector: 0,
	reqId: null,
	   init: function(){
		   $$('.MadDateSelector').each(function(unit){
				   unit.observe('click', MadDateSelector.open);
				   });
	   },
open: function( event ){
		  if ( MadDateSelector.is_selector == 1 ) {
			  MadDateSelector.close();
		  }
		  MadDateSelector.is_selector = 1;
		  var offset = event.element().cumulativeOffset();
		  var _x = offset.left + 50;
		  var _y = offset.top - 30;
		  var calendar = new Element('div',{'id':'MadDateSeletor'});
		  $('container').insert(calendar);
		  calendar.absolutize();
		  calendar.style.left = _x + 'px';
		  calendar.style.top = _y + 'px';
		  MadDateSelector.request();
		  MadDateSelector.reqId = event.element().id;
	  },
request: function ( event ) {
			 var myDate = new Date();
			 var target_year = $('CurrentYear') ? $('CurrentYear').innerHTML : myDate.getFullYear();
			 var target_month = $('CurrentMonth') ? $('CurrentMonth').innerHTML : myDate.getMonth()+1 ;
			 if (event){
				 var doing = event.element().id;
				 if (doing == 'prevYear' ) target_year-- ;
				 if (doing == 'nextYear' ) target_year++ ;
				 if (doing == 'prevMonth' ) target_month--;
				 if (doing == 'nextMonth' ) target_month++;
				 if (target_month > 12 ) {
					 target_year++;
					 target_month = 1;
				 }
				 if (target_month < 1 ) {
					 target_year--;
					 target_month = 12;
				 }
			 }

	 new Ajax.Request('/AjaxFront.php?pg=MadCalendar', {
		parameters: { year: target_year, month: target_month },
		onSuccess: function( value ){
			$('MadDateSeletor').innerHTML = value.responseText;
			$('prevYear').observe('click', MadDateSelector.request);
			$('nextYear').observe('click', MadDateSelector.request);
			$('prevMonth').observe('click', MadDateSelector.request);
			$('nextMonth').observe('click', MadDateSelector.request);
			$$('.day').each(function(td){
				td.observe('click',MadDateSelector.enterDate);
		});
		}
	});
},
enterDate: function ( event ) {
			   var target = MadDateSelector.reqId;
			   $(target).value = $('CurrentYear').innerHTML +'-'+ $('CurrentMonth').innerHTML +'-'+ event.element().innerHTML;
			   MadDateSelector.close();
		   },
close: function () {
		   $('MadDateSeletor').remove();
		   MadDateSelector.is_selector = 0;
	   }
}

// start
$( function() {
	MadDateSelector.init();
});
