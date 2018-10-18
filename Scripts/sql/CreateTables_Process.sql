/*CREATES SCHEMA FOR TOOLS*/
CREATE SCHEMA `TRAVIANTOOLS`;

/* Sequence TABLE - Generates Sequence for different tasks in the process*/
CREATE TABLE TRAVIANTOOLS.SEQUENCE_TABLE (
  SEQUENCE_ID INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (SEQUENCE_ID)
);

/*Sequence Table Insert Initial Data*/
INSERT INTO SEQUENCE_TABLE VALUES (1);

/* SEQUENCE LIST  -- Creates a hexa value for the sequence number and store the log messages related to it*/
CREATE TABLE SEQUENCE_LIST(
	SEQUENCE_ID INT NOT NULL,			-- Sequence number
	SEQUENCE_ENCRYPT_ID VARCHAR(255), 	-- hexa coded sequence number
	SEQUENCE_CREATE_DT VARCHAR(255),	-- sequence created date
	SEQUENCE_USAGE VARCHAR(255)			-- Sequence usage log
);

/*Table to store travian server details*/
CREATE TABLE TRAVIAN_SERVERS(
	SERVER_ID VARCHAR (25) PRIMARY KEY,		-- unique server Id to identify the server
	SERVER_URL VARCHAR (250) NOT NULL,		-- travian URL for the server
	SERVER_VER VARCHAR (10) NOT NULL,		-- version of the server ( ts1, ts2 etc..)
	SERVER_CNTRY VARCHAR (10) NOT NULL,		-- Country or language of the server (us, com, uk, fr etc...)
	SERVER_STATUS VARCHAR (10) NOT NULL,	-- Status of the server (active or expired)
	SERVER_SRT_DATE VARCHAR (10) NOT NULL,	-- Start date of the server
	TOTAL_DAYS	INT (3) NOT NULL,			-- Dates completed in the server
	MAPS_TABLE_NAME VARCHAR (20) NOT NULL,	-- Table name of the maps data (maps_ts1_us, maps_ts1_com .... )
	DIFF_TABLE_NAME VARCHAR (20) NOT NULL,	-- Table name of the maps diff data (diff_ts1_us, diff_ts1_com .... )
	SERVER_TIMEZONE VARCHAR (55) NOT NULL,	-- Timezone of the server	
	TABLE_ID VARCHAR (20),					-- Table ID for the latest version of the maps data
	SERVER_UPD_DATE VARCHAR(10) NOT NULL	-- Last date of maps data update
);

/*Storing the list of the map details related to different servers*/
CREATE TABLE MAPS_TABLE_LIST(
	TABLE_ID VARCHAR(25) PRIMARY KEY,	-- 
	SERVER_ID VARCHAR (25) NOT NULL,	-- unique server Id to identify the server
	SERVER_VER VARCHAR (10) NOT NULL,	-- version of the server ( ts1, ts2 etc..) 
	SERVER_CNTRY VARCHAR (10) NOT NULL,	-- Country or language of the server (us, com, uk, fr etc...)
	MAP_CRT_DATE TIMESTAMP,				-- TableId creation timestamp
	MAP_UPD_DATE TIMESTAMP,				-- TableId last update timestamp
	MAP_STATUS VARCHAR(50),				-- Status of the data related to that tableId (ACTIVE or truncated)
	FOREIGN KEY (SERVER_ID) REFERENCES TRAVIAN_SERVERS (SERVER_ID)
);

/* Basic Table creating table*/
CREATE TABLE MAPS_US(
	SERVER_ID VARCHAR (25) NOT NULL,	-- Unique Identifier of the server 
	WORLDID INT(11),					-- Unique identifier of the village tile in the server
	X INT(11),							-- X coordinate of the tile in the server
	Y INT(11),							-- Y coordinate of the tile in the server
	ID INT(11),							-- Identifer of the village -- unknown or unused at this point
	VID INT(11),						-- unique identifier of the village
	VILLAGE VARCHAR(50),				-- Village name
	UID INT(11),						-- Unique Identifier of the player
	PLAYER VARCHAR(50),					-- Player name
	AID INT(11),						-- unique Identifier of the alliance
	ALLIANCE VARCHAR(50),				-- Alliance name 
	POPULATION INT(11),					-- Population of the village
	TABLE_ID VARCHAR(20),				-- Table ID for current version of the map data
	UPDATETIME VARCHAR(25),				-- Maps data update time
	FOREIGN KEY (SERVER_ID) REFERENCES TRAVIAN_SERVERS (SERVER_ID)
);


