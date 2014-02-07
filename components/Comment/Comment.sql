create table Comment (
	no integer unsigned auto_increment primary key,
	rel_no mediumint unsigned,
	id varchar(42) not null,
	pw varchar(42) default 'logged',
	contents text,
	w_date datetime,
	points smallint unsigned default 100
);
