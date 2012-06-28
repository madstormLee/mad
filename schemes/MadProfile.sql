create table MadProfile (
	no integer unsigned auto_increment primary key,
	id varchar(42) not null,
	section varchar(42) not null,
	img_src varchar(255) not null,
	free_speech text not null
);
