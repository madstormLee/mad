create table MadLog (
	no integer unsigned auto_increment primary key,
	id char(20) not null unique,
	pw char(42) not null,
	name char(20) not null,
	email char(255) not null,
	userLevel tinyint unsigned not null default 255,
	messages tinyint unsigned not null default 0,
	count smallint unsigned not null default 0,
	uDate timestamp default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
	wDate date
)
