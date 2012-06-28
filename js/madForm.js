Event.observe(window, 'load', function () {
		MadForm.init();
		});
var MadForm = {
init: function () {
		  MadForm.DateSelector.init();
	  }
}
MadForm.DateSelector = {
eventer: null,
selector: null,
init: function () {
		  $$('.madForm').each(function(madForm) {
				  madForm.select('.date').each(function(unit){
					  unit.observe('click',MadForm.DateSelector.open);
					  });
				  });
	  },
open: function( event ) {
		  var el = event.element();
		  MadForm.DateSelector.eventer = el;
		  if ( MadForm.DateSelector.selector == null ) {
			  MadForm.DateSelector.create(el);
		  } else {
			  var dateSelector = MadForm.DateSelector.selector;
		  	dateSelector.show();
		  }
	  },
create: function( el ) {
		  var now = new Date();
		  now.setYear(2100);
		  now.setMonth(1);
		  var nowYear = now.getFullYear();
		  var nowMonth = now.getMonth();
		  var nowDay = now.getDate();
		  now.setDate(1);
		  var firstDayWeek = now.getDay();
		var months = [31,28,31,30,31,30,31,31,30,31,30,31];
		if ( nowYear % 400 ==0 ) {
			months[1] = 29;
		} else if ( nowYear % 100 ==0 ) {
			months[1] = 28;
		} else if ( nowYear % 4 ==0 ){
			months[1] = 29;
		}

		  var dateSelector = new Element('div', {'class':'dateSelector'});
		  MadForm.DateSelector.selector = dateSelector;

		  var year = new Element('span',{'class':'year'}).update(nowYear);
		  var prevYear = new Element('a',{'class':'prevYear'}).update('&lt;');
		  var nextYear = new Element('a',{'class':'nextYear'}).update('&gt;');
		  var month = new Element('span',{'class':'month'}).update(nowMonth+1);
		  var prevMonth = new Element('a',{'class':'prevMonth'}).update('&lt;');
		  var nextMonth = new Element('a',{'class':'nextMonth'}).update('&gt;');
		  var days = new Element('div',{'class':'days'});
		  var day;
		  var dayText;
		  for ( var b= 1; b <= firstDayWeek; b++ ) {
			  day = new Element('a').update('&nbsp');
			  days.insert(day);
		  }
		  for ( var i = 1; i <= months[nowMonth]; i++){
			  if (i < 10) dayText = '0'+i;
			  else dayText = i;
			  day = new Element('a',{'href':'javascript:;'}).update(dayText).observe('click',MadForm.DateSelector.select);
			  if ( (firstDayWeek + i) % 7 == 0 ) { day.addClassName('saturday'); }
			  if ( (firstDayWeek + i) % 7 == 1 ) { day.addClassName('sunday'); }
			  days.insert(day);
		  }

		  el.up('.madForm').insert(dateSelector);
		  dateSelector.insert(prevYear);
		  dateSelector.insert(year);
		  dateSelector.insert(nextYear);
		  dateSelector.insert(prevMonth);
		  dateSelector.insert(month);
		  dateSelector.insert(nextMonth);
		  dateSelector.insert(days);
		  year.observe('click',MadForm.DateSelector.yearSelector);
		  month.observe('click',MadForm.DateSelector.monthSelector);
	  },
yearSelector: function(event){
				  var el = event.element();
				  var baseYear = parseInt(el.innerHTML);
				  var yearSelector = new Element('div',{'class':'yearSelector'});
				  var year;
				  var i = baseYear - 10;
				  for ( i; i < baseYear + 10; i++){
					  year = new Element('a').update(i).observe('click',MadForm.DateSelector.selectYear);
					  if ( i == baseYear ) {
						  year.addClassName('current');
					  }
					  yearSelector.insert(year);
				  }
				  el.up('.dateSelector').insert(yearSelector);
				  yearSelector.absolutize();
				  yearSelector.style.top = '20px';
				  yearSelector.style.left = '0px';
			  },
selectYear: function ( event ){
				var el = event.element();
				var selector = MadForm.DateSelector.selector;
				selector.down('.year').innerHTML = el.innerHTML;
				el.up('.yearSelector').remove();
			},
monthSelector: function( event ){
				   var el = event.element();
				   var baseMonth = parseInt(el.innerHTML);
				   var monthSelector = new Element('div',{'class':'monthSelector'});
				   var month;
				   var monthText;
				   for ( i=1; i < 13; i++){
					   if (i < 10) monthText = '0'+i;
					   else monthText = i;
					   month = new Element('a').update(monthText).observe('click',MadForm.DateSelector.selectMonth);
					   if ( i == baseMonth ) {
						   month.addClassName('current');
					   }
					   monthSelector.insert(month);
				   }
				   el.up('.dateSelector').insert(monthSelector);
				  monthSelector.absolutize();
				  monthSelector.style.top = '-30px';
				  monthSelector.style.left = '50px';
			   },
selectMonth: function( event ){
				 var el = event.element();
				 var selector = MadForm.DateSelector.selector;
				 selector.down('.month').innerHTML = el.innerHTML;
				 el.up('.monthSelector').remove();
			 },
select: function ( event ){
			var el = event.element();
			var eventer = MadForm.DateSelector.eventer;
			var selector = MadForm.DateSelector.selector;
			var year = selector.down('.year').innerHTML;
			var month = selector.down('.month').innerHTML;
			var day = el.innerHTML;
			eventer.value = year + month + day;
			selector.hide();
		}
}
