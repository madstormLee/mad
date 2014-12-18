var relFileForm;
Event.observe(window,'load', function() {
	new BoardView;
});
document.observe('dom:loaded', function() {
	if ( $('MadBoard') && $F('MadBoard') == 'ins' ) {
		new RelNewsForm;
		relFileForm = new RelFileForm;
		new BoardWrite;
		new FlashEditor;
		new AutoSave();
	}
	});
// 이건 사실 여기 있는것이 이상하다.
// sectionView에 들어 있을 것이라는 assumption이 존재한다.
var BoardView = Class.create({
	initialize: function() {
		if ( this.sectionView = $('sectionView') ) {
			this.sectionView.select('img').each( function(unit) {
				var width = unit.getWidth();
				if ( width > 630 ) {
					var height = unit.getHeight();
					unit.width = 630;
					unit.height = 630 * height / width;
					
				}
			});
		}
	}
});
var RelNewsForm = Class.create({
	initialize: function() {
		if ( this.relNews = $('relatedNews') ) {
			this.relNews.observe('click',this.byClick.bind(this));
			if ( $('relNewsSubmit') ) {
				$('relNewsSubmit').observe('click',this.onSubmit.bind(this));
			}
			this.MadBoardId = $F('MadBoardId');
		}
	},
	byClick: function( ev ) {
		ev.stop();
		var el = ev.element();
		if ( el.hasClassName('delx') ) {
			this.remove.bind(this)(el);
		}
	},
	remove: function( el ) {
		new Ajax.Request( el.href, {
			parameters: { 'id': $F('MadBoardId') },
			onSuccess: function( transport ) {
				var result = transport.responseText;
				if ( result == '1') {
					el.up('li').remove();
				} else {
					alert(result);
				}
			}
		});
	},
	onSubmit: function( ev ) {
		ev.stop();
		if ( $F('relNewsTitle').blank() ) {
			alert('제목이 비어 있습니다.');
			return;
		}
		var link = $F('relNewsLink');
		if ( link.blank() || link == 'http://' ) {
			alert('정확한 링크 주소를 써 주세요.');
			return;
		}
		var url = '/mad/fileManager/addRelNews?id='+this.MadBoardId;
		new Ajax.Request(url,{
			parameters: {
			'no' : $F('uniqueNo'),
			'title': $F('relNewsTitle'),
			'link': $F('relNewsLink')
			},
			onSuccess: this.onAdded.bind(this)
		});
	},
	onAdded: function( transport ) {
	   var result = transport.responseText;
	   if ( result != '0' ) {
		   var relNo = result;
		   var value = "<li><a href='"+ $F('relNewsLink') + "' target='_blank'>" + $F('relNewsTitle') + "</a><a class='delx' title='삭제' href='/mad/fileManager/removeRelNews?relNo="+relNo+"'>x</a></li>";
		   this.relNews.insert(value);
		   $('relNewsTitle').value = '';
		   $('relNewsLink').value = 'http://';
	   } else {
		   alert('저장도중 문제가 발생하였습니다.\n' + result);
	   }
	}
});
var RelFileForm = Class.create({
	initialize: function() {
		if ( this.fileList = $('relFileList') ) {
			this.fileList.observe('click', this.byClick.bind(this));
		}
	},
	byClick: function( ev ) {
		this.el = ev.element();
		if ( this.el.hasClassName('delx') ) {
			ev.stop();
			new Ajax.Request( this.el.href, {
				parameters: {
					id: $F('MadBoardId')
				},
				onSuccess: this.removeRow.bind(this)
			});
		}
	},
	removeRow : function( transport ) {
		var result = transport.responseText;
		if ( result == '1' ) {
			this.el.up('li').remove();
		} else {
			alert(result);
		}
	},
	uploadResult: function( link, relNo ) {
		if ( link == '0' ) {
			alert('저장중 문제가 발생하였습니다.');
			return;
		}
		var relFileName = $F('relFileName');
		var row = '<li><a href="'+link+'" target="_blank" >'+relFileName+'</a> <a class="delx" title="삭제" href="/mad/fileManager/removeRelFile?relNo='+relNo+'">x</a></li>';
		$('relFileList').insert(row);
		$('relFileForm').reset();
	},
	onAdd: function( ev ) {
		ev.stop();
		var row = "<li><input type='file' name='relFile[]' size='50' /></li>";
		this.target.insert(row);
	},
	onDiminish: function( ev ) {
		ev.stop();
		var items = this.target.select('li');
		var rows = items.length;
		if( rows < 1 ) {
			return false;
		} else {
			var row = rows - 1;
			items[row].remove();
		}
	}
});
var BoardWrite = Class.create({
	initialize: function() {
		if ( this.title = $('title') ) {
			this.title.observe('focus',this.onFocus.bind(this));
			this.title.observe('blur',this.onBlur.bind(this));
		}
	},
	onFocus: function( ev ) {
		if ( this.title.value == '제목을 입력해 주세요.' ) {
			this.title.value = '';
		} else {
			this.title.select();
		}
	},
	onBlur: function( ev ) {
		if ( this.title.value.blank() ) {
			this.title.value = '제목을 입력해 주세요.';
		}
	}
});
var FlashEditor = Class.create({
	initialize: function() {
		if ( this.button = $('btnFlashEditor') ) {
			this.button.observe('click', this.launchTheEditor);
		}
	},
	launchTheEditor: function() {
		var str_url = "/flashEditor/app_client.php?layout_type=1&layout_size=1";
		var myty = window.open(str_url,"popup1","scrollbars=0,width=800,height=665,status=yes,resizable=No");
	}
});

var AutoSave = {
	initialize: function() {
		this.url = $('ArticleWriteOptions').down('.autoSave').href;
		this.resultBox = $('autoSaveResult');
		$$('.options .autoSave').invoke('observe','click',this.clickSave.bind(this));
		$('autoSaveTime').observe('change', this.autoSave.bind(this));
		this.autoSave.bind(this)();
	},
	autoSave: function() {
		if ( this.autoSaver ) {
			this.autoSaver.stop();
		}
		var periodTime = parseInt($F('autoSaveTime'));
		this.autoSaver = new PeriodicalExecuter(this.saveByCondition.bind(this), periodTime);
	},
	saveByCondition: function() {
		if ( $F('autoSave') ) {
			this.save.bind(this)();
		}
	},
	clickSave: function( ev ) {
		ev.stop();
		this.save.bind(this)();
	},
	save: function() {
		this.resultBox.update('저장중입니다.').show();
		if (! this.oEditor ) {
			this.oEditor = FCKeditorAPI.GetInstance('content');
		}
		this.oEditor.UpdateLinkedField();
		var title = $F('title');
		var content =  $F('content');

		new Ajax.Request( this.url, {
			parameters: {
				'title': title,
				'content': content
			},
			onSuccess: this.afterSave.bind(this)
		});
	},
	afterSave: function(transport) {
		var result = transport.responseText;
		if ( result == '0' ) {
			result = '저장 도중 알 수 없는 문제가 발생하였습니다.';
		}
		this.resultBox.update(result);
		Element.hide.delay(3, this.resultBox);
	}
}
