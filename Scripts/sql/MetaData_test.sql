/*METADATA for the entry of the active servers*/
INSERT INTO `travian_servers`(`SERVER_ID`, `SERVER_URL`, `SERVER_VER`, `SERVER_CNTRY`, `SERVER_STATUS`, `SERVER_SRT_DATE`,`TOTAL_DAYS`, `MAPS_TABLE_NAME`, `DIFF_TABLE_NAME`, `SERVER_TIMEZONE`,`TABLE_ID`, `SERVER_UPD_DATE`) 
	VALUES ('ts1comr18','http://ts1.travian.com','ts1','com','active','04-30-2018',46, 'MAPS_COM', 'DIFF_COM', 'America/New_York','','06-16-2018');
INSERT INTO `travian_servers`(`SERVER_ID`, `SERVER_URL`, `SERVER_VER`, `SERVER_CNTRY`, `SERVER_STATUS`, `SERVER_SRT_DATE`,`TOTAL_DAYS`, `MAPS_TABLE_NAME`, `DIFF_TABLE_NAME`, `SERVER_TIMEZONE`,`TABLE_ID`, `SERVER_UPD_DATE`) 
	VALUES ('ts3usr17','http://ts3.travian.us','ts3','us','active','04-15-2018',60, 'MAPS_US', 'DIFF_US', 'America/New_York','','06-16-2018');
INSERT INTO `travian_servers`(`SERVER_ID`, `SERVER_URL`, `SERVER_VER`, `SERVER_CNTRY`, `SERVER_STATUS`, `SERVER_SRT_DATE`,`TOTAL_DAYS`, `MAPS_TABLE_NAME`, `DIFF_TABLE_NAME`, `SERVER_TIMEZONE`,`TABLE_ID`, `SERVER_UPD_DATE`) 
	VALUES ('ts1usr12','http://ts1.travian.us','ts1','us','active','08-01-2018',52, 'MAPS_US', 'DIFF_US', 'America/New_York','','09-22-2018');
	
	

/* Ops Plan Meta Data */
INSERT INTO `OFFENSE_PLANS` VALUES ('ts1comr13','38','3739','PLAN1','DRAFT','TestPlan','Admin','10/10/2018 23:59:59','Admin','10/10/2018 23:59:59',1,'');

INSERT INTO `OFFENSE_TASKS` VALUES ('3739','wave1','REAL','3433','Tyr','Delta',-213,37,4,'CAT','20/10/2018 21:59:59','19/10/2018 23:59:59','LAUNCHED','Crop Lock it','Pig','02.Pig',-25,-127,'','');
INSERT INTO `OFFENSE_TASKS` VALUES ('3739','wave2','FAKE','3433','Tyr','Delta',-213,37,4,'CAT','20/10/2018 22:59:59','19/10/2018 23:59:59','LAUNCHED','','Pig','09.Pig',-21,-127,'','');
INSERT INTO `OFFENSE_TASKS` VALUES ('3739','wave3','REAL','3433','Bank','C10',-37,-128,4,'CAT','20/10/2018 19:59:59','19/10/2018 23:59:59','PENDING','Crop Lock it','Pig','02.Pig',-25,-127,'','');
INSERT INTO `OFFENSE_TASKS` VALUES ('3739','wave4','FAKE','3433','Bank','C10',-37,-128,4,'CAT','20/10/2018 22:59:59','19/10/2018 23:59:59','PENDING','','sativarious','00.Zed',-12,-129,'','');


