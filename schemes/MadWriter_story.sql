create table MadWriter_story(
	uid integer unsigned auto_increment primary key,
	rel integer unsigned,
	title varchar(100),
	contents text,
	note text,
	illusts tinyint default 0,
	bgm tinyint default 0
)
