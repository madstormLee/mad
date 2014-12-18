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

var Tree = {
	mergeTarget: false,
	update: function( href ) {
		$.ajax({
			url:  href,
			success: function( result ) {
				$('.treeContainer .tree').html( result );
			}
		});
	},
	write: function( href, target ) {
		$.ajax({
			url:  href,
			success: function( result ) {
				target.append( result );
			}
		});
	},
	delete: function( href, target ) {
		$.ajax({
			url:  href,
			success: function( result ) {
				target.remove();
			}
		});
	},
	reordering: function( target ) {
		var order = 0;
		var params = {};
		target.find('dl > dt > form').each( function() {
			++ order;
			// $(this).addClass('changed');
			var id = $(this).find('.id').val();
			params[id] = order;
			$(this).find('.ordernumber').val( order );
		});

		jQuery.ajax({
			type: 'post',
			url: '/store/admin/items/itemcategory/updateOrderFromJson',
			data: {
				json: JSON.stringify( params )
			},
			success: function( result ) {
				$('#console').html( "re-ordered " + result + " rows" );
			}
		});
	}
};

$( function() {
	$('nav.component .load').click( function( ev ) {
		ev.preventDefault();
		this.blur();
		if ( $('.treeContainer .tree').html().trim() == '' ) {
			Tree.update( this.href );
			return false;
		}
		$('#categoryLoadWays').toggle();
	});
	$('nav.component .write').click( function( ev ) {
		ev.preventDefault();
		Tree.write( this.href, $('.treeContainer .tree') );
	});
	$('#categoryLoadWays a').click( function( ev ) {
		ev.preventDefault();
		this.blur();
		Tree.update( this.href );
		$('#categoryLoadWays').toggle();
	});
	$('.treeContainer .tree').change( function ( ev ) {
		var el = $(ev.target);
		$.ajax({
			type: 'post',
			url:  el.up('form').attr('action'),
			data: {
				id: el.up('form').find('.id').val(),
				label: el.val()
			},
			success: function( result ) {
				if ( parseInt( result ) > 0 ) {
					alert('updated' );
				} else {
					alert( result );
				}
			}
		});
	});


	$('.treeContainer .tree').click( function ( ev ) {
		var el = $(ev.target);
		if( el[0].tagName === 'A' ) {
			ev.preventDefault();
		}
		if ( el.hasClass('delete') ) {
			var result = true;
			if ( 0 !== parseInt( el.up('dt').find('.items').html() ) ) {
				result = confirm( el.parent('dt').find('.label').attr('value') + ' 카테고리 아래 아이템이 등록되어 있습니다. 모두 삭제하시겠습니까?"' )
			}
			if ( result ) {
				Tree.delete( el.attr('href'), el.up('dt') );
			}
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
			var dl = el.up('dl');
			var prev = dl.prev('dl');
			if ( prev[0] !== undefined ) {
				prev.before(dl);
			}
			Tree.reordering( el.up('.subs') );
		}
		else if ( el.hasClass('moveDown') ) {
			var dl = el.up('dl');
			var next = dl.next('dl');
			if ( next[0] !== undefined ) {
				next.after(dl);
			}
			Tree.reordering( el.up('.subs') );
		}
		else if ( el.hasClass('merge') ) {
			if ( Tree.mergeTarget == false ) {
				// alert('Click destination.\nThen, remove this category and move all items to destination category.');
				el.up('dt').addClass('target');

				Tree.mergeTarget = el;
			} else {
				if ( Tree.mergeTarget.attr('href') == el.attr('href') ) {
					Tree.mergeTarget.up('dt').removeClass('target');
					Tree.mergeTarget = false;
					return false;
				}
				jQuery.ajax({
					type: 'post',
					url:  Tree.mergeTarget.attr('href'),
					data: {
						destination: el.up('form').find('.id').val(),
					},
					success: function( result ) {
						if( result == true ) {
							var targetItems = Tree.mergeTarget.up('form').find('.items');
							var destinationItems = el.up('form').find('.items');
							var items = parseInt( targetItems.html() ) + parseInt( destinationItems.html() );
							destinationItems.html( items );

							Tree.mergeTarget.up('dt').remove();
							Tree.mergeTarget = false;

							return false;
						}
						alert( result );
						Tree.mergeTarget.up('dt').removeClass('target');
						Tree.mergeTarget = false;
					}
				});
			}
		}
	});
	$('.treeContainer').submit( function ( ev ) {
		ev.preventDefault();
		alert('submitting');
	});
});
