create table Ad (
	no integer unsigned auto_increment primary key,
	adType varchar(40),
	x varchar(7) default 0,
	y varchar(7) default 0,
	width varchar(7) default '100%',
	height varchar(7) default 'auto',
	sDate datetime,
	eDate datetime,
	wDate datetime,
	uDate timestamp default current_timestamp on update current_timestamp
);
