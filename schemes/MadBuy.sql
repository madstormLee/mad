create table MadBuy (
	no mediumint unsigned auto_increment primary key,
	buyDate date not null,
	way tinyint unsigned not null default 0,
	article varchar(40) not null default 0,
	quantity smallint unsigned not null default 1,
	cost integer unsigned not null default 0
);
