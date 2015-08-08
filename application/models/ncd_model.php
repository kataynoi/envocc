<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Report model
 *

 *
 */

class Ncd_model extends CI_Model
{
    public $hospcode;
    public $year;


    public function get_ncdscreen($year)
    {
        $rs = $this->db
            ->select('b.distid as id,c.distname as name ',false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year-1)."10',1,0)) as m10",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year-1)."11',1,0)) as m11",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year-1)."12',1,0)) as m12",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."01',1,0)) as m01",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."02',1,0)) as m02",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."03',1,0)) as m03",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."04',1,0)) as m04",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."05',1,0)) as m05",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."06',1,0)) as m06",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."07',1,0)) as m07",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."08',1,0)) as m08",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."09',1,0)) as m09",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m') BETWEEN '".($year-1)."10' AND '".($year)."09',1,0)) as total",false)

            ->join('co_office b','a.pcucode=b.off_id')
            ->join('co_district c' ,'b.distid=c.distid')
            ->group_by('b.distid')
            ->get('person_ncd a')
            ->result();
        //echo $this->provis->last_query();
        return $rs;
    }
    public function get_ncdscreen_by_age($year,$s,$e)
    {
        $rs = $this->db
            ->select('b.distid as id,c.distname as name ',false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year-1)."10',1,0)) as m10",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year-1)."11',1,0)) as m11",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year-1)."12',1,0)) as m12",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."01',1,0)) as m01",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."02',1,0)) as m02",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."03',1,0)) as m03",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."04',1,0)) as m04",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."05',1,0)) as m05",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."06',1,0)) as m06",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."07',1,0)) as m07",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."08',1,0)) as m08",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."09',1,0)) as m09",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m') BETWEEN '".($year-1)."10' AND '".($year)."09',1,0)) as total",false)
            ->where("AGE BETWEEN '".$s."' AND '".$e."' ",'',false)
            ->join('co_office b','a.pcucode=b.off_id')
            ->join('co_district c' ,'b.distid=c.distid')
            ->group_by('b.distid')
            ->get('person_ncd a')
            ->result();
        //echo $this->provis->last_query();
        return $rs;
    }
    public function get_ncdscreen_by_amp($year,$amp)
    {
        $rs = $this->db
            ->select('a.pcucode as id,b.off_name as name',false)

            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year-1)."10',1,0)) as m10",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year-1)."11',1,0)) as m11",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year-1)."12',1,0)) as m12",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."01',1,0)) as m01",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."02',1,0)) as m02",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."03',1,0)) as m03",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."04',1,0)) as m04",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."05',1,0)) as m05",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."06',1,0)) as m06",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."07',1,0)) as m07",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."08',1,0)) as m08",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."09',1,0)) as m09",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m') BETWEEN '".($year-1)."10' AND '".($year)."09',1,0)) as total",false)

            ->where('b.distid',$amp)
            ->join('co_office b','a.pcucode=b.off_id')
            //->join('co_district c' ,'b.distid=c.distid')
            ->group_by('a.pcucode')
            ->get('person_ncd a')
            ->result();
        //echo $this->provis->last_query();
        return $rs;
    } public function get_ncdscreen_by_amp_age($year,$amp,$s,$e)
    {
        $rs = $this->db
            ->select('a.pcucode as id,b.off_name as name',false)

            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year-1)."10',1,0)) as m10",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year-1)."11',1,0)) as m11",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year-1)."12',1,0)) as m12",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."01',1,0)) as m01",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."02',1,0)) as m02",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."03',1,0)) as m03",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."04',1,0)) as m04",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."05',1,0)) as m05",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."06',1,0)) as m06",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."07',1,0)) as m07",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."08',1,0)) as m08",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m')='".($year)."09',1,0)) as m09",false)
            ->select("SUM(IF(DATE_FORMAT(a.DATE_EXAM,'%Y%m') BETWEEN '".($year-1)."10' AND '".($year)."09',1,0)) as total",false)

            ->where('b.distid',$amp)
            ->where("AGE BETWEEN '".$s."' AND '".$e."' ",'',false)
            ->join('co_office b','a.pcucode=b.off_id')
            //->join('co_district c' ,'b.distid=c.distid')
            ->group_by('a.pcucode')
            ->get('person_ncd a')
            ->result();
        //echo $this->provis->last_query();
        return $rs;
    }
    // ###################### Chronic ###############

   public function get_chronic($as,$ae,$group_id){
       $rs = $this->db
           ->select("c.distid as id ,c.distname as name,count(*) as total,SUM(IF(a.SEX='1',1,0)) as M,SUM(IF(a.SEX='2',1,0)) as F",false)
           ->where('a.GROUPCODE',$group_id)
            ->where('a.DISCHAR','9' )
           ->where("TYPEAREA in('1','3')")
           ->where("AGE BETWEEN '".$as."' AND '".$ae."' ",'',false)
           ->join('co_office b','HOSPCODE=b.off_id')
           ->join('co_district c' ,'b.distid=c.distid')
           ->group_by('b.distid')
           ->get('person_chronic a')
           ->result();
       return $rs;
   }
    public function get_chronic_by_amp($as,$ae,$group_id,$amp){
       $rs = $this->db
           ->select(" b.off_id as id ,b.off_name as name,count(*) as total,SUM(IF(a.SEX='1',1,0)) as M,SUM(IF(a.SEX='2',1,0)) as F",false)
           ->where('a.GROUPCODE',$group_id)
            ->where('b.distid',$amp)
            ->where('a.DISCHAR','9' )
           ->where("TYPEAREA in('1','3')")
           ->where("AGE BETWEEN '".$as."' AND '".$ae."' ",'',false)
           ->join('co_office b','HOSPCODE=b.off_id')
           //->join('co_district c' ,'b.distid=c.distid')
           ->group_by('b.off_id')
           ->get('person_chronic a')
           ->result();
       return $rs;
   }
    public function get_chronic_by_hospcode($as,$ae,$group_id,$hospcode){
       $rs = $this->db
           ->select(" a.cid as id ,NULL as name,count(*) as total,SUM(IF(a.SEX='1',1,0)) as M,SUM(IF(a.SEX='2',1,0)) as F",false)
           ->where('a.GROUPCODE',$group_id)
            ->where('b.off_id',$hospcode)
            ->where('a.DISCHAR','9' )
           ->where("TYPEAREA in('1','3')")
           ->where("AGE BETWEEN '".$as."' AND '".$ae."' ",'',false)
           ->join('co_office b','HOSPCODE=b.off_id')
           //->join('co_district c' ,'b.distid=c.distid')
           ->group_by('a.cid')
           ->get('person_chronic a')
           ->result();
       return $rs;
   }
    // ###################### End Chronic ###############

