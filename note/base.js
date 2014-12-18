Event.observe(window, 'load', function() {
		MadNote.init();
		});
var MadNote = {
top: '90px',
left: '-90px',
init: function() {
	MadNote.initNotes();
		  Sortable.create('MadNoteInstance');
		  new Draggable('MadNoteInstance',{scroll:window});
		  $('MadNotesToggle').observe('click', MadNote.toggleAll);
		  $('madNoteIcon').observe('click', MadNote.toggle);
		  $('MadNoteClose').observe('click', MadNote.toggle);
		  $('MadNoteSave').observe('click', MadNote.save);
	  },
toggleAll: function() {
			   var state = $$('.MadNotes')[0];
			   if( state == undefined ) return;
			   if( state.style.display == 'none' ) {
			   $$('.MadNotes').each(function(unit){ unit.show(); });
			   } else {
			   $$('.MadNotes').each(function(unit){ unit.hide(); });
			   }
		   },
initNotes: function() {
	$$('.MadNotes').each( function(unit) {
			var id = unit.id;
			Sortable.create(id);
			new Draggable(id,{scroll:window});
	});
	$$('.btnMadNoteView').each( function(unit) {
			unit.observe('click', MadNote.noteToggle);
			});
	$$('.btnMadNoteRemove').each( function(unit) {
			unit.observe('click', MadNote.noteRemove);
			});
		   },
noteRemove: function (event) {
		var yesno = confirm("Do you really want to REMOVE this?");
		if ( yesno == false ) return;
		var el = event.element();
		var pg = $('program').value;
		var tail = $('tail').value;
		var targetNo = el.previous('.MadNoteNo').value;

		new Ajax.Request('/AjaxFront.php?pg=MadNote&tail='+tail+'&'+pg+"=remove", {
parameters: {'no': targetNo },
onSuccess: function(transport){
el.up('.MadNotes').remove();
},
onFailure: function(){
alert('failed');
}
				});
				},
toggle: function() {
			$('MadNoteInstance').toggle();
			$('MadNoteInstance').style.left = MadNote.left;
			$('MadNoteInstance').style.top = MadNote.top;
			$('MadNoteContent').value='';
		},
noteToggle: function(event) {
				event.element().next('dl').toggle();
			},
save: function() {
		  var pg = $('program').value;
		  var tail = $('tail').value;
		  var uri = $('request_uri').value;
		  var x = $('MadNoteInstance').style.left;
		  var y = $('MadNoteInstance').style.top;
		  var width = $('MadNoteInstance').getWidth();
		  var height = $('MadNoteInstance').getHeight();
		  var writer = 'Madstorm';
		  var content = $('MadNoteContent').value;

		  if ( content.empty() ) {
			  alert( 'You neet to write some' );
			  return ;
		  }

		  new Ajax.Request('/AjaxFront.php?pg=MadNote&tail='+tail+'&'+pg+"=req", {
method: 'post',
parameters: { 
'x': x,
'y': y,
'width': width,
'height': height,
'uri': uri,
'content': content
},
onSuccess: function (transport) {
var result = transport.responseText;
$('top').insert(result, {position: 'before'});
MadNote.initNotes();
MadNote.toggle();
}
				  });
	  }
}
