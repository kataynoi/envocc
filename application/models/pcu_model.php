<?php
class Pcu_model extends CI_Model
{
    public function get_kpi($year,$section)
    {
        /*echo $this->db->_compile_select();*/
        $rs = $this->db
            ->select('k.*,o.name as ownername')
            ->where('k_year',$year)
            ->where('section',$section)
            ->join('kpi_owner o','k.owner=o.id','LEFT')
            ->get('kpi k')
            ->result();
      // echo  $this->db->last_query();
        return $rs;
    }
    public function get_owner_kpi()
    {
        $rs = $this->db
            ->get('kpi_owner')
            ->result();
        return $rs;
    }
    public function get_section()
    {
        $rs = $this->db
            ->get('co_section_type')
            ->result();
        return $rs;
    }
public function get_ontop_hsub($cup,$year)
    {
        //$year='2013';
        $year2=($year-1);
       // $cup='11055';
        $sql="SELECT HCODE,off.off_name,
                sum(if(top.DATE_SERV BETWEEN '".$year2."1001' and '".$year2."1031',1,0)) as M_10,
                sum(if(top.DATE_SERV BETWEEN '".$year2."1101' and '".$year2."1130',1,0)) as M_11,
                sum(if(top.DATE_SERV BETWEEN '".$year2."1201' and '".$year2."1231',1,0)) as M_12,
                sum(if(top.DATE_SERV BETWEEN '".$year."0101' and '".$year."0131',1,0)) as M_01,
                sum(if(top.DATE_SERV BETWEEN '".$year."0201' and '".$year."0228',1,0)) as M_02,
                sum(if(top.DATE_SERV BETWEEN '".$year."0301' and '".$year."0331',1,0)) as M_03,
                sum(if(top.DATE_SERV BETWEEN '".$year."0401' and '".$year."0430',1,0)) as M_04,
                sum(if(top.DATE_SERV BETWEEN '".$year."0501' and '".$year."0531',1,0)) as M_05,
                sum(if(top.DATE_SERV BETWEEN '".$year."0601' and '".$year."0630',1,0)) as M_06,
                sum(if(top.DATE_SERV BETWEEN '".$year."0701' and '".$year."0731',1,0)) as M_07,
                sum(if(top.DATE_SERV BETWEEN '".$year."0801' and '".$year."0831',1,0)) as M_08,
                sum(if(top.DATE_SERV BETWEEN '".$year."0901' and '".$year."0930',1,0)) as M_09,
                sum(if(top.DATE_SERV BETWEEN '".$year2."1001' and '".$year."0930',1,0)) as M_All
,MAX(top.DATE_SERV) as last_service
                FROM
                kpi_ontop top
                LEFT JOIN co_office off on top.HCODE=off.off_id
                WHERE top.HCODE=top.HIST_HSUB AND HIST_HMAIN_OP='".$cup."'
                   GROUP BY top.HIST_HSUB";

        $rs = $this->db->query($sql)->result();
        return $rs;

    }
    public function get_ontop_hmain($cup,$year)
    {

        $year2=($year-1);
        //$cup='11055';
        $sql="SELECT HCODE,HIST_HSUB,off.off_name,
sum(if(top.DATE_SERV BETWEEN '".$year2."1001' and '".$year2."1031',1,0)) as M_10,
sum(if(top.DATE_SERV BETWEEN '".$year2."1101' and '".$year2."1130',1,0)) as M_11,
sum(if(top.DATE_SERV BETWEEN '".$year2."1201' and '".$year2."1231',1,0)) as M_12,
sum(if(top.DATE_SERV BETWEEN '".$year."0101' and '".$year."0131',1,0)) as M_01,
sum(if(top.DATE_SERV BETWEEN '".$year."0201' and '".$year."0228',1,0)) as M_02,
sum(if(top.DATE_SERV BETWEEN '".$year."0301' and '".$year."0331',1,0)) as M_03,
sum(if(top.DATE_SERV BETWEEN '".$year."0401' and '".$year."0430',1,0)) as M_04,
sum(if(top.DATE_SERV BETWEEN '".$year."0501' and '".$year."0531',1,0)) as M_05,
sum(if(top.DATE_SERV BETWEEN '".$year."0601' and '".$year."0630',1,0)) as M_06,
sum(if(top.DATE_SERV BETWEEN '".$year."0701' and '".$year."0731',1,0)) as M_07,
sum(if(top.DATE_SERV BETWEEN '".$year."0801' and '".$year."0831',1,0)) as M_08,
sum(if(top.DATE_SERV BETWEEN '".$year."0901' and '".$year."0930',1,0)) as M_09,
sum(if(top.DATE_SERV BETWEEN '".$year2."1001' and '".$year."0930',1,0)) as M_All
,MAX(top.DATE_SERV) as last_service

 FROM
kpi_ontop top
LEFT JOIN co_office off on top.HIST_HMAIN_OP=off.off_id
WHERE top.HCODE=top.HIST_HMAIN_OP AND HIST_HMAIN_OP='".$cup."'
GROUP BY top.HIST_HSUB";

        $rs = $this->db->query($sql)->result();
        return $rs;

    }


public function get_community_service($s,$e)
    {
        $sql=" SELECT d.distid as id ,d.distname as name,a.COMSERVICE as comservice,count(*) as total ,";
        $sql.=" SUM(IF(a.COMSERVICE='1A01101',1,0)) as HT,";
        $sql.=" SUM(IF(a.COMSERVICE='1A01102',1,0)) as DM,";
        $sql.=" SUM(IF(a.COMSERVICE='1A01204',1,0)) as TB,";
        $sql.=" SUM(IF(a.COMSERVICE in('1A01301','1A01302','1A01303','1A01306','1A01308'),1,0)) as PSY,";
        $sql.=" SUM(IF(a.COMSERVICE in('1A03101','1A03102','1A03103','1A03104','1A03108'),1,0)) as ANC,";
        $sql.=" SUM(IF(a.COMSERVICE NOT IN ('1A01101','1A01102','1A01204','1A01301','1A01302','1A01303','1A01306','1A01308','1A03101','1A03102','1A03103','1A03104','1A03108'),1,0)) as ETC ";

    $sql.=" FROM community_service a ";
        $sql.=" JOIN co_office b on a.HOSPCODE =b.off_id";
        $sql.=" JOIN co_district d on b.distid =d.distid";
        $sql.=" WHERE DATE_FORMAT(a.date_serv,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'";
        //$sql.=" AND a.COMSERVICE IN ('1A01101','1A01102','1A01204','1A01301','1A01302','1A01303','1A01306','1A01308','1A03101','1A03102','1A03103','1A03104','1A03108')";
        $sql.=" GROUP BY d.distid ORDER BY id";

        $rs=$this->hdc->query($sql)->result();
        return $rs;
    }public function get_community_service_by_amp($s,$e,$amp)
    {
        $sql=" SELECT a.HOSPCODE as id ,b.off_name as name,a.COMSERVICE as comservice,count(*) as total ,";
        $sql.=" SUM(IF(a.COMSERVICE='1A01101',1,0)) as HT,";
        $sql.=" SUM(IF(a.COMSERVICE='1A01102',1,0)) as DM,";
        $sql.=" SUM(IF(a.COMSERVICE='1A01204',1,0)) as TB,";
        $sql.=" SUM(IF(a.COMSERVICE in('1A01301','1A01302','1A01303','1A01306','1A01308'),1,0)) as PSY,";
        $sql.=" SUM(IF(a.COMSERVICE in('1A03101','1A03102','1A03103','1A03104','1A03108'),1,0)) as ANC";

        $sql.=" FROM community_service a JOIN community_service_type c on a.COMSERVICE = c.service_code";
        $sql.=" JOIN co_office b on a.HOSPCODE =b.off_id";

        $sql.=" WHERE b.distid=".$amp." AND DATE_FORMAT(a.date_serv,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'";
        $sql.=" AND a.COMSERVICE IN ('1A01101','1A01102','1A01204','1A01301','1A01302','1A01303','1A01306','1A01308','1A03101','1A03102','1A03103','1A03104','1A03108')";
        $sql.=" GROUP BY b.off_id ORDER BY id";

        $rs=$this->hdc->query($sql)->result();
        return $rs;
    }
    public function get_cup()
    {   $arr_in=array('06','07');
        $rs = $this->db
            ->where_in('off_type',$arr_in)
            ->get('co_office')
            ->result();
        return $rs;
    }
    public function call_ontop($start,$end)
    {
        $this->db->query("CALL kpi_ontop('$start','$end')");
    }
}

