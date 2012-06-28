create table MadGallery_temp (
	no integer unsigned auto_increment primary key,
	relNo integer unsigned not null,
	title varchar(255) not null,
	content text not null,
	id char(42) not null,
	image varchar(255),
	thumb varchar(255),
	wDate datetime not null,
	uDate timestamp default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
	download mediumint unsigned default 0,
	comments smallint unsigned default 0,
	points mediumint unsigned default 100
);
