create table MadMall (
	no integer unsigned auto_increment primary key,
	productName varchar(100) default 'No Product Name',
	viewImage varchar(255),
	serialNo char(20) unique,
	style varchar(100),
	material varchar(40),
	price integer unsigned,
	reserving integer unsigned,
	color varchar(100),
	clothSize varchar(100),
	quantity smallint,
	contents text
);
