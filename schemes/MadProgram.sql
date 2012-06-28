create table MadLevels (
	no integer unsigned auto_increment primary key,
	program_name varchar(100) not null,
	action_name varchar(100) default '',
	limit_level tinyint unsigned not null default 200
);
