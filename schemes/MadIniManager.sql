create table MadIniManager (
		no integer unsigned auto_increment primary key,
		iniDir varchar(255) not null,
		fileName varchar(255) not null,
		data text not null,
		brief text default '',
		wDate datetime
)
