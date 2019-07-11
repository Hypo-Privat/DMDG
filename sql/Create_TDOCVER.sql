--<ScriptOptions statementTerminator=";"/>

DROP TABLE "DB2INST1"."TDOCVER";

CREATE TABLE "DB2INST1"."TDOCVER" (
		"VER_TBNAME" VARCHAR(30 OCTETS) NOT NULL, 
		"VER_NR" VARCHAR(10 OCTETS) NOT NULL, 
		"VER_DESCRIPTION" VARCHAR(50 OCTETS), 
		"VER_CHANGE_DATE" DATE, 
		"VER_CHANGE_NR" VARCHAR(10 OCTETS), 
		"VER_RESPONSIBLE" VARCHAR(30 OCTETS), 
		"VER_TIMESTAMP" CHAR(10 OCTETS)
	)
	ORGANIZE BY ROW
	DATA CAPTURE NONE 
	IN "SDOCVER"
	COMPRESS NO;

COMMENT ON COLUMN "DB2INST1"."TDOCVER"."VER_CHANGE_DATE" IS
'Date of change';

COMMENT ON COLUMN "DB2INST1"."TDOCVER"."VER_CHANGE_NR" IS
'Changenumber o deployment';

COMMENT ON COLUMN "DB2INST1"."TDOCVER"."VER_DESCRIPTION" IS
'Description of change';

COMMENT ON COLUMN "DB2INST1"."TDOCVER"."VER_NR" IS
'Versions Nubmer';

COMMENT ON COLUMN "DB2INST1"."TDOCVER"."VER_RESPONSIBLE" IS
'Person who did this change';

COMMENT ON COLUMN "DB2INST1"."TDOCVER"."VER_TBNAME" IS
'TABLE NAME';

COMMENT ON TABLE "DB2INST1"."TDOCVER" IS
'This Table contain all information of changes on the table which we need to generate the Business Documentation for the users';

