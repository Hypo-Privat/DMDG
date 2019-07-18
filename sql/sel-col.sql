SELECT TB.NAME, TB.CREATOR, TB.TBSPACE, TB.REMARKS, TB.CTIME, TB.STATS_TIME, TB.STATISTICS_PROFILE, TB.LASTUSED, 
			TB.ALTER_TIME, TB.COLCOUNT, 
			TDESCRIPTION,  TTYPE,  TREC_ESTIM,  TREC_GROWTH,  TDOMAIN,  TREL_TYPE,  TREL_RULES,  THOUSEKEEPING, 
 			THOUSE_RULES,  TCID,  TCID_RULES,  TUSE_UCC,  TUSE_DWH,  TUSE_ODS,  TUSE_CWF,  TUSE_IWF, 
 			TUSE_OWF,  TUSE_DEP_MANAGER,  TENTITY_DESCRIPRION , TOWNER 
  FROM SYSIBM.SYSTABLES AS TB LEFT OUTER JOIN SYSIBM.SYSTABLESPACES AS TS 
  		ON TB.TBSPACE = TS.TBSPACE, 
     ( SELECT *
      FROM DB2INST1.TDOCTAB 
      WHERE TBNAME = 'EMPLOYEE' 
      )  
  WHERE TB.NAME = 'EMPLOYEE'  
  and TTIMESTAMP = (SELECT  MAX(TTIMESTAMP)
      FROM TDOCTAB 
      WHERE TBNAME = 'EMPLOYEE' 
      )  
;

 SELECT NAME, CREATOR, TBSPACE, REMARKS, 
                  CTIME, STATS_TIME, STATISTICS_PROFILE,LASTUSED,    ALTER_TIME, COLCOUNT 
			   ,  TDESCRIPTION,  TTYPE,  TREC_ESTIM,  TREC_GROWTH,  TDOMAIN,  TREL_TYPE,  TREL_RULES,  THOUSEKEEPING, 
 			      THOUSE_RULES,  TCID,  TCID_RULES,  TUSE_UCC,  TUSE_DWH,  TUSE_ODS,  TUSE_CWF,  TUSE_IWF, 
 			      TUSE_OWF,  TUSE_DEP_MANAGER,  TENTITY_DESCRIPRION , TOWNER , TTIMESTAMP
 			      from 
        ( SELECT TB.NAME, TB.CREATOR, TB.TBSPACE, TB.REMARKS, 
                    TB.CTIME, TB.STATS_TIME, TB.STATISTICS_PROFILE, TB.LASTUSED, 
			        TB.ALTER_TIME, TB.COLCOUNT FROM SYSIBM.SYSTABLES AS TB 
             LEFT OUTER JOIN 
             SYSIBM.SYSTABLESPACES AS TS 
  		     ON TB.TBSPACE = TS.TBSPACE 
  		        WHERE TB.NAME = 'EMPLOYEE') as sys
         left outer join
        ( SELECT tbname, TDESCRIPTION,  TTYPE,  TREC_ESTIM,  TREC_GROWTH,  TDOMAIN,  TREL_TYPE,  TREL_RULES,  THOUSEKEEPING, 
 			      THOUSE_RULES,  TCID,  TCID_RULES,  TUSE_UCC,  TUSE_DWH,  TUSE_ODS,  TUSE_CWF,  TUSE_IWF, 
 			      TUSE_OWF,  TUSE_DEP_MANAGER,  TENTITY_DESCRIPRION , TOWNER , TTIMESTAMP  
 		 FROM DB2INST1.TDOCTAB 
         WHERE TBNAME = 'EMPLOYEE')  as tab
         on tab.tbname = sys.name
     
       ;
       
       
       

SELECT MAX(COL_DATE) from  FROM TDOCCOL WHERE COL_TBNAME = 'SEMINAR' ;
      
SELECT distinct NAME , COLTYPE ,  NULLS, LENGTH, COLNO,
                     COL_KEY, COL_DESCRIPTION ,COL_FORMAT,
                    COL_DEFAULT ,COL_MANDATORY, COL_CID ,COL_INFO
            FROM SYSIBM.SYSCOLUMNS ,
              TDOCCOL
            WHERE TBNAME = 'SEMINAR' 
             and col_name = name           
            union            
            SELECT   NAME , COLTYPE ,  NULLS, LENGTH, COLNO,
            ' ', '', '', '', '', '', ''
                FROM SYSIBM.SYSCOLUMNS  
               WHERE TBNAME = 'EMPLOYEE'
                and name not in (select col_name  
                from  TDOCCOL 
               WHERE  col_TBNAME = 'EMPLOYEE')            
            order by COLNO 
            
            union            
            SELECT   NAME , COLTYPE ,  NULLS, LENGTH, COLNO,
            '', '', ' ', '', '', '', '', '', ''
                FROM SYSIBM.SYSCOLUMNS  , TDOCCOL
                WHERE TBNAME = 'SEMINAR'
                and name <> col_name                   
                order  by 5
         
         
          and name = col_name
            and COL_DATE = (SELECT  MAX(COL_DATE)
                     FROM TDOCCOL  WHERE TBNAME = 'SEMINAR' 
      				)       