/*Diff Maps table*/
CREATE TABLE DIFF_US(
	SERVER_ID VARCHAR(255) NOT NULL,	-- Unique Identifier of the server
	X INT(11),							-- X coordinate of the tile in the server
	Y INT(11),							-- Y coordinate of the tile in the server
	UID INT(11),						-- Unique Identifier of the player	
	PLAYER VARCHAR(50),					-- Player name
	VID INT(11),						-- unique identifier of the village
	VILLAGE VARCHAR(50),				-- Village name
	POPULATION INT(11),					-- Population of the village
	DIFF_POP INT(5),					-- Difference in the population of last 7 days
	AID INT(5),							-- unique Identifier of alliance
	ALLIANCE VARCHAR(50),				-- Alliance name
	TABLE_ID VARCHAR(55),				-- Table ID for current version of the map data
	CREATE_DT VARCHAR(25),				-- Village create date
	CHANGE_DT VARCHAR(25),				-- Village owner change date
	UPDATE_DT VARCHAR(25),				-- last diff data update date
	DIFF_NUM INT(5),					-- Diff number to see how many days since last pop change
	STATUS VARCHAR(55),					-- Status of the village (active, inactive, under-attack)
	FOREIGN KEY (SERVER_ID) REFERENCES TRAVIAN_SERVERS (SERVER_ID)
);

/* Player details on the servers */
CREATE TABLE PLAYER_DETAILS (
	SERVER_ID VARCHAR(255) NOT NULL,
	ACCOUNT_ID VARCHAR (255),
	UID INT(11),
	PLAYER VARCHAR(50),
	RACE_ID INT(1),
	RACE VARCHAR(10),
	RANK INT(11),
	POPULATION INT(11),
	VILLAGENUM INT (10),
	AID INT(5),
	ALLIANCE VARCHAR(50),
	POP_DIFF INT(5),
	VILLAGE_DIFF INT(5),
	STATUS VARCHAR(55),
	CREATE_DT VARCHAR(25),
	UPDATE_DT VARCHAR(25),
	FOREIGN KEY (SERVER_ID) REFERENCES TRAVIAN_SERVERS (SERVER_ID),
	FOREIGN KEY (ACCOUNT_ID) REFERENCES PROFILE_LOGIN_DATA (ACCOUNT_ID)		
);

CREATE TABLE ALLIANCE_DETAILS (
	SERVER_ID VARCHAR(255), 
	AID INT(5),
	ALLIANCE VARCHAR(50),
	RANK INT(11),
	PLAYER_NUM INT(11),
	POPULATION INT(11),
	VILLAGE_NUM INT (10),
	POP_DIFF INT(5),
	VILLAGE_DIFF INT(5),
	CREATE_DT VARCHAR(25),
	UPDATE_DT VARCHAR(25),
	FOREIGN KEY (SERVER_ID) REFERENCES TRAVIAN_SERVERS (SERVER_ID)
);

CREATE TABLE TICKET_DETAILS(
	TICKET_ID VARCHAR(255),					-- Unique Identifier for each ticket
	ACCOUNT_ID VARCHAR (255),					-- Account created the ticket	
	TICKET_SUBJECT VARCHAR (255),				-- Subject of the ticket
	TICKET_TYPE ENUM ('DEFECT','SUGGEST',''),	-- Suggest or defect, disctinction
	TICKET_EMAIL VARCHAR(255),					-- Contact email to get other details about ticket
	TICKET_DATA VARCHAR(2048),					-- The text are of the ticket description
	TICKET_STATUS ENUM ('NEW','PROGRESS','COMPLETE','PENDING'),		-- Status of the ticket
	TICKET_CREATE_DATE VARCHAR(255),
	TICKET_UPDATE_DATE VARCHAR(255)
);