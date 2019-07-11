SELECT  NAME, CREATOR, TBSPACE, REMARKS,
                    CTIME, STATS_TIME, STATISTICS_PROFILE,LASTUSED,    ALTER_TIME, COLCOUNT ,'deve'
            from
                 ( SELECT TB.NAME, TB.CREATOR, TB.TBSPACE, TB.REMARKS,
                          TB.CTIME, TB.STATS_TIME, TB.STATISTICS_PROFILE, TB.LASTUSED,
                            TB.ALTER_TIME, TB.COLCOUNT 
                    FROM SYSIBM.SYSTABLES AS TB
                    LEFT OUTER JOIN
                    SYSIBM.SYSTABLESPACES AS TS
                    ON TB.TBSPACE = TS.TBSPACE
                    WHERE TB.CREATOR = 'DB2INST1') as sys
                    order by Name  
                    ;
                    
                    
                    SELECT NAME, CREATOR, TBSPACE, REMARKS,
                    CTIME, STATS_TIME, STATISTICS_PROFILE,LASTUSED,    ALTER_TIME, COLCOUNT
                 ,  TDESCRIPTION,  TTYPE,  TREC_ESTIM,  TREC_GROWTH,  TDOMAIN,  TREL_TYPE,  TREL_RULES,  THOUSEKEEPING,
                    THOUSE_RULES,  TCID,  TCID_RULES,  TUSE_UCC,  TUSE_DWH,  TUSE_ODS,  TUSE_CWF,  TUSE_IWF,
                    TUSE_OWF,  TUSE_DEP_MANAGER,  TENTITY_DESCRIPTION , TOWNER , TTIMESTAMP
            from
                 ( SELECT TB.NAME, TB.CREATOR, TB.TBSPACE, TB.REMARKS,
                          TB.CTIME, TB.STATS_TIME, TB.STATISTICS_PROFILE, TB.LASTUSED,
                            TB.ALTER_TIME, TB.COLCOUNT FROM SYSIBM.SYSTABLES AS TB
                    LEFT OUTER JOIN
                    SYSIBM.SYSTABLESPACES AS TS
                    ON TB.TBSPACE = TS.TBSPACE
                    WHERE TB.NAME = 'SEMINAR') as sys
            left outer join
            (   SELECT tbname, TDESCRIPTION,  TTYPE,  TREC_ESTIM,  
                     TREC_GROWTH,  TDOMAIN,  TREL_TYPE,  TREL_RULES,  THOUSEKEEPING,
                     THOUSE_RULES,  TCID,  TCID_RULES,  TUSE_UCC,  TUSE_DWH,  TUSE_ODS,  TUSE_CWF,  TUSE_IWF,
                     TUSE_OWF,  TUSE_DEP_MANAGER,  TENTITY_DESCRIPTION , TOWNER , TTIMESTAMP
                FROM TDOCTAB
                WHERE TBNAME = 'SEMINAR'
                order by TTIMESTAMP desc )  as tab
                on tab.tbname = sys.name ;
                
                
               SELECT distinct NAME , COLTYPE ,  NULLS, LENGTH, COLNO, REMARKS ,
                     COL_KEY, COL_DESCRIPTION ,COL_FORMAT,
                    COL_DEFAULT ,COL_MANDATORY, COL_CID ,COL_INFO , TBNAME , COL_NAME, COL_Timestamp
            FROM SYSIBM.SYSCOLUMNS,  TDOCCOL
            WHERE TBNAME = 'SEMINAR' 
             and col_name = name         
             and substr(COL_Timestamp , 1, 16) = (select max(substr(COL_Timestamp , 1, 16))               
               from  TDOCCOL   WHERE  col_TBNAME = 'SEMINAR'  )   
           
            union            
            SELECT DISTINCT  NAME , COLTYPE ,  NULLS, LENGTH, COLNO,
            '', '', '', '', '', '', '', '', TBNAME , ''  , current_timestamp
                FROM SYSIBM.SYSCOLUMNS  
               WHERE TBNAME = 'SEMINAR'
                and name not in (select col_name                
                from  TDOCCOL 
               WHERE  col_TBNAME = 'SEMINAR'    )      
                
              order by  COLNO asc  ;
              
              
              