//############################ Start CHILD FAT

    public function get_pingpong_dm($as,$ae)
    {
        $sql=" SELECT  b.distid as id,c.distname as name,";
        $sql.="SUM(IF(`PINGPONG_DM` ='1', 1, 0)) AS pdm1, SUM(IF(`PINGPONG_DM`='2', 1, 0)) AS pdm2, SUM(IF(`PINGPONG_DM`='3', 1, 0)) AS pdm3, ";
        $sql.="SUM(IF(`PINGPONG_DM` ='4', 1, 0)) AS pdm4, SUM(IF(`PINGPONG_DM`='5', 1, 0)) AS pdm5 , SUM(IF(`PINGPONG_DM`='6', 1, 0)) AS pdm6 , SUM(IF(`PINGPONG_DM`='7', 1, 0)) AS pdm7 ,count(PINGPONG_DM) as Alls";
        $sql.=" FROM person a ";
        $sql.=" JOIN co_office b ON a.HOSPCODE=b.off_id ";
        $sql.=" JOIN co_district c ON b.distid=c.distid";
        $sql.=" WHERE  a.AGE BETWEEN '".$as."' AND '".$ae."' ";
        $sql.=" AND sex IN('1','2') AND TYPEAREA IN (1,3) AND dischar = '9'";
        $sql.=" GROUP BY c.distid";

        $rs=$this->db->query($sql)->result();
        return $rs;
    }
    public function get_pingpong_dm_by_amp($as,$ae,$amp)
    {
        $sql=" SELECT  b.off_id as id,b.off_name as name, ";
        $sql.="SUM(IF(`PINGPONG_DM` ='1', 1, 0)) AS pdm1, SUM(IF(`PINGPONG_DM`='2', 1, 0)) AS pdm2, SUM(IF(`PINGPONG_DM`='3', 1, 0)) AS pdm3, ";
        $sql.="SUM(IF(`PINGPONG_DM` ='4', 1, 0)) AS pdm4, SUM(IF(`PINGPONG_DM`='5', 1, 0)) AS pdm5 , SUM(IF(`PINGPONG_DM`='6', 1, 0)) AS pdm6 , SUM(IF(`PINGPONG_DM`='7', 1, 0)) AS pdm7 ,count(PINGPONG_DM) as Alls";
        $sql.=" FROM person a ";
        $sql.=" JOIN co_office b ON a.HOSPCODE=b.off_id ";
        $sql.=" WHERE a.AGE BETWEEN '".$as."' AND '".$ae."' ";
        $sql.=" AND sex IN('1','2') AND TYPEAREA IN (1,3) AND dischar = '9'";
        $sql.=" AND b.distid='".$amp."'";
        $sql.=" GROUP BY b.off_id";

        $rs=$this->db->query($sql)->result();
        return $rs;
    }
    //############################ End CHILD Fat
}
/* End of file basic_model.php */
/* Location: ./application/models/basic_model.php */