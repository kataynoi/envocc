<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Report model
 *

 *
 */

class Mom_child_model extends CI_Model
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

    public  function get_person_newborn($cid){
        $rs = $this->hdc
            ->select('a.PRENAME,a.`NAME`,a.LNAME,b.*')
            ->where('cid',$cid)
            ->join('newborn b','a.HOSPCODE=b.HOSPCODE AND a.PID=b.PID')
            ->get('person a')
            ->result();
        return $rs;
    }
    public  function get_person_epi($cid){
        $rs = $this->hdc
            ->select('a.PRENAME,a.`NAME`,a.LNAME,b.*')
            ->where('cid',$cid)
            ->join('epi b','a.HOSPCODE=b.HOSPCODE AND a.PID=b.PID')
            ->get('person a')
            ->result();
        return $rs;
    }
    public  function get_person_newborncare($cid){
        $rs = $this->hdc
            ->select('a.PRENAME,a.`NAME`,a.LNAME,b.*')
            ->where('cid',$cid)
            ->join('newborncare b','a.HOSPCODE=b.HOSPCODE AND a.PID=b.PID')
            ->get('person a')
            ->result();
        return $rs;
    }
    public  function get_person_prenatal($cid,$gravida){
        $rs = $this->hdc
            ->select('a.PRENAME,a.`NAME`,a.LNAME,b.*')
            ->where('cid',$cid)
            ->where('gravida',$gravida)
            ->join('prenatal b','a.HOSPCODE=b.HOSPCODE AND a.PID=b.PID')
            ->get('person a')
            ->result();
        return $rs;
    }

    public  function get_person_labor($cid,$gravida){
        $rs = $this->hdc
            ->select('a.PRENAME,a.`NAME`,a.LNAME,b.*,c.PID as CHILDPID')
            ->where('a.cid',$cid)
            ->where('b.gravida',$gravida)
            ->join('labor b','a.HOSPCODE=b.HOSPCODE AND a.PID=b.PID')
            ->join('newborn c','b.HOSPCODE=c.HOSPCODE AND b.PID=c.MPID')
            ->get('person a')
            ->result();
        return $rs;
    }
    public  function get_person_postnatal($cid,$gravida){
        $rs = $this->hdc
            ->select('a.PRENAME,a.`NAME`,a.LNAME,b.*')
            ->where('cid',$cid)
            ->where('gravida',$gravida)
            ->join('postnatal b','a.HOSPCODE=b.HOSPCODE AND a.PID=b.PID')
            ->get('person a')
            ->result();
        return $rs;
    }
    public function get_prenatal($s,$e)
    {
        $sql="SELECT c.distid as id,c.distname as name,COUNT(*) as total, ";
        $sql.=" SUM(IF(a.GRAVIDA='1',1,0)) as ga1,SUM(IF(a.GRAVIDA='2',1,0)) as ga2,";
        $sql.=" SUM(IF(a.GRAVIDA='3',1,0)) as ga3,SUM(IF(a.GRAVIDA='4',1,0)) as ga4,";
        $sql.=" SUM(IF(a.GRAVIDA >='5',1,0)) as ga5up,SUM(IF(a.VDRL_RESULT  IS NOT NULL,1,0)) as VDRL,";
        $sql.=" SUM(IF(a.HB_RESULT  IS NOT NULL,1,0)) as HB,SUM(IF(a.HIV_RESULT  IS NOT NULL,1,0)) as HIV,";
        $sql.=" SUM(IF(a.HCT_RESULT  IS NOT NULL,1,0)) as HCT,SUM(IF(a.THALASSEMIA  IS NOT NULL,1,0)) as THA";
        $sql.=" FROM prenatal a ";
        $sql.=" JOIN ex_co_office b ON a.HOSPCODE=b.off_id";
        $sql.=" JOIN ex_co_district c ON b.distid=c.distid";
        $sql.=" WHERE DATE_FORMAT(a.LMP,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'";
        $sql.=" GROUP BY c.distid";

        $rs=$this->hdc->query($sql)->result();
        return $rs;
    }
    public function get_prenatal_by_amp($s,$e,$amp)
    {
        $sql="SELECT a.HOSPCODE as id,b.off_name as name,COUNT(*) as total, ";
        $sql.=" SUM(IF(a.GRAVIDA='1',1,0)) as ga1,SUM(IF(a.GRAVIDA='2',1,0)) as ga2,";
        $sql.=" SUM(IF(a.GRAVIDA='3',1,0)) as ga3,SUM(IF(a.GRAVIDA='4',1,0)) as ga4,";
        $sql.=" SUM(IF(a.GRAVIDA >='5',1,0)) as ga5up,SUM(IF(a.VDRL_RESULT  IS NOT NULL,1,0)) as VDRL,";
        $sql.=" SUM(IF(a.HB_RESULT  IS NOT NULL,1,0)) as HB,SUM(IF(a.HIV_RESULT  IS NOT NULL,1,0)) as HIV,";
        $sql.=" SUM(IF(a.HCT_RESULT  IS NOT NULL,1,0)) as HCT,SUM(IF(a.THALASSEMIA  IS NOT NULL,1,0)) as THA";
        $sql.=" FROM prenatal a ";
        $sql.=" RIGHT JOIN ex_co_office b ON a.HOSPCODE=b.off_id";
        $sql.=" WHERE b.distid='".$amp."' AND DATE_FORMAT(a.LMP,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'";
        $sql.=" GROUP BY b.off_id";

        $rs=$this->hdc->query($sql)->result();
        return $rs;
    }
    public function get_prenatal_by_hospcode($s,$e,$hospcode)
    {
        $sql="SELECT b.CID as id,CONCAT(b.NAME,' ',b.LNAME) as name,COUNT(*) as total,a.gravida, ";
        $sql.=" SUM(IF(a.GRAVIDA='1',1,0)) as ga1,SUM(IF(a.GRAVIDA='2',1,0)) as ga2,";
        $sql.=" SUM(IF(a.GRAVIDA='3',1,0)) as ga3,SUM(IF(a.GRAVIDA='4',1,0)) as ga4,";
        $sql.=" SUM(IF(a.GRAVIDA >='5',1,0)) as ga5up,SUM(IF(a.VDRL_RESULT  IS NOT NULL,1,0)) as VDRL,";
        $sql.=" SUM(IF(a.HB_RESULT  IS NOT NULL,1,0)) as HB,SUM(IF(a.HIV_RESULT  IS NOT NULL,1,0)) as HIV,";
        $sql.=" SUM(IF(a.HCT_RESULT  IS NOT NULL,1,0)) as HCT,SUM(IF(a.THALASSEMIA  IS NOT NULL,1,0)) as THA";
        $sql.=" FROM prenatal a ";
        $sql.=" JOIN person b ON a.HOSPCODE=b.HOSPCODE AND a.PID=b.PID";
        $sql.=" WHERE a.HOSPCODE='".$hospcode."' AND DATE_FORMAT(a.LMP,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'";
        $sql.=" GROUP BY CONCAT(a.HOSPCODE,a.PID)";

        $rs=$this->hdc->query($sql)->result();
        return $rs;
    }
    //############### Post natal


    public function get_postnatal($s,$e)
    {
        $sql="SELECT c.distid as id,c.distname as name,COUNT(*) as total ";

        $sql.=" FROM postnatal a ";
        $sql.=" JOIN ex_co_office b ON a.HOSPCODE=b.off_id";
        $sql.=" JOIN ex_co_district c ON b.distid=c.distid";
        $sql.=" WHERE DATE_FORMAT(a.BDATE,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'";
        $sql.=" GROUP BY c.distid";

        $rs=$this->hdc->query($sql)->result();
        return $rs;
    }
    public function get_postnatal_by_amp($s,$e,$amp)
    {
        $sql="SELECT a.id,a.name,count(*) as total FROM(SELECT DISTINCT(CONCAT(a.PID)) ,a.HOSPCODE as id,b.off_name as name,COUNT(*) as total ";
        /*$sql.=" ,SUM(IF(a.GRAVIDA='1',1,0)) as ga1,SUM(IF(a.GRAVIDA='2',1,0)) as ga2,";
        $sql.=" SUM(IF(a.GRAVIDA='3',1,0)) as ga3,SUM(IF(a.GRAVIDA='4',1,0)) as ga4,";
        $sql.=" SUM(IF(a.GRAVIDA >='5',1,0)) as ga5up,SUM(IF(a.VDRL_RESULT  IS NOT NULL,1,0)) as VDRL,";
        $sql.=" SUM(IF(a.HB_RESULT  IS NOT NULL,1,0)) as HB,SUM(IF(a.HIV_RESULT  IS NOT NULL,1,0)) as HIV,";
        $sql.=" SUM(IF(a.HCT_RESULT  IS NOT NULL,1,0)) as HCT,SUM(IF(a.THALASSEMIA  IS NOT NULL,1,0)) as THA";
        */$sql.=" FROM postnatal a ";
        $sql.=" RIGHT JOIN ex_co_office b ON a.HOSPCODE=b.off_id";
        $sql.=" WHERE b.distid='".$amp."' AND DATE_FORMAT(a.BDATE,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'";
        $sql.=" GROUP BY CONCAT(b.off_id,a.PID)) as a GROUP BY a.id";

        $rs=$this->hdc->query($sql)->result();
        return $rs;
    }
    public function get_postnatal_by_hospcode($s,$e,$hospcode)
    {
        $sql="SELECT b.CID as id,CONCAT(b.NAME,' ',b.LNAME) as name,COUNT(*) as total,a.gravida ";
        /*$sql.=" ,SUM(IF(a.GRAVIDA='1',1,0)) as ga1,SUM(IF(a.GRAVIDA='2',1,0)) as ga2,";
        $sql.=" SUM(IF(a.GRAVIDA='3',1,0)) as ga3,SUM(IF(a.GRAVIDA='4',1,0)) as ga4,";
        $sql.=" SUM(IF(a.GRAVIDA >='5',1,0)) as ga5up,SUM(IF(a.VDRL_RESULT  IS NOT NULL,1,0)) as VDRL,";
        $sql.=" SUM(IF(a.HB_RESULT  IS NOT NULL,1,0)) as HB,SUM(IF(a.HIV_RESULT  IS NOT NULL,1,0)) as HIV,";
        $sql.=" SUM(IF(a.HCT_RESULT  IS NOT NULL,1,0)) as HCT,SUM(IF(a.THALASSEMIA  IS NOT NULL,1,0)) as THA";*/
        $sql.=" FROM postnatal a ";
        $sql.=" JOIN person b ON a.HOSPCODE=b.HOSPCODE AND a.PID=b.PID";
        $sql.=" WHERE a.HOSPCODE='".$hospcode."' AND DATE_FORMAT(a.BDATE,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'";
        $sql.=" GROUP BY CONCAT(a.HOSPCODE,a.PID)";

        $rs=$this->hdc->query($sql)->result();
        return $rs;
    }

    //############### End Post natal

    //############### Post New Born Care


    public function get_newborn_care($s,$e)
    {
        $sql="SELECT c.distid as id,c.distname as name,COUNT(*) as total ";
        /*$sql.=" ,SUM(IF(a.GRAVIDA='1',1,0)) as ga1,SUM(IF(a.GRAVIDA='2',1,0)) as ga2,";
        $sql.=" SUM(IF(a.GRAVIDA='3',1,0)) as ga3,SUM(IF(a.GRAVIDA='4',1,0)) as ga4,";
        $sql.=" SUM(IF(a.GRAVIDA >='5',1,0)) as ga5up,SUM(IF(a.VDRL_RESULT  IS NOT NULL,1,0)) as VDRL,";
        $sql.=" SUM(IF(a.HB_RESULT  IS NOT NULL,1,0)) as HB,SUM(IF(a.HIV_RESULT  IS NOT NULL,1,0)) as HIV,";
        $sql.=" SUM(IF(a.HCT_RESULT  IS NOT NULL,1,0)) as HCT,SUM(IF(a.THALASSEMIA  IS NOT NULL,1,0)) as THA";
        */
        $sql.=" FROM newborncare a ";
        $sql.=" JOIN ex_co_office b ON a.HOSPCODE=b.off_id";
        $sql.=" JOIN ex_co_district c ON b.distid=c.distid";
        $sql.=" WHERE DATE_FORMAT(a.BDATE,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'";
        $sql.=" GROUP BY c.distid";

        $rs=$this->hdc->query($sql)->result();
        return $rs;
    }
    public function get_newborn_care_by_amp($s,$e,$amp)
    {
        $sql="SELECT a.id,a.name,count(*) as total FROM(SELECT DISTINCT(CONCAT(a.PID)) ,a.HOSPCODE as id,b.off_name as name,COUNT(*) as total ";
        /*$sql.=" ,SUM(IF(a.GRAVIDA='1',1,0)) as ga1,SUM(IF(a.GRAVIDA='2',1,0)) as ga2,";
        $sql.=" SUM(IF(a.GRAVIDA='3',1,0)) as ga3,SUM(IF(a.GRAVIDA='4',1,0)) as ga4,";
        $sql.=" SUM(IF(a.GRAVIDA >='5',1,0)) as ga5up,SUM(IF(a.VDRL_RESULT  IS NOT NULL,1,0)) as VDRL,";
        $sql.=" SUM(IF(a.HB_RESULT  IS NOT NULL,1,0)) as HB,SUM(IF(a.HIV_RESULT  IS NOT NULL,1,0)) as HIV,";
        $sql.=" SUM(IF(a.HCT_RESULT  IS NOT NULL,1,0)) as HCT,SUM(IF(a.THALASSEMIA  IS NOT NULL,1,0)) as THA";
        */$sql.=" FROM newborncare a ";
        $sql.=" RIGHT JOIN ex_co_office b ON a.HOSPCODE=b.off_id";
        $sql.=" WHERE b.distid='".$amp."' AND DATE_FORMAT(a.BDATE,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'";
        $sql.=" GROUP BY CONCAT(b.off_id,a.PID)) as a GROUP BY a.id";

        $rs=$this->hdc->query($sql)->result();
        return $rs;
    }
    public function get_newborn_care_by_hospcode($s,$e,$hospcode)
    {
        $sql="SELECT b.CID as id,CONCAT(b.NAME,' ',b.LNAME) as name,COUNT(*) as total ";
        /*$sql.=" ,SUM(IF(a.GRAVIDA='1',1,0)) as ga1,SUM(IF(a.GRAVIDA='2',1,0)) as ga2,";
        $sql.=" SUM(IF(a.GRAVIDA='3',1,0)) as ga3,SUM(IF(a.GRAVIDA='4',1,0)) as ga4,";
        $sql.=" SUM(IF(a.GRAVIDA >='5',1,0)) as ga5up,SUM(IF(a.VDRL_RESULT  IS NOT NULL,1,0)) as VDRL,";
        $sql.=" SUM(IF(a.HB_RESULT  IS NOT NULL,1,0)) as HB,SUM(IF(a.HIV_RESULT  IS NOT NULL,1,0)) as HIV,";
        $sql.=" SUM(IF(a.HCT_RESULT  IS NOT NULL,1,0)) as HCT,SUM(IF(a.THALASSEMIA  IS NOT NULL,1,0)) as THA";*/
        $sql.=" FROM newborncare a ";
        $sql.=" JOIN person b ON a.HOSPCODE=b.HOSPCODE AND a.PID=b.PID";
        $sql.=" WHERE a.HOSPCODE='".$hospcode."' AND DATE_FORMAT(a.BDATE,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'";
        $sql.=" GROUP BY CONCAT(a.HOSPCODE,a.PID)";

        $rs=$this->hdc->query($sql)->result();
        return $rs;
    }

    //############### End New Born Care
    // ##################### ANC
    public  function get_person_anc($cid,$gravida){
        $rs = $this->db
            ->where('cid',$cid)
            ->where('gravida',$gravida)
            ->order_by('date_serv')
            ->get('person_anc')
            ->result();
        return $rs;
    }
    public  function get_mom_walk_out($hospcode,$s,$e){

        $sql=" SELECT a.cid,a.PTNAME,a.BIRTH,a.AGE,b.ANCNO,b.ANCPLACE,b.GRAVIDA";
        $sql.=" FROM person a ";
        $sql.=" JOIN person_anc b ON a.cid=b.CID ";
        $sql.=" WHERE a.TYPEAREA in ('1','3') AND DATE_FORMAT(b.DATE_SERV,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'";
        $sql.=" AND a.HOSPCODE='".$hospcode."' AND b.HOSPCODE !='04911' AND a.SEX='2' AND a.AGE BETWEEN '10' AND '45'";
        $sql.=" GROUP BY a.CID";

        $rs=$this->db->query($sql)->result();
        return $rs;
    }

    public function get_anc($s,$e)
    {
        $sql=" SELECT c.distid as id,c.distname as name,COUNT(*) as time,COUNT(DISTINCT CONCAT(a.HOSPCODE,a.PID)) as total";
        $sql.=" ,SUM(IF(a.HOSPCODE=a.ANCPLACE,1,0)) as in_hospital,SUM(IF(a.HOSPCODE!=a.ANCPLACE,1,0)) as out_hospital";
        $sql.=" FROM anc a  ";
        $sql.=" JOIN ex_co_office b ON a.HOSPCODE=b.off_id";
        $sql.=" JOIN ex_co_district c ON b.distid=c.distid";
        $sql.=" WHERE DATE_FORMAT(a.DATE_SERV,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'";
        $sql.=" GROUP BY c.distid";

        $rs=$this->hdc->query($sql)->result();
        return $rs;
    }
    public function get_anc_by_amp($s,$e,$amp)
    {
        $sql=" SELECT b.off_id as id,b.off_name as name,COUNT(*) as time,COUNT(DISTINCT CONCAT(a.HOSPCODE,a.PID)) as total";
        $sql.=" ,SUM(IF(a.HOSPCODE=a.ANCPLACE,1,0)) as in_hospital,SUM(IF(a.HOSPCODE!=a.ANCPLACE,1,0)) as out_hospital";
        $sql.=" FROM anc a  ";
        $sql.=" JOIN ex_co_office b ON a.HOSPCODE=b.off_id";
        $sql.=" JOIN ex_co_district c ON b.distid=c.distid";
        $sql.=" WHERE b.distid='".$amp."' AND DATE_FORMAT(a.DATE_SERV,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."' ";
        $sql.=" GROUP BY b.off_id";

        $rs=$this->hdc->query($sql)->result();
        return $rs;
    }
    public function get_anc_by_hospcode($s,$e,$hospcode)
    {
        $sql="SELECT b.CID as id,CONCAT(b.NAME,' ',b.LNAME) as name,COUNT(*) as time,COUNT(DISTINCT CONCAT(a.HOSPCODE,a.PID)) as total, ";
        $sql.=" SUM(IF(a.HOSPCODE=a.ANCPLACE,1,0)) as in_hospital,SUM(IF(a.HOSPCODE!=a.ANCPLACE,1,0)) as out_hospital ,a.gravida";
        $sql.=" FROM anc a ";
        $sql.=" JOIN person b ON a.HOSPCODE=b.HOSPCODE AND a.PID=b.PID";
        $sql.=" WHERE a.HOSPCODE='".$hospcode."' AND DATE_FORMAT(a.DATE_SERV,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'";
        $sql.=" GROUP BY CONCAT(a.HOSPCODE,a.PID)";

        $rs=$this->hdc->query($sql)->result();
        return $rs;
    }
    // ##################### ANC_12week
    public function get_anc_12week($s,$e)
    {
        $sql=" SELECT c.distid as id,c.distname as name,COUNT(*) as time,COUNT(DISTINCT CONCAT(a.HOSPCODE,a.PID)) as total";
        $sql.=" ,SUM(IF(a.HOSPCODE=a.ANCPLACE,1,0)) as in_hospital,SUM(IF(a.HOSPCODE!=a.ANCPLACE,1,0)) as out_hospital";
        $sql.=" FROM anc a  ";
        $sql.=" JOIN ex_co_office b ON a.HOSPCODE=b.off_id";
        $sql.=" JOIN ex_co_district c ON b.distid=c.distid";
        $sql.=" WHERE DATE_FORMAT(a.DATE_SERV,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'";
        $sql.=" AND a.GA <='12'";
        $sql.=" GROUP BY c.distid";

        $rs=$this->hdc->query($sql)->result();
        return $rs;
    }
    public function get_anc_12week_by_amp($s,$e,$amp)
    {
        $sql=" SELECT b.off_id as id,b.off_name as name,COUNT(*) as time,COUNT(DISTINCT CONCAT(a.HOSPCODE,a.PID)) as total";
        $sql.=" ,SUM(IF(a.HOSPCODE=a.ANCPLACE,1,0)) as in_hospital,SUM(IF(a.HOSPCODE!=a.ANCPLACE,1,0)) as out_hospital";
        $sql.=" FROM anc a  ";
        $sql.=" JOIN ex_co_office b ON a.HOSPCODE=b.off_id";
        $sql.=" JOIN ex_co_district c ON b.distid=c.distid";
        $sql.=" WHERE b.distid='".$amp."' AND DATE_FORMAT(a.DATE_SERV,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'";
        $sql.=" AND a.GA <='12'";
        $sql.=" GROUP BY b.off_id";

        $rs=$this->hdc->query($sql)->result();
        return $rs;
    }
    public function get_anc_12week_by_hospcode($s,$e,$hospcode)
    {
        $sql="SELECT b.CID as id,CONCAT(b.NAME,' ',b.LNAME) as name,COUNT(*) as time,COUNT(DISTINCT CONCAT(a.HOSPCODE,a.PID)) as total, ";
        $sql.=" SUM(IF(a.HOSPCODE=a.ANCPLACE,1,0)) as in_hospital,SUM(IF(a.HOSPCODE!=a.ANCPLACE,1,0)) as out_hospital";
        $sql.=" FROM anc a ";
        $sql.=" JOIN person b ON a.HOSPCODE=b.HOSPCODE AND a.PID=b.PID";
        $sql.=" WHERE a.HOSPCODE='".$hospcode."' AND DATE_FORMAT(a.DATE_SERV,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'";
        $sql.=" AND a.GA <='12'";
        $sql.=" GROUP BY CONCAT(a.HOSPCODE,a.PID)";

        $rs=$this->hdc->query($sql)->result();
        return $rs;
    }

