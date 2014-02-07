<?
class MadRss implements IteratorAggregate {
	private $url = '';
	function __construct( $url ) {
		$this->url = $url;
	}
	function getIterator() {
		$rss = simplexml_load_file( $this->url );
		if ( $rss->channel->item ) {
			return $rss->channel->item;
		}
		return new MadData;
	}
}
