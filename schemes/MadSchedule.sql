create table MadSchedule (
	no smallint unsigned auto_increment primary key,
	s_date date not null,
	e_date date not null,
	s_time time not null,
	e_time time not null,
	title varchar(255),
	contents varchar(255)
);