//############################ Start CHILD DEVELOP
    public function get_child_develop($s,$e,$as,$ae)
    {
        $sql=" SELECT c.distid as id,c.distname as name,count(a.CID) as total,d.target,";
        $sql.=" SUM(IF(a.CHILDDEVELOP='0' OR a.CHILDDEVELOP IS NULL ,1,0)) as D_0,SUM(IF(a.CHILDDEVELOP='1',1,0)) as D_1,SUM(IF(a.CHILDDEVELOP='2',1,0)) as D_2,SUM(IF(a.CHILDDEVELOP='3',1,0)) as D_3,";
        $sql.=" SUM(IF(a.FOOD='1',1,0)) as Food_1,SUM(IF(a.FOOD='2',1,0)) as Food_2,SUM(IF(a.FOOD='3',1,0)) as Food_3,SUM(IF(a.FOOD='4',1,0)) as Food_4";
        $sql.=" FROM nutrition_prc a ";
        $sql.=" JOIN co_office b ON a.HOSPCODE=b.off_id ";
        $sql.=" JOIN co_district c ON b.distid=c.distid";
        $sql.=" JOIN (SELECT b.distid,count(DISTINCT a.CID) as target FROM person a
                JOIN co_office b ON a.HOSPCODE=b.off_id
                WHERE a.TYPEAREA in('1','3') AND a.AGE BETWEEN '".$as."' AND '".$ae."'
                GROUP BY b.distid)d  ON b.distid=d.distid ";
        $sql.=" WHERE a.AGE BETWEEN '".$as."' AND '".$ae."' AND DATE_FORMAT(a.DATE_SERV,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'";
        $sql.=" GROUP BY c.distid";

        $rs=$this->db->query($sql)->result();
        return $rs;
    }
    public function get_child_develop_by_amp($s,$e,$as,$ae,$amp)
    {
        $sql=" SELECT b.off_id as id,b.off_name as name,count(a.CID) as total,d.target,";
        $sql.="SUM(IF(a.CHILDDEVELOP='0' OR a.CHILDDEVELOP IS NULL ,1,0)) as D_0 ,SUM(IF(a.CHILDDEVELOP='1',1,0)) as D_1,SUM(IF(a.CHILDDEVELOP='2',1,0)) as D_2,SUM(IF(a.CHILDDEVELOP='3',1,0)) as D_3,";
        $sql.=" SUM(IF(a.FOOD='1',1,0)) as Food_1,SUM(IF(a.FOOD='2',1,0)) as Food_2,SUM(IF(a.FOOD='3',1,0)) as Food_3,SUM(IF(a.FOOD='4',1,0)) as Food_4";
        $sql.=" FROM nutrition_prc a ";
        $sql.=" JOIN co_office b ON a.HOSPCODE=b.off_id ";
        $sql.=" JOIN (SELECT b.off_id,count(DISTINCT a.CID) as target FROM person_target a
                JOIN co_office b ON a.HOSPCODE=b.off_id
                WHERE a.TYPEAREA in('1','3') AND a.AGE BETWEEN '".$as."' AND '".$ae."'
                GROUP BY b.off_id)d  ON d.off_id=a.HOSPCODE ";
        $sql.=" WHERE CHILDDEVELOP IS NOT NULL AND a.AGE BETWEEN '".$as."' AND '".$ae."' AND DATE_FORMAT(a.DATE_SERV,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'";
        $sql.=" AND b.distid='".$amp."'";
        $sql.=" GROUP BY b.off_id";

        $rs=$this->db->query($sql)->result();
        return $rs;
    }public function get_child_develop_by_hospcode($s,$e,$as,$ae,$hospcode)
    {
        $sql=" SELECT b.off_id as id,b.off_name as name,count(a.CID) as total,";
        $sql.="SUM(IF(a.CHILDDEVELOP='1',1,0)) as D_1,SUM(IF(a.CHILDDEVELOP='2',1,0)) as D_2,SUM(IF(a.CHILDDEVELOP='3',1,0)) as D_3,";
        $sql.=" SUM(IF(a.FOOD='1',1,0)) as Food_1,SUM(IF(a.FOOD='2',1,0)) as Food_2,SUM(IF(a.FOOD='3',1,0)) as Food_3,SUM(IF(a.FOOD='4',1,0)) as Food_4";
        $sql.=" FROM nutrition_prc a ";
        $sql.=" JOIN co_office b ON a.HOSPCODE=b.off_id ";
        $sql.=" WHERE CHILDDEVELOP IS NOT NULL AND a.AGE BETWEEN '".$as."' AND '".$ae."' AND DATE_FORMAT(a.DATE_SERV,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'";
        $sql.=" AND b.off_id='".$hospcode."'";
        $sql.=" GROUP BY b.off_id";

        $rs=$this->db->query($sql)->result();
        return $rs;
    }
