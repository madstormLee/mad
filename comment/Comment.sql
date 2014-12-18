create table Comment (
	id integer unsigned auto_increment primary key,
	boardId mediumint unsigned,
	userId varchar(42) not null,
	password varchar(42) default 'logged',
	contents text,
	wDate datetime,
	points smallint unsigned default 100
);
