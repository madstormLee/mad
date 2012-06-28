create table MadHistory (
	no int unsigned auto_increment primary key,
	id varchar(42),
	section varchar(42),
	contents text,
	date_s datetime,
	date_e datetime
);
