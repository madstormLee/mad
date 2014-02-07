#!/data/php/bin/php
<?
/* when you wanna kill this program :
 *
 * killall -9 itemsaver.php
 * OR:
 * killall -9 php
 * 
 */

error_reporting( E_ALL ^ E_STRICT );

require_once "System/Daemon.php";
include "px/tools.php";

MadAutoload::getInstance()->add( PROJECT_ROOT . 'models' );

MadSession::start();
MadConfig::add( 'configs/daemon.json' );

$runmode = array(
		'no-daemon' => false,
		'help' => false,
		'write-initd' => false,
		);

// Scan command line attributes for allowed arguments
foreach ($argv as $k=>$arg) {
	if (substr($arg, 0, 2) == '--' && isset($runmode[substr($arg, 2)])) {
		$runmode[substr($arg, 2)] = true;
	}
}

// Help mode. Shows allowed argumentents and quit directly
if ($runmode['help'] == true) {
	echo 'Usage: '.$argv[0].' [runmode]' . "\n";
	echo 'Available runmodes:' . "\n";
	foreach ($runmode as $runmod=>$val) {
		echo ' --'.$runmod . "\n";
	}
	die();
}

$options = array(
		'appName' => 'itemsaver',
		'appDir' => dirname(__FILE__),
		'appDescription' => 'save happyitem from happyitem_log',
		'authorName' => 'Madstorm. lee.',
		'authorEmail' => 'madstorm.lee@gmail.com',
		'sysMaxExecutionTime' => '0',
		'sysMaxInputTime' => '0',
		'sysMemoryLimit' => '1024M',
		'appRunAsGID' => 501,
		'appRunAsUID' => 512,
		);

System_Daemon::setOptions( $options );

// This program can also be run in the forground with runmode --no-daemon
if (!$runmode['no-daemon']) {
	// Spawn Daemon
	System_Daemon::start();
}


// With the runmode --write-initd, this program can automatically write a
// system startup file called: 'init.d'
// This will make sure your daemon will be started on reboot
if (!$runmode['write-initd']) {
	System_Daemon::info('not writing an init.d script this time');
} else {
	if (($initd_location = System_Daemon::writeAutoRun()) === false) {
		System_Daemon::notice('unable to write init.d script');
	} else {
		System_Daemon::info(
				'sucessfully written startup script: %s',
				$initd_location
				);
	}
}

// This variable gives your own code the ability to breakdown the daemon:
$runningOkay = true;


$cnt = 1;
$saver = new HappyitemSaver;

while (!System_Daemon::isDying() && $runningOkay ) {
	// if ( $cnt >= 2 ) break;
	// $mode = '"'.(System_Daemon::isInBackground() ? '' : 'non-' ).  'daemon" mode'; 
	if ( $cnt % 60 == 0 ) {
		System_Daemon::info('{appName} running at %s %s times', date('Y-m-d H:i'), $cnt);
	}

	$runningOkay = true;

	if ( ! $runningOkay) {
		System_Daemon::err('parseLog() produced an error, so this will be my last run');
	}

	$saver->dispense();

	System_Daemon::iterate( 1 );

	++$cnt;
}

// Shut down the daemon nicely
// This is ignored if the class is actually running in the foreground
System_Daemon::stop();
