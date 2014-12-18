create table Writer_info(
	id integer unsigned auto_increment primary key,
	userId varchar(16) not null,
	title varchar(100) not null,
	subtitle varchar(100),
	genre varchar(32),
	theme varchar(100),
	plot text
)
