<?
class MadGallery extends MadDbProgram {
	protected $madlog;
	protected $js;
	protected $where;
	protected $local;
	protected $localNo;
	public $query;

	function __construct( $id ) {
		$this->madlog = MadLog::getInstance();
		parent::__construct( $id );

		$this->personalConfig = new MadPersonalConfig();
		$this->madArr = array();

		$this->init();
		$this->sess = new MadSession($this->table);

		$this->buttons = new Layout('Gallery/buttons');
		$this->buttons->mode = $this->mode;
		$this->buttons->query = $this->sess->listQuery;
		$this->srcDir = '/photo/';
		$this->group = new MadGroup('gallerySection');
		$this->query = new MadQuery($this->table);
		$this->section1 = array(
		'aomori',
		'akita',
		'iwate',
		'hokkaido',
		);
		$this->section2 = array(
		'-전체-',
		'축제',
		'사계',
		'레져',
		'온천',
		'전통공예',
		'향토요리',
		);
	}
	function setLocal($local) {
		$this->local = $local;
		$section = $this->group->getSubGroup(0);
		foreach( $section as $row ) {
			if ( $row['name'] == $local ) {
				$this->localNo = $no = $row['no']; 
				$subs = $this->group->getSubGroup($no);
				$relNo = array($no);
				foreach( $subs as $sub ) {
					$no = $sub['no'];
					$relNo[] = $no;
				}
				$relNo = implode(',',$relNo);
				$this->query->addWhere("relNo in ($relNo)");
			}
		}
	}
	function init() {
		$this->base = $this->ini->load('base.ini');
		if ( ! empty( $this->base['viewsDir'] ) ) {
			$this->setViewsDir(ROOT.$this->base['viewsDir']);
		}
		if ( ! empty( $this->base['cssDir'] ) ) {
			$this->style->set($this->base['cssDir'] . 'base');
			$this->style->set($this->base['cssDir'] . $this->mode);
		}
	}
	public function smallListAction() {
	}
	private function listProcess($tuple) {
		if ( count($tuple) > 0 ) {
			$tuple = sqlout($tuple);
			foreach ( $tuple as $key => $row ) {
				extract($row);
				$tuple[$key]['thumb'] = $this->srcDir.'thumb/'.$image;
			}
		}
		return $tuple;
	}
	function addWhere($rule, $glue='and') {
		$this->query->addWhere($rule,$glue);
	}
	function listAction(){
		$this->sess->listQuery = $_SERVER['QUERY_STRING'];
		$section2 = 0;
		if ( $section2 = ckGet('section2') ) {
			$this->query->addWhere("relNo like '%$section2'");
		}
		if ( $searchWord = ckGet('searchWord') ) {
			$this->query->addWhere("title like '%$searchWord%' or content like '%$searchWord%'");
		}
		$form = new MadForm;
		$subSection = $this->group->getSubGroup($this->localNo);
		$selectVN = array();
		foreach ( $subSection as $row ) {
			$sectionVN[$row['no']] = $row['name'];
		}
		$this->sectionSelect2 = $form->select('section2',$sectionVN, $section2);
		$total = $this->query->getTotal();
		$pageNavi = new PageNavi($total,18,10);
		$this->query->setLimit($pageNavi->getLimit());
		$this->query->addOrder('no');

		$q = $this->query->getQ();
		$tuple = $q->toArray();
		$this->tuple = $this->listProcess($tuple);

		$this->pageNavi = $pageNavi;

		$this->search = '';
	}
	private function viewProcess($row) {
		$rv = sqlout($row);
		extract($row);
		$content = stripSlashes($content);
		$row['image'] = $this->srcDir.$image;
		$row['thumb'] = $this->srcDir.'thumb/'.$image;
		$row['middle'] = $this->srcDir.'middle/'.$image;

		$row['content'] = $content;
		$row['plainContent'] = nl2br(strip_tags($content));
		return $row;
	}
	private function addPoint($no) {
		$saw = array();
		if ( ! empty($this->sess->saw) ) {
			$saw = $this->sess->saw;
		}
		if ( in_array($no, $saw) ) {
			return false;
		}
		$query = "update $this->table set points=points+1 where no=$no limit 1";
		$q = new Q($query);
		$saw[] = $no;
		$this->sess->saw = $saw;
	}
	function viewAction() {
		$no = $this->getNo();
		$this->addPoint($no);
		$where = '';
		$query = "select * from $this->table where no=$no limit 1";
		if ( isset($_GET['direction']) ) {
			$direction = $_GET['direction'];
			if ( $direction == 'left' ) {
				$query = "select * from $this->table where no < $no order by no desc limit 1";
			}
			if ( $direction == 'right' ) {
				$query = "select * from $this->table where no > $no limit 1";
			}
		}
		$q = new Q($query);
		$data = $this->viewProcess($q->row());
		$q = new Q("select min(no) as min ,max(no) as max  from $this->table $where");
		$row = $q->row();
		$data['min'] = $row['min'];
		$data['max'] = $row['max'];
		$this->set($data);
		$this->comment = new MadComment($this->id);
		$this->buttons->no = $no;
	}
	function writeAction() {
		if ( $no = ckGet('no') ) {
			$this->rewriteProcess($no);
		} else {
			$this->writeProcess($no);
		}
	}
	private function writeProcess() {
		$form = new MadForm;
		$row = array(
				'no' => '',
				'mode' => 'ins',
				'middle' => '/main/images/preImage.gif',
				'title' => $form->text('title','타이틀을 써 주세요.'),
				'content' => $form->textarea('content','사진의 내용을 써 주세요.'),
				'firstSection' => $this->getFirstSection(),
				);
		$this->set($row);
	}
	private function getFirstSection( $current ) {
		$gallerySection = $this->group->getSubGroup(0);
		array_unshift($gallerySection, array ( 'no'=>0, 'name' => '첫번째 섹션'));
		$rv = "<select id='firstSection' name='section[]'>";
		foreach ( $gallerySection as $sections ) {
			extract($sections);
			$rv .= "<option value='$no'>$name</option>";
		}
		$rv .= '</select>';
		return $rv;
	}
	private function getNo() {
		if ( ! $rv = ckGet('no') ) {
			replace('/main/error/illigalAccess'); // this has an assumption.
		}
		return $rv;
	}
	function rewriteProcess($no) {
		$form = new MadForm;
		$query = "select * from $this->table where no=$no limit 1";
		$q = new Q($query);
		$row = $q->row();
		extract($row);
		$currentFirstSection = $this->group->getTopNo($relNo);
		$row = array(
				'no' => $form->hidden('no',ckGet('no')),
				'mode' => 'up',
				'middle' => $this->srcDir.'middle/'.$image,
				'title' => $form->text('title',$title),
				'content' => $form->textarea('content',$content),
				'firstSection' => $this->getFirstSection($currentFirstSection),
				);
		$this->set($row);
	}
	protected function insAction() {
		if ( ! $this->madlog->isLogin() ) {
			replace('/main/error/illegalAccess');
		}
		extract(sqlin($_POST));
		if ( $section = ckPost('section') ) {
			$sections = array_reverse($section);
			foreach ( $sections as $section ) {
				if ( ! empty($section) ) {
					break;
				}
			}
		}

		$dirName = dirname($image);
		$baseName =  baseName($image);

		$set = new MadSet(sqlin($_POST));
		$set->remove($this->program);
		$set->remove('section');
		$set->add('id',$this->madlog->getUserId());
		$set->add('image',basename($baseName));
		$set->relNo = $section;
		$set->wDate = 'now()';
		$query = "insert into $this->table $set";
		if ( is_file( ROOT . $image ) ) {
			$this->createThumbs($baseName, $dirName);
		}
		$q = new Q($query);
		$no = $q->getInsertId();
		replace("?MadGallery=view&no=$no");
	}
	private function createThumbs( $imageName, $dirName ) {
		$image = ROOT.$dirName.'/'.$imageName;
		$thumb = ROOT.$dirName.'/thumb/'.$imageName;
		$middle = ROOT.$dirName.'/middle/'.$imageName;
		MadGd::createThumb($image,$thumb,100,100);

		list( $width, $height ) = getimagesize($image);
		$ratio = $width / $height;
		if ( $ratio > 4/3 ) {
			$x = 600;
			$y = round($height * 600 / $width);
		} else {
			$y = 450;
			$x = round($width * 450 / $height);
		}
		MadGd::createThumb($image,$middle,$x,$y);
	}
	protected function upAction(){
		if ( ! $this->madlog->isLogin() ) {
			replace('/main/error/illegalAccess');
		}
		if ( ! $no = ckPOST('no') ) {
			replace('/main/error/illegalAccess');
		}
		extract(sqlin($_POST));
		if ( $section = ckPost('section') ) {
			$sections = array_reverse($section);
			foreach ( $sections as $section ) {
				if ( ! empty($section) ) {
					break;
				}
			}
		}

		$dirName = dirname($image);
		$baseName =  baseName($image);

		$set = new MadSet(sqlin($_POST));
		$set->remove($this->program);
		$set->remove('section');
		$set->add('id',$this->madlog->getUserId());
		$set->add('image',basename($baseName));
		$set->relNo = $section;
		$set->wDate = 'now()';
		$query = "update $this->table $set where no=$no";
		if ( is_file( ROOT . $image ) ) {
			$this->createThumbs($baseName, $dirName);
		}
		$q = new Q($query);
		replace("?MadGallery=view&no=$no");
	}
	function delAction(){
		$no = ckGet('no');
		if ( ! $this->madlog->isLogin() ) {
			replace('/main/error/illegalAccess');
		}
		if ( $this->madlog->isAdmin() ) {
			$query = "delete from $this->table where no=$no";
		} else {
			$id = $this->madlog->getUserId();
			$query = "delete from $this->table where no=$no and id=$id";
		}
		$q = new Q($query);
		if ( $q->rows() < 1 ) {
			alert('삭제오류 입니다.', 'back', 'replace');
		} else {
			alert('삭제되었습니다.','?','replace');
		}
	}
}
