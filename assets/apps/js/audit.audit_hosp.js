$(document).ready(function(){
    //User namespace
    var audit = {};
    audit.ajax = {
        get_audit_hosp: function (items,type, cb) {
            var url = '/audit/get_audit_hosp',
                params = {
                    items: items,
                    type:type
                }

            app.ajax(url, params, function (err, data) {
                err ? cb(err) : cb(null, data);
            });
        }

    };

    audit.modal = {
        show_mom_info: function () {
            $('#mdl_mom_info').modal({
                keyboard: false,
                backdrop: 'static'
            })
        },
        hide_message: function() {
            $('#mdl_message').modal('hide');
        }
    };

audit.get_audit_hosp = function(items,type){
        $('#tbl_list > tbody').empty();
        audit.ajax.get_audit_hosp(items,type, function (err, data) {
                audit.set_audit_hosp(data);
        });

    }

audit.set_audit_hosp=function(data){

        if (_.size(data.rows) > 0) {

            var no= 1,total_time= 0,total= 0,total_in= 0,total_out=0;
            _.each(data.rows, function (v) {

                $('#tbl_list > tbody').append(
                    '<tr>' +
                        '<td>' + no + '</td>' +

                        '<td>' + v.off_name + '</td>' +
                        '<td>' + v.pid + '</td>' +
                        '<td>' + v.cid + '</td>' +
                        '<td>' + v.sex + '</td>' +
                        '<td>' + v.ptname + '</td>' +
                        '<td>' + v.birth + '</td>' +
                        '<td>' + v.age + '</td>' +
                        '<td>' + v.address + '</td>' +
                        '<td>' + v.total + '</td>' +
                        '<td>' + v.type + '</td>' +
                        '</tr>'
                );
                no=no+1;

            });
        }
        else {
            $('#tbl_list > tbody').append('<tr><td colspan="8">ไม่พบรายการ</td></tr>');
        }

}


    $(document).on('click', 'button[data-name="btn_show"]', function(e) {
        e.preventDefault();
        var p_type = $(this).data('type');
        //alert(p_type);
        //alert('Show audit');
        var items={};
        items.hospcode= $('#sl_office').val();
        //items.year=$('#year').val();
        items.date_start=$('#date_start').val();
        items.date_end=$('#date_end').val();

        if(!items.hospcode){
            app.alert('กรุณาระบุหน่วยบริการ');
            $('#sl_office').focus();
        }else if(!items.date_start){
            app.alert('กรุณาระบุวันเริ่มต้น');
            $('#date_start').focus();
        }else if(!items.date_end){
            app.alert('กรุณาระบุวันสิ้นสุด');
            $('#date_end').focus()
        }else{
            $('#tbl_list > tbody').empty();
            //alert(p_type);
            if(p_type=='all_op'){
                audit.get_audit_hosp(items,'op');
                audit.get_audit_hosp(items,'dent');
                audit.get_audit_hosp(items,'dm');
                audit.get_audit_hosp(items,'ht');
                audit.get_audit_hosp(items,'thaimed');
            }else if(p_type=='op'){
                audit.get_audit_hosp(items,'op');
            }else if(p_type=='dent'){
                audit.get_audit_hosp(items,'dent');
            }else if(p_type=='thaimed'){
                audit.get_audit_hosp(items,'thaimed');
            }else if(p_type=='thaidrug'){
                audit.get_audit_hosp(items,'thaidrug');
            }else if(p_type=='chronic'){
                audit.get_audit_hosp(items,'dm');
                audit.get_audit_hosp(items,'ht');
            }else if(p_type=='epi'){
            audit.get_audit_hosp(items,'epi1');
            audit.get_audit_hosp(items,'epi2');
            audit.get_audit_hosp(items,'epi3');
            audit.get_audit_hosp(items,'epi5');
            }

        }


    });

});