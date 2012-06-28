create table message(
	id char(16) not null,
	sender char(16) not null,
	message varchar(255) not null,
	w_date datetime,
	expiredate date
);
