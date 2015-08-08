<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Report model
 *

 *
 */

class Audit_model extends CI_Model
{
    public $hospcode;
    public $year;

    // ปริมาณการใช้ยาแพทย์แผนไทย
/*
SELECT a.PRENAME,a.`NAME`,a.LNAME,b.* FROM
person a
JOIN prenatal b ON a.HOSPCODE=b.HOSPCODE AND a.PID=b.PID
where a.CID='3440400525764'
    */

    public  function get_audit57(){
        $rs = $this->db
            ->select('b.off_id,b.off_name,d.distname,a.memo,a.event_date')
            ->where('c.event','1')
            ->join('co_office b','a.HOSPCODE=b.off_id')
            ->join('hosp_event c','a.event=c.id','LEFT')
            ->join('co_district d','b.distid=d.distid')
            ->order_by('a.HOSPCODE')
            ->get('hosp_event a')
            ->result();
        return $rs;
    }

    public  function get_audit_hosp_op($hospcode,$s,$e){
        $sql=" SELECT * from (SELECT a.*, COUNT(*)AS total_service FROM person_service_diag a";
        $sql.=" JOIN co_office b ON a.HOSPCODE = b.off_id";
        $sql.=" WHERE a.hospcode = '$hospcode' AND a.op = '1'  AND a.TYPEAREA IN(1, 3)";
        $sql.=" AND DATE_FORMAT(a.DATE_SERV, '%Y-%m-%d')BETWEEN '$s' AND '$e'";
        $sql.=" GROUP BY a.cid ORDER BY total_service DESC) a LIMIT 10,5";
        $rs=$this->db->query($sql)->result();
        return $rs;
        return $rs;
    }
    public  function get_audit_hosp_dent($hospcode,$s,$e){
        $sql=" SELECT * from (SELECT a.*, COUNT(*)AS total_service FROM person_service_diag a";
        $sql.=" JOIN co_office b ON a.HOSPCODE = b.off_id";
        $sql.=" WHERE a.hospcode = '$hospcode' AND a.op = '1' AND a.DIAGCODE BETWEEN 'K01' AND 'K14' AND a.TYPEAREA IN(1, 3)";
        $sql.=" AND DATE_FORMAT(a.DATE_SERV, '%Y-%m-%d')BETWEEN '$s' AND '$e'";
        $sql.=" GROUP BY a.cid ORDER BY total_service DESC) a LIMIT 10,5";
        $rs=$this->db->query($sql)->result();
        return $rs;
    }
    public  function get_audit_hosp_dm($hospcode,$s,$e){
        $sql=" SELECT * from (SELECT a.*, COUNT(*)AS total_service FROM person_service_diag a";
        $sql.=" JOIN co_office b ON a.HOSPCODE = b.off_id";
        $sql.=" WHERE a.hospcode = '$hospcode' AND a.op = '1' AND a.DIAGCODE BETWEEN 'E10' AND 'E149' AND a.TYPEAREA IN(1, 3)";
        $sql.=" AND DATE_FORMAT(a.DATE_SERV, '%Y-%m-%d')BETWEEN '$s' AND '$e'";
        $sql.=" GROUP BY a.cid ORDER BY total_service DESC) a LIMIT 10,5";
        $rs=$this->db->query($sql)->result();
        return $rs;
    }
    public  function get_audit_hosp_ht($hospcode,$s,$e){
        $sql=" SELECT * from (SELECT a.*, COUNT(*)AS total_service FROM person_service_diag a";
        $sql.=" JOIN co_office b ON a.HOSPCODE = b.off_id";
        $sql.=" WHERE a.hospcode = '$hospcode' AND a.op = '1' AND a.DIAGCODE BETWEEN 'I10' AND 'I159' AND a.TYPEAREA IN(1, 3)";
        $sql.=" AND DATE_FORMAT(a.DATE_SERV, '%Y-%m-%d')BETWEEN '$s' AND '$e'";
        $sql.=" GROUP BY a.cid ORDER BY total_service DESC) a LIMIT 10,5";
        $rs=$this->db->query($sql)->result();
        return $rs;
    }
    public  function get_audit_hosp_thaimed($hospcode,$s,$e){
        $rs = $this->db
            ->select('a.*,COUNT(*) as total_service ')
            ->where('a.hospcode',$hospcode)
            ->where('a.PROCED_THAI','1')
            ->where('a.TYPEAREA in (1,3)','',FALSE)
            ->where("DATE_FORMAT(a.DATE_SERV,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'",'',FALSE)
            ->having('total_service <= ','20')
            ->join('co_office b','a.HOSPCODE=b.off_id')
            ->group_by('a.cid')
            ->order_by('total_service','DESC')
            ->limit(5,10)
            ->get('person_service_proced_opd a')
            ->result();
        return $rs;
    }
    public  function get_audit_hosp_thaidrug($hospcode,$s,$e){
        $rs = $this->db
            ->select('a.*,COUNT(*) as total_service ')
            ->where('a.hospcode',$hospcode)
            ->where('a.DRUG_THAI','1')
            ->where('a.TYPEAREA in (1,3)','',FALSE)
            ->where("DATE_FORMAT(a.DATE_SERV,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'",'',FALSE)
            ->having('total_service <= ','20')
            ->join('co_office b','a.HOSPCODE=b.off_id')
            ->group_by('a.cid')
            ->order_by('total_service','DESC')
            ->limit(5,10)
            ->get('person_service_drug_opd a')
            ->result();
        return $rs;
    }
    public  function get_audit_hosp_epi1($hospcode,$s,$e){
        $rs = $this->db
            ->select('a.*,a.PID as pid,COUNT(*) as total_service ')
            ->where('a.hospcode',$hospcode)
            ->where('a.AGE','1')
            ->where('a.TYPEAREA in (1,3)','',FALSE)
            ->having('total_service <= ','20')
            ->join('co_office b','a.HOSPCODE=b.off_id')
            ->group_by('a.cid')
            ->order_by('total_service','DESC')
            ->limit(5,10)
            ->get('person a')
            ->result();
        return $rs;
    }public  function get_audit_hosp_epi2($hospcode,$s,$e){
        $rs = $this->db
            ->select('a.*,a.PID as pid,COUNT(*) as total_service ')
            ->where('a.hospcode',$hospcode)
            ->where('a.AGE','2')
            ->where('a.TYPEAREA in (1,3)','',FALSE)
            ->having('total_service <= ','20')
            ->join('co_office b','a.HOSPCODE=b.off_id')
            ->group_by('a.cid')
            ->order_by('total_service','DESC')
            ->limit(5,10)
            ->get('person a')
            ->result();
        return $rs;
    }public  function get_audit_hosp_epi3($hospcode,$s,$e){
        $rs = $this->db
            ->select('a.*,a.PID as pid,COUNT(*) as total_service ')
            ->where('a.hospcode',$hospcode)
            ->where('a.AGE','3')
            ->where('a.TYPEAREA in (1,3)','',FALSE)
            ->having('total_service <= ','20')
            ->join('co_office b','a.HOSPCODE=b.off_id')
            ->group_by('a.cid')
            ->order_by('total_service','DESC')
            ->limit(5,10)
            ->get('person a')
            ->result();
        return $rs;
    }
    public  function get_audit_hosp_epi5($hospcode,$s,$e){
        $rs = $this->db
            ->select('a.*,a.PID as pid,COUNT(*) as total_service ')
            ->where('a.hospcode',$hospcode)
            ->where('a.AGE','5')
            ->where('a.TYPEAREA in (1,3)','',FALSE)
            ->having('total_service <= ','20')
            ->join('co_office b','a.HOSPCODE=b.off_id')
            ->group_by('a.cid')
            ->order_by('total_service','DESC')
            ->limit(5,10)
            ->get('person a')
            ->result();
        return $rs;
    }
    public  function get_audit_ur($hospcode,$s,$e){
        $rs = $this->db
            ->select("DATE_FORMAT(a.DATE_SERV,'%Y-%m') as M,SUM(IF(a.op=1,1,0)) as op_service,COUNT(*) as all_service ,SUM(IF(a.op=1,a.PRICE,0)) as price_op",false)
            ->where('a.hospcode',$hospcode)
            //->where('a.op','1')
            ->where('a.TYPEAREA in (1,3)','',FALSE)
            ->where('a.DIAGTYPE','1')
            ->where("DATE_FORMAT(a.DATE_SERV,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'",'',FALSE)
            ->group_by('M')
            //->order_by('total_service','DESC')
            ->get('person_service_diag a')
            ->result();
        return $rs;
    }
    public  function get_audit_top_service($hospcode,$s,$e){
        $rs = $this->db
            ->select("a.DATE_SERV,COUNT(*) as total_service ,SUM(IF(a.op='1',1,0)) as op",false)
            ->where('a.hospcode',$hospcode)
           // ->where('a.TYPEAREA in (1,3)','',FALSE)
            ->where('a.DIAGTYPE','1')
            ->where("DATE_FORMAT(a.DATE_SERV,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'",'',FALSE)
            ->group_by('a.DATE_SERV')
            ->order_by('total_service','DESC')
            ->limit(20)
            ->get('person_service_diag a')
            ->result();
        return $rs;
    }
    public  function get_audit_top_diag($hospcode,$s,$e){
        $rs = $this->db
            ->select("a.DIAGCODE as ICD10,COUNT(*) as total_service ",false)
            ->where('a.hospcode',$hospcode)
           // ->where('a.TYPEAREA in (1,3)','',FALSE)
            ->where("DATE_FORMAT(a.DATE_SERV,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'",'',FALSE)
            ->group_by('a.DIAGCODE')
            ->order_by('total_service','DESC')
            ->limit(20)
            ->get('person_service_diag a')
            ->result();
        return $rs;
    }
    public  function get_audit_top_proced($hospcode,$s,$e){
    $rs = $this->db
        ->select("a.PROCED as ICD9,COUNT(*) as total_service ",false)
        ->where('a.hospcode',$hospcode)
        // ->where('a.TYPEAREA in (1,3)','',FALSE)
        ->where("DATE_FORMAT(a.DATE_SERV,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'",'',FALSE)
        ->group_by('a.PROCED')
        ->order_by('total_service','DESC')
        ->limit(20)
        ->get('person_service_proced_opd a')
        ->result();
    return $rs;
}
    public function get_audit_top_drug($hospcode,$s,$e){
    $rs = $this->db
        ->select("a.DIDSTD,a.DNAME,SUM(a.PRICE) as PRICE,SUM(a.AMOUNT*a.DRUGCOST) as COST,SUM(a.AMOUNT) as total_drug,COUNT(*) as total",false)
        ->where('a.hospcode',$hospcode)
        // ->where('a.TYPEAREA in (1,3)','',FALSE)
        ->where("DATE_FORMAT(a.DATE_SERV,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'",'',FALSE)
        ->group_by('a.DIDSTD')
        ->order_by('total_drug','DESC')
        ->limit(20)
        ->get('person_service_drug_opd a')
        ->result();
    return $rs;
}
    public function get_audit_disease_group($hospcode,$s,$e){
    $rs = $this->db
        ->select("a.ck,b.des_code,b.group_name,COUNT(*) as total_time  ,COUNT(DISTINCT a.cid) as total_service",false)
        ->where('a.hospcode',$hospcode)
        ->where('a.ck IS NOT NULL','',FALSE)
        ->where("DATE_FORMAT(a.DATE_SERV,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'",'',FALSE)
        ->group_by('a.ck')
        ->order_by('a.ck','ASC')
        ->join('co_disesegroup_audit b','a.ck=b.id')
        ->get('person_service_diag a')
        ->result();
    return $rs;
}
    public function get_service($hospcode,$cid,$s,$e){
    $rs = $this->db
        ->select("a.DATE_SERV",false)
        ->where('a.hospcode',$hospcode)
        ->where('a.CID',$cid)
        ->where("DATE_FORMAT(a.DATE_SERV,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'",'',FALSE)
        ->group_by('a.DATE_SERV')
        ->order_by('a.DATE_SERV','ASC')
        ->get('person_service_diag a')
        ->result();
    return $rs;
}
    public function get_service_op($hospcode,$cid,$s,$e){
    $rs = $this->db
        ->select("a.DATE_SERV",false)
        ->where('a.hospcode',$hospcode)
        ->where('a.CID',$cid)
        ->where('a.op','1')
        ->where("DATE_FORMAT(a.DATE_SERV,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'",'',FALSE)
        ->group_by('a.DATE_SERV')
        ->order_by('a.DATE_SERV','ASC')
        ->get('person_service_diag a')
        ->result();
    return $rs;
}
    public function get_visit_list($cid,$visit_date){
    $rs = $this->db
        //->select("a.DATE_SERV",false)

        ->where('a.CID',$cid)
        ->where("DATE_FORMAT(a.DATE_SERV,'%Y-%m-%d')='$visit_date'",'',FALSE)
        ->order_by('a.SEQ','ASC')
        ->group_by('a.SEQ')
        ->order_by('a.DIAGTYPE')
        ->get('person_service_diag a')
        ->result();
    return $rs;
}

    public  function get_person_audit($cid,$hospcode){
        $rs = $this->db
            ->where('HOSPCODE',$hospcode)
            ->where('CID',$cid)
            ->get('person')
            ->row();

        return count($rs) > 0 ? true : false;
    }

    //############################ End Labor



}
/* End of file basic_model.php */
/* Location: ./application/models/basic_model.php */