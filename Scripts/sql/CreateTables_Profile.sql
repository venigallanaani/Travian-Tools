/*CREATES SCHEMA FOR TOOLS*/
CREATE SCHEMA `TRAVIANTOOLS`;

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

/* TABLE to STORE Plus Status */
CREATE TABLE PLUS_SUBSCRIPTION_DETAILS(
	SERVER_ID VARCHAR(255) NOT NULL,  			-- Unique Identifier of the server
	GROUP_ID VARCHAR(55) NOT NULL,				-- unique Identifier of the plus subscription group
	GROUP_NAME VARCHAR(255),					-- Name of the group
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
	HERO_FS_VALUE INT(10),	-- Hero fighting strength value
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
	X INT(11),	-- Village Xcor
	Y INT(11),  -- Village Ycor
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






