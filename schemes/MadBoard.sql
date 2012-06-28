create table MadBoard (
	no integer unsigned auto_increment primary key,
	title varchar(255) not null,
	content text not null,
	id char(42) not null,
	wDate datetime not null,
	uDate timestamp default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
	files smallint unsigned default 0,
	comments smallint unsigned default 0,
	points mediumint unsigned default 100,
	articleLevel tinyint unsigned default 255
);
