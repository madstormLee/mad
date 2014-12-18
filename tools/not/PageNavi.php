<?
class PageNavi {
	private $rowPerPage;
	private $maxPage;
	private $total;
	private $view;

	function __construct($total, $rowPerPage, $maxPage) {
		$this->total = $total;
		$this->rowPerPage = $rowPerPage;
		$this->maxPage = $maxPage;
		$this->view = dirname(__file__).'/../views/pageNavi.html';
		$this->currentPage = $this->getCurrentPage();
	}
	function setView($view){
		$this->view = $view;
	}
	function getLimit() {
		$currentPage = $this->currentPage;
		$rowPerPage = $this->rowPerPage;
		$limitStart = ($currentPage-1) * $rowPerPage;
		$rv = "limit $limitStart, $rowPerPage";
		return $rv;
	}
	private function getCurrentPage() {
		$page = 1;
		if( ! empty($_GET['page']) && intval($_GET['page']) ) {
			$page = $_GET['page'];
		}
		return $page;
	}
	function __toString(){
		$currentPage = $this->currentPage;
		$total = $this->total;
		$rowPerPage = $this->rowPerPage;
		$maxPage = $this->maxPage;
		if ($total == 0) return '';

		//총 페이지 수
		$lastPage = ceil($total / $rowPerPage);

		//total_paget_block
		$total_page_block = ceil($lastPage / $maxPage);
		$current_block = ceil($currentPage / $maxPage);

		//start & end page
		$start_page = (($current_block -1) * $maxPage) + 1;
		$end_page = ($current_block * $maxPage);

		if($end_page > $lastPage) {
			$end_page = $lastPage;
		}

		$start = ($currentPage - 1) * $maxPage;

		//페이지 갯수
		$pagecount = $total / $maxPage;
		$pagecount3 = (int)$pagecount;

		if($pagecount3 != $pagecount) {
			$pagecount = $pagecount3 + 1;
		}

		$queryString = $_SERVER['QUERY_STRING'];
		$queryString = ereg_replace('&page=[0-9]+','',$queryString);

		if($currentPage != 1) {
			$prev_page = $currentPage - 1;
			$pages[]="<a href='?{$queryString}&page=$prev_page'>&lt; 이전</a>";
		} else {
			$pages[]='<span>&lt 이전</span>';
		}
		if($total == 0) {
			$pages[]=0;
		} else {
			for($i = $start_page; $i <= $end_page; $i++) {
				if($i == $currentPage) {
					$pages[] = "<b>$i</b>";
				} else {
					$pages[] = "<a href='?{$queryString}&page=$i'>$i</a>";
				}
			}
		}
		if ( $currentPage == $lastPage ) {
			$pages[] = "<span>다음 &gt;</span>";
		} else {
			$next_page = $currentPage + 1;
			$pages[] = "<a href='?{$queryString}&page=$next_page'>다음 &gt;</a>";
		}
		$last = count($pages) - 1;
		include $this->view;
		return '';
	}
}
