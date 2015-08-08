<?php
/**
 * Created by JetBrains PhpStorm.
 * User: spiderman
 * Date: 31/12/2556
 * Time: 12:15 น.
 * To change this template use File | Settings | File Templates.
 */
?>
<ul class="breadcrumb">
    <li><a href="<?php echo site_url()?>">หน้าหลัก </a></li>
    <li ><a href="<?php echo site_url()."/audit/"?>">Audit </a></li>
   <li class="active"><a href="<?php echo site_url()."/audit/audit_hosp/"?>">Audit57 </a></li>
   </ul>
รายชื่อสถานบริการที่ได้รับ การ Audit 2557
<div class="navbar navbar-default">
    <form action="#" class="navbar-form">
        <select id="sl_office" style="width: 180px;" class="form-control">
            <option value=""> หน่วยบริการ </option>
            <?php
            foreach($audit as $r) {
                echo '<option value="' . $r->off_id . '">'.''.$r->off_id. ' : '. $r->off_name .'</option>';
            } ?>
        </select>
        <label> ตั้งแต่วันที่</label>
        <input type="text" id="date_start" data-type="date" class="form-control"
               placeholder="วว/ดด/ปปปป" title="เช่น 01/01/2556" data-rel="tooltip" style="width: 110px;">

        <label>ถึงวันที่</label>
        <input type="text" id="date_end" data-type="date" class="form-control"
               placeholder="วว/ดด/ปปปป" style="width: 110px;" title="เช่น 31/01/2556" data-rel="tooltip">

        <div class="btn-group">
            <button type="button" class="btn btn-primary" data-name="btn_show" data-type="all_op">All_OP</button>
            <button type="button" class="btn btn-primary" data-name="btn_show" data-type="op">
                OP
            </button>
            <button type="button" class="btn btn-primary" data-name="btn_show" data-type="dent">
                ทันตกรรม
            </button>
            <button type="button" class="btn btn-primary" data-name="btn_show" data-type="thaimed">
               </i>แผนไทย
            </button>
            <button type="button" class="btn btn-primary" data-name="btn_show" data-type="thaidrug">
                แผนไทย(ยา)
            </button>
            <button type="button" class="btn btn-primary" data-name="btn_show" data-type="chronic">
                DMHT
            </button>
            <button type="button" class="btn btn-primary" data-name="btn_show" data-type="epi">
                EPI</button>
        </div>
    </form>
</div>
<table class="table " id='tbl_list'>
    <thead>
    <tr>
        <th> ลำดับ</th>
        <th> ชื่อสถานบริการ</th>
        <th> HN</th>
        <th> CID</th>
        <th> SEX</th>
        <th> ชื่อ</th>
        <th> วันเกิด</th>
        <th> อายุ</th>
        <th> ที่อยู่</th>
        <th> จำนวนบริการ</th>
        <th> ประเภท</th>
    </tr>
    </thead>
    <tbody>

    </tbody>
</table>
<script src="<?php echo base_url()?>assets/apps/js/audit.audit_hosp.js" charset="utf-8"></script>
<script src="<?php echo base_url()?>assets/apps/js/basic.js" charset="utf-8"></script>