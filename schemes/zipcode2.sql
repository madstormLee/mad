create table zipcode (
		seq     int(5)      not null comment '일련번호',
		zipcode varchar(7)  not null comment '우편번호',
		sido    varchar(4)  not null comment '특별시/광역시/도',
		gugun   varchar(15) not null comment '시/구/군',
		dong    varchar(26) not null comment '읍/면/동',
		ri      varchar(45) comment '리/건물명',
		bunji   varchar(17) comment '번지/아파트동/호수',
		constraint zipcode_pk primary key (seq)
		) engine=InnoDB, comment='우편번호';
