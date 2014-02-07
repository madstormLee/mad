create table AdUnit (
	id integer unsigned auto_increment primary key,
	relNo integer unsigned,
	src varchar(255),
	href varchar(255),
	content text,
	points integer unsigned default 0,
	wDate datetime,
	uDate timestamp default current_timestamp on update current_timestamp
);