//############################ End CHILD DEVELOP

//############################ Start CHILD FAT

    public function get_child_fat($s,$e,$as,$ae)
    {
        $sql=" SELECT  b.distid as id,c.distname as name,";
        $sql.="SUM(IF(`lw` ='1', 1, 0)) AS lw1, SUM(IF(`lw`='2', 1, 0)) AS lw2, SUM(IF(`lw`='3', 1, 0)) AS lw3, ";
        $sql.="SUM(IF(`lw` ='4', 1, 0)) AS lw4, SUM(IF(`lw`='5', 1, 0)) AS lw5 ,count(lw) as Alls";
        $sql.=" FROM nutrition_prc a ";
        $sql.=" JOIN co_office b ON a.HOSPCODE=b.off_id ";
        $sql.=" JOIN co_district c ON b.distid=c.distid";
        $sql.=" WHERE a.AGE BETWEEN '".$as."' AND '".$ae."' AND DATE_FORMAT(a.DATE_SERV,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'";
        $sql.=" AND sex IN('1','2') AND TYPEAREA IN (1,3) AND dischar = '9' AND nation = '099'";
        $sql.=" GROUP BY c.distid";

        $rs=$this->db->query($sql)->result();
        return $rs;
    }
    public function get_child_fat_by_amp($s,$e,$as,$ae,$amp)
    {
        $sql=" SELECT  b.off_id as id,b.off_name as name, ";
        $sql.="SUM(IF(`lw` ='1', 1, 0)) AS lw1, SUM(IF(`lw`='2', 1, 0)) AS lw2, SUM(IF(`lw`='3', 1, 0)) AS lw3, ";
        $sql.="SUM(IF(`lw` ='4', 1, 0)) AS lw4, SUM(IF(`lw`='5', 1, 0)) AS lw5,count(lw) as Alls ";
        $sql.=" FROM nutrition_prc a ";
        $sql.=" JOIN co_office b ON a.HOSPCODE=b.off_id ";
        $sql.=" WHERE   a.AGE BETWEEN '".$as."' AND '".$ae."' AND DATE_FORMAT(a.DATE_SERV,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'";
        $sql.=" AND sex IN('1','2') AND TYPEAREA IN (1,3) AND dischar = '9' AND nation = '099'";
        $sql.=" AND b.distid='".$amp."'";
        $sql.=" GROUP BY b.off_id";

        $rs=$this->db->query($sql)->result();
        return $rs;
    }
    //############################ End CHILD Fat
