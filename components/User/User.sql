create table User (
	id integer unsigned auto_increment primary key,
	userId char(20) not null unique,
	userPassword char(42) not null,
	userLevel tinyint unsigned not null default 255,
	name char(20) not null,
	email char(255) not null,
	uDate timestamp default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
	wDate date
)
