<?
class MadCounter {
	private $className;
	private $table;
	public $totalMonth;

	function __construct(){
		$this->className = __class__;
		$this->table = __class__;
		$this->sess = new MadSession($this->className);
		if ( ! isset( $this->sess->id ) ) {
			$this->ins();
		}
	}
	function getMonthly($monYear){
		$sDate = $monYear.'01';
		$eDate = date('Ymd', strtotime("$sDate +1 month"));

		$rv = array();
		$days = range(1,date('t',strtotime($sDate)));

		$where = "where wDate between $sDate and  $eDate";
		$query = "select count(*) as cnt, date_format(wDate,'%Y%m%d') as dt from $this->table $where group by dt order by dt asc";
		$q = new Q($query);
		$arrCount = $q->toArray();
		$dayCnt = array();

		$countCache = $this->getCountCacheMonthly($monYear);
		foreach( $arrCount as $row ) {
			extract($row);
			$day = intval(substr($dt,-2));
			$dayCnt[$day]['cnt'] = $cnt;
		}
		$max = 1;
		$total = 0;
		foreach( $days as $day ) {
			if (  isset($countCache[$day]) ) {
				if ( isset($dayCnt[$day]['cnt']) ) {
					$dayCnt[$day]['cnt'] += $countCache[$day];
				} else {
					$dayCnt[$day]['cnt'] = $countCache[$day];
				}
			}
			if ( isset ( $dayCnt[$day]['cnt'] ) ) {
				$total += $dayCnt[$day]['cnt'];
				if ( $dayCnt[$day]['cnt'] > $max ) {
					$max = $dayCnt[$day]['cnt'];
				}
			}
		}
		$this->totalMonth = number_format($total);
		foreach( $days as $day ) {
			$rv[$day]['day'] = $day;
			$rv[$day]['cnt'] =  0;
			$rv[$day]['width'] = 0;
			$rv[$day]['group'] = 'orange';
			if ( isset($dayCnt[$day]) ) {
				$rv[$day]['cnt'] =  $dayCnt[$day]['cnt'];
			}
			if ( $max > 100 ) {
				$rv[$day]['width'] = intval( log($rv[$day]['cnt']) / log($max) * 100);
				if ( empty( $rv[$day]['width'] ) or $rv[$day]['cnt']==0 ) {
					$rv[$day]['width'] = 5;
				}
			} else {
				$rv[$day]['width'] = intval( $rv[$day]['cnt'] / $max * 100);
			}
			if ( $rv[$day]['width'] > 60 ) {
				$rv[$day]['group'] = 'blue';
			} else if ( $rv[$day]['width'] > 30 ) {
				$rv[$day]['group'] = 'green';
			}
		}
		return $rv;
	}
	function getCountCacheMonthly($monYear) {
		$sDate = $monYear.'01';
		$eDate = date('Ymt', strtotime("$sDate"));

		$where = "where cDate between $sDate and  $eDate";
		$query = "select cDate, sum(count) as cnt from MadCounterCache $where group by cDate";
		$q = new Q($query);
		$tuple = $q->toArray();
		$rv = array();
		foreach( $tuple as $row ) {
			extract($row);
			$day = intval(substr($cDate, -2));
			$rv[$day] = $cnt;
		}
		return $rv;
	}
	function getId() {
		return $this->sess->id;
	}
	function ins() {
		$ip = $_SERVER['REMOTE_ADDR'];
		$referer = $this->getReferer();
		$agent = 'Direct Access';
		if ( ! empty( $_SERVER['HTTP_USER_AGENT'] ) ) {
			$agent = $_SERVER['HTTP_USER_AGENT'];
		}

		$values = compact('ip','referer','agent');

		$set = new MadSet($values);
		$query = "insert into $this->table $set";
		$q = new Q($query);
		if ( $q->rows() > 0 ) {
			$this->sess->id = $q->getInsertId();
		} else {
			print 'Counter Error occured';
		}
	}
	function getTotalToday() {
		$sDate = date("Ymd");
		$eDate = date("Ymd",strtotime("+1 day"));
		$todayRange = "wDate between $sDate and $eDate";
		return Q::total($this->table, $todayRange);
	}
	function getTotal(){
		return Q::total($this->table);
	}
	private function getReferer() {
		if( empty( $_SERVER['HTTP_REFERER'] ) ) {
			$referer = 'direct connected';
		} else {
			$referer = $_SERVER['HTTP_REFERER'];
		}
		return $referer;
	}
	function __toString() {
		return '';
	}
}
