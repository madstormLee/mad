create table MadBlog (
	no integer unsigned auto_increment primary key,
	title varchar(255) not null,
	contents text not null,
	article varchar(255),
	tags varchar(255),
	write_time datetime,
	update_time datetime
);
