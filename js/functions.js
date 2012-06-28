function toMoney( value ) {
	var rv = parseInt(value) + '';
	var rest = value - parseInt(value);
	rest = rest + '';
	rest = rest.substring(1);
	var parts = Array();
	var right = '';

	for ( var i = 0; i < rv.length / 3; i ++ ) {
		parts[i] = rv.substring(rv.length-3,rv.length);
		rv = rv.substring(0,rv.length-3);
	}
	parts.each( function(unit){
			right = ',' + unit + right;
			});
	rv = rv + right + rest;
	return rv;
}
