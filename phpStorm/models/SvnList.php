<?
class SvnList implements IteratorAggregate {
	function getIterator() {
		$data = new MadData( array(
				'phpStorm' => array(
					'name' => 'PhpStorm',
					'label' => 'phpStorm전체',
					'location' => ROOT,
					'update' => 'svn update',
					'commit' => 'svn commit',
					)
				) );
		return $data;
	}
}
