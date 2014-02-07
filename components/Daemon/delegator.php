#!/data/php/bin/php
<?
include dirName( __file__ ) . '/../px/tools.php'; // ye~ this is weird

/************************** daemonize **************************/
declare(ticks = 1);

function sig_handler($signo) {
	global $db, $isstop;
	switch($signo) {
		case SIGTERM:
		case SIGINT:
		case SIGQUIT:
		case SIGABRT:
			$isstop = 1;
			break;
		default:
	}
}

pcntl_signal(SIGTERM, "sig_handler");
pcntl_signal(SIGINT, "sig_handler");
pcntl_signal(SIGABRT, "sig_handler");
pcntl_signal(SIGQUIT, "sig_handler");

$isstop = 0;

$file = 'data/Svn/delegate.command';
/************************** setting **************************/
while(1){
	if ( ! is_file( $file ) ) {
		sleep(1);
		continue;
	}
	$lines = file( $file );
	foreach( $lines as $line ) {
		$line = trim( $line );
		if ( ! preg_match( '/^svn /', $line ) ) {
			continue;
		}
		$result = `$line`;
		usleep(50000);
	}
	file_put_contents( $file, '' );
	if($isstop) break;
	usleep(200000);
}
