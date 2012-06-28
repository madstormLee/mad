drop table if exists `MadCounterCache`;
create table MadCounterCache (
		no integer unsigned auto_increment primary key,
		cDate date,
		cHour tinyint unsigned,
		count integer unsigned default 0
		);
