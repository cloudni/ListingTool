/*start 2015-04-07*/
drop table if exists `lt_ad_campaign`;
CREATE TABLE `lt_ad_campaign` (
  `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `company_id` INT NOT NULL,
  `status` tinyint(1) not null default 0,
  `is_delete` tinyint(1) not null default 0,
  `type` TINYINT(4) NOT NULL DEFAULT 1,
  `bid_strategy` TINYINT(1) NOT NULL DEFAULT 1,
  `budget` DECIMAL(20,4) NULL DEFAULT 0,
  `target_language` TEXT NOT NULL,
  `target_area` TEXT NOT NULL,
  `start_datetime` INT NOT NULL DEFAULT 0,
  `end_datetime` INT NULL DEFAULT NULL,
  `note` VARCHAR(255) NULL,
  `create_time_utc` INT NULL DEFAULT 0,
  `create_user_id` INT NULL DEFAULT 0,
  `update_time_utc` INT NULL DEFAULT 0,
  `update_user_id` INT NULL DEFAULT 0,
  foreign key (`company_id`) references lt_company (`id`) on delete cascade on update cascade
);

drop table if exists `lt_ad_campaign_schedule`;
CREATE TABLE `lt_ad_campaign_schedule` (
  `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `campaign_id` INT NULL,
  `days` INT NULL,
  `from_hour` CHAR(2) NULL DEFAULT '00',
  `from_minute` CHAR(2) NULL DEFAULT '00',
  `to_hour` CHAR(2) NULL DEFAULT '00',
  `to_minute` CHAR(2) NULL DEFAULT '00',
  `timezone` VARCHAR(255) NULL DEFAULT 'Asia/Shanghai',
  foreign key (`campaign_id`) references lt_ad_campaign (`id`) on delete cascade on update cascade
);

drop table if exists `lt_ad_group`;
CREATE TABLE `lt_ad_group` (
  `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `company_id` INT NOT NULL,
  `campaign_id` INT NULL,
  `status` tinyint(1) not null default 0,
  `is_delete` tinyint(1) not null default 0,
  `default_bid` DECIMAL(20,4) NOT NULL,
  `audenice_list` VARCHAR(255) NULL,
  `keywords` TEXT NULL,
  `note` VARCHAR(255) NULL,
  `create_time_utc` INT NULL DEFAULT 0,
  `create_user_id` INT NULL DEFAULT 0,						
  `update_time_utc` INT NULL DEFAULT 0,
  `update_user_id` INT NULL DEFAULT 0,
  foreign key (`company_id`) references lt_company (`id`) on delete cascade on update cascade,
  foreign key (`campaign_id`) references lt_ad_campaign (`id`) on delete cascade on update cascade
);

drop table if exists `lt_ad_group_placement`;
CREATE TABLE `lt_ad_group_placement` (
  `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `group_id` INT NOT NULL,
  `URL` VARCHAR(500) NOT NULL,
  foreign key (`group_id`) references lt_ad_group (`id`) on delete cascade on update cascade
);

/**********************Create by Tik Begin***********************/
drop table if exists lt_ad_feed;
create table lt_ad_feed
(
   id                   int not null PRIMARY KEY AUTO_INCREMENT,
   feed_name            varchar(255),
   remarketing_url      varchar(100) not null,
   item_id              int not null,
   item_keywords        text,
   item_headline        varchar(100),
   item_sub_headline    varchar(100),
   item_description     varchar(255),
   item_address         varchar(255),
   price                float not null,
   image_url            varchar(200) not null,
   item_category        int,
   sale_price           float not null,
   create_time_utc      datetime,
   create_user_id       int,
   update_time_utc      datetime,
   update_user_id       int,
   primary key (id)
);

drop table if exists lt_ad_ad;
create table lt_ad_ad
(
   id                   int not null PRIMARY KEY AUTO_INCREMENT,
   ad_group_id          int not null,
   feed_id              int not null,
   primary key (id)
);

alter table lt_ad_ad add constraint FK_feed foreign key (feed_id)
      references lt_ad_feed (id) on delete restrict on update restrict;

drop table if exists lt_ad_ad_variation;
create table lt_ad_ad_variation
(
   id                   int not null PRIMARY KEY AUTO_INCREMENT,
   ad_group_id          int not null comment '���������ID',
   ad_id                int not null,
   ad_type              int not null comment '������ͣ�1������ 2��ͼƬ 3�������棩',
   status               tinyint not null comment '״̬',
   headline             varchar(255) not null comment '����',
   headline_colour      char(7) comment '������ɫ',
   headline_backgroundcolour char(7) comment '���ⱳ��ɫ',
   headline_text_size   tinyint comment '���������С',
   price_prefix         varchar(50) comment '�۸�ǰ׺',
   price_prefix_colour  char(7) comment '�۸�ǰ׺��ɫ',
   price_prefix_text_size tinyint comment '�۸�ǰ׺�����С',
   display_url          varchar(100) comment '��ʾ��ַ',
   ad_backgroundcolour  char(7) comment '��汳��ɫ',
   ad_border_colour     char(7) comment '���߿�ɫ',
   ad_name              varchar(255) not null comment '�����',
   is_delete            tinyint(1) not null comment '�߼�ɾ����ǣ�0��δɾ�� 1��ɾ����',
   create_time_utc      datetime,
   create_user_id       int,
   update_time_utc      datetime,
   update_user_id       int,
   primary key (id)
);

alter table lt_ad_ad_variation add constraint FK_ad foreign key (ad_id)
      references lt_ad_ad (id) on delete restrict on update restrict;
/**********************Create by Tik End*************************/
/*end 2015-04-07*/