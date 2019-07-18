INSERT INTO  "DB2INST1"."TDOCTAB" (
TBNAME ,TDESCRIPTION, TTYPE, TREC_ESTIM, TREC_GROWTH ,TDOMAIN, TREL_TYPE, TREL_RULES 
,THOUSEKEEPING, THOUSE_RULES,TCID, TCID_RULES,TUSE_UCC ,TUSE_DWH,
TUSE_ODS ,TUSE_CWF, TUSE_IWF ,TUSE_OWF ,TUSE_DEP_MANAGER ,TENTITY_DESCRIPRION ) values
('SEMINAR', 'Seminar Veranstaltungen' ,'TTYPE' ,100 ,10 ,'TDOMAIN' 
,'TREL_TYPE' ,' TREL_RULES ' ,'Y' ,' THOUSE_RULES' ,'Y' ,' TCID_RULES' ,'N' ,'Y' ,'N' ,'O' ,'Y ' ,'O' ,'Y' ,'TENTITY_DESCRIPRION text varchar(6000)'
);


INSERT INTO  TDOCTAB(
            TBNAME , TTYPE, TDOMAIN, TREL_TYPE, 
            TREL_RULES ,THOUSEKEEPING, THOUSE_RULES,TCID, TCID_RULES,TUSE_UCC ,TUSE_DWH,
            TUSE_ODS ,TUSE_CWF, TUSE_IWF ,TUSE_OWF ,TUSE_DEP_MANAGER , TDESCRIPRION ,TENTITY_DESCRIPRION , TOWNER ) values
            ('SEMINAR' ,'TTYPE' ,'TDOMAIN' ,'TREL_TYPE' ,'TREL_RULES' ,'Y' ,' THOUSE_RULES       ' ,'Y' ,'TCID_RULE      ' ,'N' ,'' ,'N' ,'O' ,'Y' ,'O' ,'Y' 
            ,'Table' ,'à TENTITY_DESCRIPRION text varchar(6000)' ,'Gert Dorn');

INSERT INTO  "DB2INST1"."TDOCCOL" ( COL_TBNAME, COL_NAME, COL_KEY, COL_DESCRIPTION ,COL_FORMAT, COL_DEFAULT ,COL_MANDATORY, COL_CID ,COL_INFO )
values ('SEMINAR' ,'SEMCODE' ,'PK' ,'Institution' ,'Char' ,'Space' ,'M' ,'Y' ,'COL_INF text varchar(3000)');



INSERT INTO  "DB2INST1"."TDOCVER" ( VER_TBNAME , VER_NR, VER_DESCRIPTION, VER_CHANGE_DATE, VER_CHANGE_NR, VER_RESPONSIBLE)
values ('SEMINAR' ,'V0002' ,'First Change for FREE Projekt' , '2019-07-07' ,'PMS18000' ,'Gert Dorn');

select * from "DB2INST1"."TDOCTAB";

COMMENT ON COLUMN "DB2INST1"."TDOCTAB"."TOWNER" IS 'Name of responsible dataowner';

update TDOCCOL set 
            COL_DESCRIPTION = ' $COL_DESCRIPTION '
, COL_DEFAULT = 'n' , COL_CID= 'k' , COL_INFO = ' $COL_INFO'
            where COL_TBNAME = 'SEMINAR' and COL_NAME ='SEMCODE'
