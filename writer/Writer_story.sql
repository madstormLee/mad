create table Writer_story (
	id integer unsigned auto_increment primary key,
	reiId integer unsigned,
	title varchar(100),
	contents text,
	note text,
	illusts tinyint default 0,
	bgm tinyint default 0
)
