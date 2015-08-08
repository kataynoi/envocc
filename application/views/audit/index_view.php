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
    <li class="active"><a href="<?php echo site_url()."/audit/"?>">Audit </a></li>
   </ul>
รายชื่อสถานบริการที่ได้รับ การ Audit 2557
<table class="table table-bordered ">
    <thead>
    <tr>
        <th> ลำดับที่</th>
        <th> หน่วยบริการ</th>
        <th> อำเภอ</th>
        <th> วันที่</th>
        <th> หมายเหตุ</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $no=1;
    foreach($audit as $r) {
        echo '<tr><td>'.$no.'</td><td>' . $r->off_id . ':'.$r->off_name. '</td><td>'.$r->distname.'</td><td>'. to_thai_date($r->event_date) .'</td><td>'.$r->memo.'</td></tr>';
    $no++;
    } ?>
    </tbody>
</table>