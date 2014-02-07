drop table if exists contract;

create table Contract (
	no integer unsigned auto_increment primary key,
	w_date datetime,
	company varchar(50),
	tel char(11),
	client varchar(50),
	google_id varchar(255),
	google_pw varchar(50),
	URL varchar(255),
	firm_address varchar(255),
	firm_name varchar(50),
	firm_id char(50),
	firm_chief varchar(20)
);
