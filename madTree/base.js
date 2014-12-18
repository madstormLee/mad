// helper
JSON.stringify = JSON.stringify || function (obj) {
    var t = typeof (obj);
    if (t != "object" || obj === null) {
        // simple data type
        if (t == "string") obj = '"'+obj+'"';
        return String(obj);
    }
    else {
        // recurse array or object
        var n, v, json = [], arr = (obj && obj.constructor == Array);
        for (n in obj) {
            v = obj[n]; t = typeof(v);
            if (t == "string") v = '"'+v+'"';
            else if (t == "object" && v !== null) v = JSON.stringify(v);
            json.push((arr ? "" : '"' + n + '":') + String(v));
        }
        return (arr ? "[" : "{") + String(json) + (arr ? "]" : "}");
    }
};

// Tree model
var Tree = {
	mergeTarget: false,
	update: function( form ) {
		jQuery.post(
			form.attr('action'),
			form.serialize(),
			function( result ) {
				if ( result != 1 ) {
					alert( result );
				} else {
					form.css({ opacity: 0 });
					form.animate({ opacity: 1 });

					var next = form.up('dl').next();
					if ( next.length > 0 ) {
						next.find('[type=text]').first().select();
					}
				}
			}
		);
	},
	write: function( href, target ) {
		$.ajax({
			url:  href,
			dataType: 'html',
			success: function( result ) {
				target.append( result );
			}
		});
	},
	delete: function( el ) {
		$.ajax({
			url:  el.attr('href'),
			dataType: 'html',
			success: function( result ) {
				el.up('dl').remove();
			}
		});
	},
	reordering: function( el ) {
		var order = 0;
		var params = {};
		el.up('.subs').find('dl > dt > form').each( function() {
			++ order;
			var id = $(this).find('.id').val();
			params[id] = order;
			$(this).find('.ordernumber').val( order );
		});

		jQuery.ajax({
			type: 'post',
			dataType: 'html',
			url: el.attr('href'),
			data: {
				json: JSON.stringify( params )
			},
			success: function( result ) {
				// alert( "re-ordered " + result + " rows" );
			}
		});
	}
};

// tree controller
$( function() {
	$('nav.component .write').click( function( ev ) {
		ev.preventDefault();
		Tree.write( this.href, $('.treeContainer .tree') );
	});

	$('.treeContainer').submit( function ( ev ) {
		ev.preventDefault();
		Tree.update( $(ev.target) );
	});

	$('.treeContainer .tree').click( function ( ev ) {
		var el = $(ev.target);
		if( el[0].tagName === 'A' ) {
			ev.preventDefault();
		}

		if ( el.hasClass('delete') ) {
			var result = true;
			var next = el.up('dt').next();
			if ( next.length > 0 ) {
				alert('Sub directory exists.');
				return false;
			}
			Tree.delete( el );
		}
		else if ( el.hasClass('hasSubs') ) {
			var next = el.up('dt').next();
			if( next[0].tagName == 'DD' ) {
				next.toggle();
			}
		}
		else if ( el.hasClass('createSub') ) {
			var dd = el.up('dt').next();
			if( dd[0] === undefined || dd[0].tagName != 'DD' ) {
				var dd = $('<dd></dd>');
				el.up('dt').after( dd );
			}
			el.up('dt').find('a.toggle').html('+').addClass('hasSubs');
			Tree.write( el.attr('href'), dd );
		}
		else if ( el.hasClass('moveUp') ) {
			// this has problem when js doesn't works. need refactorying... but easier
			var dl = el.up('dl');
			var prev = dl.prev('dl');
			if ( prev[0] !== undefined ) {
				prev.before(dl);
			}
			Tree.reordering( el );
		}
		else if ( el.hasClass('moveDown') ) {
			var dl = el.up('dl');
			var next = dl.next('dl');
			if ( next[0] !== undefined ) {
				next.after(dl);
			}
			Tree.reordering( el );
		}
	});
});