//############################ Start CHILD HEIGHT

    public function get_child_height($s,$e,$as,$ae)
    {
        $sql=" SELECT  b.distid as id,c.distname as name,";
        $sql.="SUM(IF(`lh` ='1', 1, 0)) AS lh1, SUM(IF(`lh`='2', 1, 0)) AS lh2, SUM(IF(`lh`='3', 1, 0)) AS lh3, ";
        $sql.="SUM(IF(`lh` ='4', 1, 0)) AS lh4, SUM(IF(`lh`='5', 1, 0)) AS lh5 ,count(lh) as Alls";
        $sql.=" FROM nutrition_prc a ";
        $sql.=" JOIN co_office b ON a.HOSPCODE=b.off_id ";
        $sql.=" JOIN co_district c ON b.distid=c.distid";
        $sql.=" WHERE a.AGE BETWEEN '".$as."' AND '".$ae."' AND DATE_FORMAT(a.DATE_SERV,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'";
        $sql.=" AND sex IN('1','2') AND TYPEAREA IN (1,3) AND dischar = '9' AND nation = '099'";
        $sql.=" GROUP BY c.distid";

        $rs=$this->db->query($sql)->result();
        return $rs;
    }
    public function get_child_height_by_amp($s,$e,$as,$ae,$amp)
    {
        $sql=" SELECT  b.off_id as id,b.off_name as name, ";
        $sql.="SUM(IF(`lh` ='1', 1, 0)) AS lh1, SUM(IF(`lh`='2', 1, 0)) AS lh2, SUM(IF(`lh`='3', 1, 0)) AS lh3, ";
        $sql.="SUM(IF(`lh` ='4', 1, 0)) AS lh4, SUM(IF(`lh`='5', 1, 0)) AS lh5 ,count(lh) as Alls";
        $sql.=" FROM nutrition_prc a ";
        $sql.=" JOIN co_office b ON a.HOSPCODE=b.off_id ";
        $sql.=" WHERE  a.AGE BETWEEN '".$as."' AND '".$ae."' AND DATE_FORMAT(a.DATE_SERV,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'";
        $sql.=" AND sex IN('1','2') AND TYPEAREA IN (1,3) AND dischar = '9' AND nation = '099'";
        $sql.=" AND b.distid='".$amp."'";
        $sql.=" GROUP BY b.off_id";

        $rs=$this->db->query($sql)->result();
        return $rs;
    }
    //############################ End CHILD HEIGH

    //############################ Start Height Balance

    public function get_height_balance($s,$e,$as,$ae)
    {
        $sql=" SELECT b.distid as id,c.distname as name,";
        $sql.=" SUM(IF(((a.lh = 3 AND a.lwh = 3) OR (a.lh = 4 AND a.lwh = 3) OR (a.lh = 5 AND a.lwh = 3)) ,1,0)) as  Alls,COUNT(DISTINCT a.cid) AS total";
        $sql.=" FROM nutrition_prc a ";
        $sql.=" JOIN co_office b ON a.HOSPCODE=b.off_id ";
        $sql.=" JOIN co_district c ON b.distid=c.distid";
        $sql.=" WHERE a.AGE BETWEEN '".$as."' AND '".$ae."' AND DATE_FORMAT(a.DATE_SERV,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'";
        $sql.=" AND sex IN('1','2') AND TYPEAREA IN (1,3) AND dischar = '9' AND nation = '099'";
        $sql.=" GROUP BY c.distid";

        $rs=$this->db->query($sql)->result();
        return $rs;
    }
    public function get_height_balance_by_amp($s,$e,$as,$ae,$amp)
    {
        $sql=" SELECT b.off_id as id,b.off_name as name,";
        $sql.=" SUM(IF(((a.lh = 3 AND a.lwh = 3) OR (a.lh = 4 AND a.lwh = 3) OR (a.lh = 5 AND a.lwh = 3)) ,1,0)) as  Alls ,COUNT(DISTINCT a.cid) AS total";
        $sql.=" FROM nutrition_prc a ";
        $sql.=" JOIN co_office b ON a.HOSPCODE=b.off_id ";
        $sql.=" WHERE a.AGE BETWEEN '".$as."' AND '".$ae."' AND DATE_FORMAT(a.DATE_SERV,'%Y-%m-%d') BETWEEN '".$s."' AND '".$e."'";
        $sql.=" AND sex IN('1','2') AND TYPEAREA IN (1,3) AND dischar = '9' AND nation = '099'";
        $sql.=" AND b.distid='".$amp."'";
        $sql.=" GROUP BY b.off_id";

        $rs=$this->db->query($sql)->result();
        return $rs;
    }
    //############################ End Height Balance

    //############################ Start Labor
     public function get_labor($s,$e,$as,$ae){
            $sql=" SELECT  b.distid as id,b.distname as name,count(DISTINCT person.CID) total_cid,count(*) as total,";
            $sql.="(PERIOD_DIFF(DATE_FORMAT(labor.BDATE,'%Y%m'),DATE_FORMAT(person.birth,'%Y%m')) DIV 12) AS AGE";
            $sql.=" FROM labor ";
            $sql.=" INNER JOIN person ON labor.HOSPCODE = person.HOSPCODE AND labor.PID = person.PID ";
            $sql.=" JOIN co_office a  ON person.HOSPCODE=a.off_id ";
            $sql.=" JOIN co_district b ON a.distid=b.distid ";
            $sql.=" WHERE DATE_FORMAT(labor.BDATE, '%Y-%m-%d') BETWEEN '".$s."' AND '".$e."' ";
            $sql.=" group by a.distid ";
            $sql.=" HAVING AGE BETWEEN ".$as." AND ".$ae."; ";

         $rs=$this->hdc->query($sql)->result();
         return $rs;
     }
    public function get_labor_by_amp($s,$e,$as,$ae){
            $sql=" SELECT  a.off_id as id,b.distname as name,count(DISTINCT person.CID) total_cid,count(*) as total,";
            $sql.="(PERIOD_DIFF(DATE_FORMAT(labor.BDATE,'%Y%m'),DATE_FORMAT(person.birth,'%Y%m')) DIV 12) AS AGE";
            $sql.=" FROM labor ";
            $sql.=" INNER JOIN person ON labor.HOSPCODE = person.HOSPCODE AND labor.PID = person.PID ";
            $sql.=" JOIN co_office a  ON person.HOSPCODE=a.off_id ";
            $sql.=" WHERE DATE_FORMAT(labor.BDATE, '%Y-%m-%d') BETWEEN '".$s."' AND '".$e."' ";
            $sql.=" group by a.distid ";
            $sql.=" HAVING AGE BETWEEN ".$as." AND ".$ae."; ";

         $rs=$this->hdc->query($sql)->result();
         return $rs;
     }
    //############################ End Labor



}
/* End of file basic_model.php */
/* Location: ./application/models/basic_model.php */