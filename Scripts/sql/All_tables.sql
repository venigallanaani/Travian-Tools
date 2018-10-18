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

/* Profile data Storing table */
CREATE TABLE PROFILE_LOGIN_DATA(
	ACCOUNT_ID  VARCHAR(255) UNIQUE NOT NULL,	-- unique identifier for each account
	USER_NAME VARCHAR(255) UNIQUE NOT NULL,		-- user name
	USER_EMAIL VARCHAR(255) UNIQUE NOT NULL,	-- user email address	
	USER_PASS VARCHAR(255) NOT NULL,			-- user password (encrypted)
	USER_HASH VARCHAR(255),						-- random hash value for password reset and account activation.
	USER_CREATE_DATE VARCHAR (55) NOT NULL,		-- Profile create date
	USER_STATUS ENUM('INACTIVE','ACTIVE','RESET'),	-- Status of user
	SKYPE_ID VARCHAR(55),						-- Skype Id of the user
	DISCORD_ID VARCHAR(55),						-- Discord Id of the user
	PHONE_ID VARCHAR(55)						-- Phone number of the user	
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

/* TABLE to STORE Plus Status */
CREATE TABLE PLUS_SUBSCRIPTION_DETAILS(
	SERVER_ID VARCHAR(255) NOT NULL,  			-- Unique Identifier of the server
	GROUP_ID VARCHAR(55) NOT NULL,				-- unique Identifier of the plus subscription group
	OWNER_ID VARCHAR(255) NOT NULL,				-- Account Id of the person paid for the plus subscription
	PLUS_DURATION INT,							-- Duration of subscription of Plus account
	PLUS_PROCESS_STATUS ENUM('INPROCESS','ACTIVE','EXPIRED'),	-- status of the Plus subscription
	PLUS_AMOUNT VARCHAR(55),					-- Amount paid for the plus account
	PLUS_PAYMENT_DATE TIMESTAMP,				-- subscription payment date
	PLUS_PAYMENT_TOKEN VARCHAR(255),			-- Unique payment Identifier
	PLUS_START_DATE TIMESTAMP,					-- subscription start date
	PLUS_END_DATE TIMESTAMP,					-- subscription end date
	FOREIGN KEY (OWNER_ID) REFERENCES PROFILE_LOGIN_DATA (ACCOUNT_ID),
	FOREIGN KEY (SERVER_ID) REFERENCES TRAVIAN_SERVERS (SERVER_ID)	
);


/* Player - server details */
CREATE TABLE PLAYER_PLUS_STATUS(
	ACCOUNT_ID  VARCHAR(255) NOT NULL, -- Account ID for the player
	USER_NM VARCHAR(255) NOT NULL,	-- User Name of the player
	GROUP_ID VARCHAR(55) NOT NULL,  -- PLUS group ID assoicated to the player
	GROUP_NAME VARCHAR(255),		-- Plus group name 
	SERVER_ID VARCHAR(255) NOT NULL, -- Server Id of the group
	PLS_STS BOOLEAN DEFAULT TRUE,  -- PLS activation status
	LDR_STS BOOLEAN DEFAULT FALSE, -- Plus menu leader options
	DEF_STS BOOLEAN DEFAULT FALSE, -- Plus menu DC options
	OFF_STS BOOLEAN DEFAULT FALSE, -- Plus menu OC options
	ART_STS BOOLEAN DEFAULT FALSE, -- Plus menu artifact coordination options
	RES_STS BOOLEAN DEFAULT	FALSE, -- Resource calls menu Status
	WW_STS BOOLEAN DEFAULT FALSE,	-- WW Display Status
	STATUS_DT VARCHAR(255), -- Date of the options updated
	FOREIGN KEY (ACCOUNT_ID) REFERENCES PROFILE_LOGIN_DATA (ACCOUNT_ID),
	FOREIGN KEY (SERVER_ID) REFERENCES TRAVIAN_SERVERS (SERVER_ID)
);

/* table to store the association between the account Id and player profiles and dual details */
CREATE TABLE SERVER_PLAYER_PROFILES (
	SERVER_ID VARCHAR(255) NOT NULL,	-- Unique server identifier
	ACCOUNT_ID  VARCHAR(255) NOT NULL,	-- unique account identifier
	ACCOUNT_NAME VARCHAR(255) NOT NULL, -- Unique account name
	UID INT(11),						-- user Id of your profile in the server
	TRIBE_ID INT(1),					-- Tribe value of the player account
	PROFILE_ID VARCHAR(255) UNIQUE,		-- Pass code to add a new dual and Unique Product ID
	PLAYER_NAME VARCHAR(50),			-- player name in the server
	SITTER_NAME_1 VARCHAR(55),			-- first sitter name
	SITTER_NAME_2 VARCHAR(55),			-- Second sitter name
	CREATE_DT VARCHAR(25),				-- server profile create date
	UPDATE_DT VARCHAR(25),				-- server profile update date
	FOREIGN KEY (SERVER_ID) REFERENCES TRAVIAN_SERVERS (SERVER_ID),
	FOREIGN KEY (ACCOUNT_ID) REFERENCES PROFILE_LOGIN_DATA (ACCOUNT_ID)	
);

/* Player hero details */
CREATE TABLE PLAYER_HERO_DETAILS(
	SERVER_ID VARCHAR(255) NOT NULL,
	GROUP_ID VARCHAR(55),
	PROFILE_ID VARCHAR(255) UNIQUE,
	HERO_NAME VARCHAR(55),	-- hero name same as profile name
	HERO_LVL INT(3),		-- Hero level
	HERO_EXP INT(10),		-- Hero experience value	
	HERO_FS INT(5),			-- Hero fighting strength
	HERO_FS_VALUE varchar(10),	-- Hero fighting strength value
	HERO_OFF INT(5),		-- Hero offense bonus
	HERO_DEF INT(5),		-- Hero defense bonus
	HERO_RES INT(5),		-- Hero resource bonus
	UPDATE_DT VARCHAR(25),	-- Last hero details update date
	FOREIGN KEY (SERVER_ID) REFERENCES TRAVIAN_SERVERS (SERVER_ID),
	FOREIGN KEY (PROFILE_ID) REFERENCES SERVER_PLAYER_PROFILES (PROFILE_ID)
);

/* Player Units Details */
CREATE TABLE PLAYER_TROOPS_DETAILS(
	SERVER_ID VARCHAR(255) NOT NULL,		
	GROUP_ID VARCHAR(55),		
	PROFILE_ID VARCHAR(255) NOT NULL,	-- Pass code to add a new dual
	VID INT(11),			-- Village ID
	VILLAGE VARCHAR(255),	-- Village Name
	TROOPS_TYPE ENUM ('OFFENSE','DEFENSE','SCOUT','SUPPORT','ARTIFACT','NONE') DEFAULT 'NONE',	-- Village Type
	TROOPS_DISPLAY ENUM ('UNHIDE','HIDE') DEFAULT 'UNHIDE',	-- Either to show the hammer or to hide the hammer from Group
	ARTIFACT_LVL ENUM ('SMALL','LARGE','UNIQUE','NONE') DEFAULT 'NONE',
	TSQ_LEVEL INT (2),		-- Tournament Square lvl
	TROOPS_CONS	INT(11),	-- Total consumption of the troops
	UNIT_01 INT(10),		-- Units Count
	UNIT_02 INT(10),
	UNIT_03 INT(10),
	UNIT_04 INT(10),
	UNIT_05 INT(10),
	UNIT_06 INT(10),
	UNIT_07 INT(10),
	UNIT_08 INT(10),
	UNIT_09 INT(10),
	UNIT_10 INT(10),
	FOREIGN KEY (SERVER_ID) REFERENCES TRAVIAN_SERVERS (SERVER_ID),
	FOREIGN KEY (PROFILE_ID) REFERENCES SERVER_PLAYER_PROFILES (PROFILE_ID)	
);

/* Resource Task Creation */
CREATE TABLE RESOURCE_TASKS(
	SERVER_ID VARCHAR(255),					-- SERVER ID
	GROUP_ID VARCHAR(55),					-- GROUP ID in the Plus
	RESOURCE_TASK_ID VARCHAR(255) UNIQUE NOT NULL,			-- Unique Task ID
	TASK_STATUS ENUM ('ACTIVE', 'COMPLETE','DELETE'),	-- STATUS ACTIVE = Visible to all, COMPELETED = Visible to leaders, DELETE = Deleted from list for all
	RESOURCES_AMOUNT_TOTAL INT(11),			-- Total resources needed
	RESOURCES_TYPE ENUM ('WOOD','CLAY','IRON','CROP','ANY'),	-- Preference of resources to be sent
	RESOURCES_RECEIVED INT(11),				-- total received so far
	RESOURCES_RECEIVED_PERCENTAGE VARCHAR(10),	-- total remaninig resources
	RESOURCES_REMAINING INT(11),				-- total remaninig resources
	RESOURCES_VILLAGE_X INT(11),			-- Village X coordinate
	RESOURCES_VILLAGE_Y INT(11),			-- Village Y Coordinate
	RESOURCES_VILLAGE_NAME VARCHAR(55),		-- village name
	RESOURCES_PLAYER_NAME VARCHAR(55),		-- Player name
	CREATED_BY VARCHAR(55),					-- Task creator ID
	TASK_COMMENTS VARCHAR(100),				-- Comments regarding task - visible to the users
	FOREIGN KEY (SERVER_ID) REFERENCES TRAVIAN_SERVERS (SERVER_ID)
	/*FOREIGN KEY (GROUP_ID) REFERENCES PLUS_SUBSCRIPTION_DETAILS (GROUP_ID)*/
);

/* Resource Task Creation */
CREATE TABLE PLAYER_RESOURCE_UPDATE(
	SERVER_ID VARCHAR(255),					-- SERVER ID
	GROUP_ID VARCHAR(55),					-- GROUP ID in the Plus
	RESOURCE_TASK_ID VARCHAR(255) NOT NULL,			-- Unique Task ID
	ACCOUNT_ID VARCHAR(255),				-- ACCOUNT_ID of the player pushing resources
	PLAYER VARCHAR(50),						-- PLAYER NAME on the server
	RESOURCES_PUSHED INT(11),				-- Resources pushed by the player
	RESOURCES_PUSHED_PERCENTAGE	VARCHAR(10),	-- Percentage of resources pushed by the player.	
	FOREIGN KEY (SERVER_ID) REFERENCES TRAVIAN_SERVERS (SERVER_ID),
	FOREIGN KEY (ACCOUNT_ID) REFERENCES PROFILE_LOGIN_DATA (ACCOUNT_ID)	
);

/* Defense Calls */
CREATE TABLE DEFENSE_TASKS(
	SERVER_ID VARCHAR(255),			-- Server ID
	GROUP_ID VARCHAR(255),			-- Group ID
	DEFENSE_CALL_ID VARCHAR(255) UNIQUE NOT NULL,	-- Defense Call ID
	DEFENSE_VILLAGE_X INT(11),		-- X coordinate
	DEFENSE_VILLAGE_Y INT(11),		-- Y Coordinate
	DEFENSE_NEEDED INT(11),			-- Amount of defense needed in crop
	DEFENSE_LAND_TIME VARCHAR(55),	-- Landing time of Defense	
	DEFENSE_TYPE ENUM('DEFEND','SNIPE','STAND','INSERT'),	-- Type of defense
	DEFENSE_PRIORITY ENUM('HIGH','MEDIUM','LOW'),			-- Priority of the Defense
	DEFENSE_STATUS ENUM('ACTIVE','COMPLETE','DELETE'),		-- Defense status
	DEFENSE_CROP ENUM('YES','NO'),	-- Crop needed for the CFD
	DEFENSE_RECEIVED INT(11),		-- Amount of defense received at the moment
	DEFENSE_REMAINING INT(11),		-- Remaining Defense
	DEFENSE_RECEIVED_PERCENTAGE VARCHAR(55),		-- Percentage of defense received	
	DEFENSE_VILLAGE_NAME VARCHAR(55),				-- Name of the Defending Village
	DEFENSE_PLAYER_NAME VARCHAR(55),				-- Name of the Player of defending village
	COMMENTS VARCHAR(255),							-- Comments from the CFD
	CALL_CREATE_BY VARCHAR(55),						-- CFD created by
	CALL_CREATE_DATE VARCHAR(55),					-- CFD Create Date
	CALL_UPDATE_BY VARCHAR(55),						-- CFD last updated by
	CALL_UPDATE_DATE VARCHAR(55),					-- CFD last update date
	FOREIGN KEY (SERVER_ID) REFERENCES TRAVIAN_SERVERS (SERVER_ID)	
);

/* Resource Task Creation */
CREATE TABLE PLAYER_DEFENSE_UPDATE(
	SERVER_ID VARCHAR(255),					-- SERVER ID
	GROUP_ID VARCHAR(55),					-- GROUP ID in the Plus
	DEFENSE_CALL_ID VARCHAR(255) NOT NULL,			-- Unique Task ID
	PROFILE_ID VARCHAR(255),				-- ACCOUNT_ID of the player pushing resources
	PLAYER VARCHAR(50),						-- PLAYER NAME on the server
	VILLAGE_NAME VARCHAR(55),				-- Defense providing village name
	VILLAGE_VID INT(11),					-- VID of the provider village
	DEFENSE_LANDING_TIME VARCHAR(55),		-- Defense landing time
	RESOURCES_PUSHED INT(11),				-- Resources pushed by the player	
	HERO_SENT ENUM('YES','NO'),				-- If hero is being sent with the defense
	TRIBE_ID INT(2),		-- tribe of the player providing defense
	UNIT_01 INT(10),		-- Units Count
	UNIT_02 INT(10),		-- Units values get pulled from the units meta data
	UNIT_03 INT(10),		-- Calcualte the other values based on the tribe_id of the player.	
	UNIT_04 INT(10),
	UNIT_05 INT(10),
	UNIT_06 INT(10),
	UNIT_07 INT(10),
	UNIT_08 INT(10),
	UNIT_09 INT(10),
	UNIT_10 INT(10),
	TROOPS_CONS INT(11),	-- Units Consumption
	UNIT_INF_DEFENSE INT(11),	-- Total Infantry Defense
	UNIT_CAV_DEFENSE INT(11),	-- Total Cavalry Defense
	FOREIGN KEY (SERVER_ID) REFERENCES TRAVIAN_SERVERS (SERVER_ID),
	FOREIGN KEY (DEFENSE_CALL_ID) REFERENCES DEFENSE_TASKS(DEFENSE_CALL_ID) 	
);

/* OPS Details */
CREATE TABLE OFFENSE_PLANS(
	SERVER_ID VARCHAR(255),				-- 
	GROUP_ID VARCHAR (255),
	OFFENSE_PLAN_ID VARCHAR (255),
	PLAN_STATUS ENUM ('DRAFT','ACTIVE','INPROGRESS','COMPLETED'),
	ATT_TYPE ENUM ('REAL','FAKE','CHEIF','OTHER'),
	ATT_ACCOUNT_ID VARCHAR(55),
	ATT_PLAYER VARCHAR (50),
	ATT_VID INT(11),
	ATT_WAVES INT (5),
	ATT_UNIT VARCHAR (5),
	ATT_LAND_TIME VARCHAR(55),
	ATT_START_TIME VARCHAR(55),
	ATT_COMMENTS VARCHAR(255),
	TAR_PLAYER VARCHAR(50),
	TAR_VID INT(11),
	TRAVEL_TIME VARCHAR(55),
	PLAN_CREATE_BY VARCHAR(55),
	PLAN_CREATE_DATE VARCHAR(55),
	PLAN_UPDATE BOOLEAN DEFAULT TRUE,
	PLAN_UPDATE_BY VARCHAR(55),
	PLAN_UPDATE_DATE VARCHAR(55),
	PLAN_DELETE_DATE VARCHAR(55)
);
