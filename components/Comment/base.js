document.observe('dom:loaded',function() {
		new MadComment();
		});
var MadComment = Class.create({
initialize: function () {
		  $('MadCommentWrite').select('.btnSubmit')[0].observe('click', this.ins);
		  $('MadCommentList').select('.btnRemove').invoke('observe','click', this.del);
	  },
ins: function() {
var url = $F('MadCommentResponder');
new Ajax.Request( url, {
parameters: {
'MadComment' : 'ins',
relNo : $F('no'),
id : $F('MadCommentId'),
pw : $F('MadCommentPw'),
contents : $F('MadCommentContents')
},
onSuccess: function(transport) {
	// alert (transport.responseText )
	var no = transport.responseText;
	var inner = $('MadCommentList').innerHTML;
	var tpl = new Template("<table> <tr> <td class='no'> #{no} </td> <td class='writer'>#{wDate}</td> <td class='contents'><a class='btnRemove'><img src='/mad/images/MadComment/delete.gif' /></a> <p>#{contents}</p> </td> </tr> </table>");
	var vars = { 'no': no, wDate: 'Now', contents: $F('MadCommentContents') };
	$('MadCommentList').innerHTML = tpl.evaluate(vars) + inner;
}
	});
	 },
del: function( ev ) {
		 var el = ev.element();
		 var url = $F('MadCommentResponder');
		 var no = el.up('table').down('.no').innerHTML;
		 new Ajax.Request( url, {
parameters: {
'MadComment' : 'del',
'no' : no,
},
onSuccess: function(transport) {
el.up('table').remove();
}
});
	 }
});
var IdgComment = Class.create ({
	initialize: function() {
		$('commentSubmit').observe('click', this.ins.bind(this));
		$('IdgCommentForm').observe('submit', this.ins.bind(this));
		$('commentTitle').observe('focus', this.isLogin.bind(this));
		$('commentContent').observe('focus', this.isLogin.bind(this));
	},
	isLogin: function( ev ) {
		if( $F('IdgIsLogin') == '0' ) {
			alert('로그인 후에 사용하실 수 있습니다.');
			ev.element().blur();
		}
	},
	ins: function (ev) {
		ev.stop();
		if ( $F('commentTitle').blank() ) {
			alert('제목이 비어 있습니다.');
			return false;
		}
		if ( $F('commentContent').blank() ) {
			alert('내용이 비어 있습니다.');
			return false;
		}
		new Ajax.Request('/main/IdgComment/ins', {
			parameters : {
				'relIdx': encodeURIComponent($F('relIdx')),
				'title': encodeURIComponent($F('commentTitle')),
				'content': encodeURIComponent($F('commentContent'))
			},
			onSuccess : this.insertRow.bind(this),
			onFailure : this.insFailure.bind(this)
		});
		return false;
	},
	insertRow: function(transport) {
		var text = transport.responseText;
		if ( text === 'Permission Denied' ) {
			alert ( '로그인 하셔야 사용하실 수 있습니다.' );
			return false;
		}
		if ( $('IdgCommentList').down('dl') ) {
			$('IdgCommentList').down('dl').insert({'before':text});
		} else {
			var target = $('IdgCommentList');
			target.insert(text);
			$('IdgCommentList').down('.noContents').hide();
		}
	},
	insFailure: function() {
		alert('입력에 실패하였습니다.');
	}
});
