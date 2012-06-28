create table MadSitemap (
	no smallint unsigned auto_increment primary key,
	controller char(50),
	method char(50) default 'index',
	page_level tinyint unsigned default 200
);
