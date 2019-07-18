
            
            select  NAME ,   TBNAME , TEXT , DEFINER  , 'deve' 
            from   sysibm.systriggers
            WHERE definer = 'DB2INST1'
            order by definer , TBName 