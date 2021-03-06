$(function () {

    var changwat = {};

    changwat.modal = {
        show_info: function () {
            $('#mdl_info').modal({
                keyboard: false,
                backdrop: 'static'
            })
        },

        show_approve: function () {
            $('#mdl_approve').modal({
                keyboard: false,
                backdrop: 'static'
            })
        },
        hide_approve: function() {
            $('#mdl_approve').modal('hide');
        }
    };

    changwat.ajax = {
        get_list: function (start, stop, cb) {
            var url = '/changwat/get_list',
                params = {
                    start: start,
                    stop: stop
                }

            app.ajax(url, params, function (err, data) {
                err ? cb(err) : cb(null, data);
            });
        },

        get_list_total: function (cb) {
            var url = '/changwat/get_list_total',
                params = {}

            app.ajax(url, params, function (err, data) {
                err ? cb(err) : cb(null, data);
            });
        },

        get_waiting_list: function (start, stop, cb) {
            var url = '/changwat/get_waiting_list',
                params = {
                    start: start,
                    stop: stop
                }

            app.ajax(url, params, function (err, data) {
                err ? cb(err) : cb(null, data);
            });
        },
        get_waiting_list_total: function (cb) {
            var url = '/changwat/get_waiting_list_total',
                params = {}

            app.ajax(url, params, function (err, data) {
                err ? cb(err) : cb(null, data);
            });
        },

        get_detail: function (id, cb) {
            var url = '/changwat/get_detail',
                params = {
                    id: id
                }

            app.ajax(url, params, function (err, data) {
                err ? cb(err) : cb(null, data);
            });
        },
        do_approve: function (id, code506, cb) {
            var url = '/changwat/do_approve',
                params = {
                    id: id,
                    code506: code506
                }

            app.ajax(url, params, function (err, data) {
                err ? cb(err) : cb(null, data);
            });
        },
        get_changwat_list: function (chw, cb) {
            var url = '/basic/get_changwat_list',
                params = {
                    chw: chw
                }

            app.ajax(url, params, function (err, data) {
                err ? cb(err) : cb(null, data);
            });
        },
        get_ampur_list: function (chw, cb) {
        var url = '/basic/get_ampur_list',
            params = {
                chw: chw
            }

        app.ajax(url, params, function (err, data) {
            err ? cb(err) : cb(null, data);
        });
    },get_tambon_list: function (chw, amp, cb) {
            var url = '/basic/get_tambon_list',
                params = {
                    chw: chw,
                    amp: amp
                }

            app.ajax(url, params, function (err, data) {
                err ? cb(err) : cb(null, data);
            });
        },
        get_organism_list: function (code506, cb) {
            var url = '/basic/get_organism_list',
                params = {
                    code506: code506
                }

            app.ajax(url, params, function (err, data) {
                err ? cb(err) : cb(null, data);
            });
        }
    }

    changwat.set_list = function (data) {
        $('#tbl_list > tbody').empty();
        if (_.size(data.rows) > 0) {
            _.each(data.rows, function (v) {

                var ptstatus = v.ptstatus == '1' ? 'หาย' : v.ptstatus == '2' ? 'ตาย' : v.ptstatus == '3' ? 'ยังรักษาอยู่' : v.ptstatus== '9' ? 'ไม่ทราบ' : '-';
                var tr_death = v.ptstatus == '2' ? 'class="danger"' : '';
                $('#tbl_list > tbody').append(
                    '<tr class="'+tr_death+'">' +
                        '<td>' + v.e0 + '</td>' +
                        '<td>' + v.e1 + '</td>' +
                        '<td>' + v.datesick + '</td>' +
                        '<td>' + v.cid + '</td>' +
                        '<td>' + v.name + '</td>' +
                        '<td>' + v.birth + '</td>' +
                        '<td>' + v.age + '</td>' +
                        '<td>' + ptstatus + '</td>' +
                        '<td>' + app.strip(v.code506, 45) + '</td>' +
                        '<td>' + v.hospcode + ' ' + app.strip(v.hospname, 20) + '</td>' +
                        '<td><a href="javascript:void(0);" class="btn btn-small btn-success" data-id="' + v.id + '" ' +
                        'data-name="btn_get_detail"><i class="glyphicon glyphicon-edit"></i></a></td>' +
                        '</tr>'
                );
            });
        }
        else {
            $('#tbl_list > tbody').append('<tr><td colspan="11">ไม่พบรายการ</td></tr>');
        }
    };

    changwat.get_list = function () {

        $('#tbl_patient_list > tbody').empty();

        changwat.ajax.get_list_total(function (err, data) {
            if (err) {
                app.alert(err);
                $('#tbl_patient_list > tbody').append('<tr><td colspan="8">ไม่พบรายการ</td></tr>');
            } else {
                $('#spn_total').html(app.add_commars_with_out_decimal(data.total));
                $('#main_paging').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 0,
                    page: app.get_cookie('changwat_index_paging'),
                    onSelect: function (page) {
                        app.set_cookie('changwat_index_paging', page);
                        changwat.ajax.get_list(this.slice[0], this.slice[1], function (err, data) {
                            if (err) {
                                app.alert(err);
                                $('#tbl_patient_list > tbody').append('<tr><td colspan="8">ไม่พบรายการ</td></tr>');
                            } else {
                                changwat.set_list(data);
                            }
                        });

                    },
                    onFormat: function (type) {
                        switch (type) {

                            case 'block':

                                if (!this.active)
                                    return '<li class="disabled"><a href="">' + this.value + '</a></li>';
                                else if (this.value != this.page)
                                    return '<li><a href="#' + this.value + '">' + this.value + '</a></li>';
                                return '<li class="active"><a href="#">' + this.value + '</a></li>';

                            case 'right':
                            case 'left':

                                if (!this.active) {
                                    return "";
                                }
                                return '<li><a href="#' + this.value + '">' + this.value + '</a></li>';

                            case 'next':

                                if (this.active) {
                                    return '<li><a href="#' + this.value + '">&raquo;</a></li>';
                                }
                                return '<li class="disabled"><a href="">&raquo;</a></li>';

                            case 'prev':

                                if (this.active) {
                                    return '<li><a href="#' + this.value + '">&laquo;</a></li>';
                                }
                                return '<li class="disabled"><a href="">&laquo;</a></li>';

                            case 'first':

                                if (this.active) {
                                    return '<li><a href="#' + this.value + '">&lt;</a></li>';
                                }
                                return '<li class="disabled"><a href="">&lt;</a></li>';

                            case 'last':

                                if (this.active) {
                                    return '<li><a href="#' + this.value + '">&gt;</a></li>';
                                }
                                return '<li class="disabled"><a href="">&gt;</a></li>';

                            case 'fill':
                                if (this.active) {
                                    return '<li class="disabled"><a href="#">...</a></li>';
                                }
                        }
                        return ""; // return nothing for missing branches
                    }
                });
            }
        });
    };

    $('#btn_refresh').on('click', function () {
        changwat.get_list();
    });

    $('a[href="#tab_wait"]').on('click', function () {
        changwat.get_waiting_list();
    });

    $('a[href="#tab_patient"]').on('click', function () {
        changwat.get_list();
    });

    changwat.get_waiting_list = function () {
        changwat.ajax.get_waiting_list_total(function (err, data) {
            if (err) {
                app.alert(err);
                $('#tbl_waiting_list > tbody').empty();
                $('#tbl_waiting_list > tbody').append('<tr><td colspan="7">ไม่พบรายการ</td></tr>');
            } else {
                $('#spn_wait').html(app.add_commars_with_out_decimal(data.total));

                $('#waiting_paging').paging(data.total, {
                    format: " < . (qq -) nnncnnn (- pp) . >",
                    perpage: app.record_per_page,
                    lapping: 1,
                    page: app.get_cookie('changwat_index_wait_paging'),
                    onSelect: function (page) {
                        app.set_cookie('changwat_index_wait_paging', page);
                        changwat.ajax.get_waiting_list(this.slice[0], this.slice[1], function (err, data) {
                            if (err) {
                                app.alert(err);
                                $('#tbl_waiting_list > tbody').empty();
                                $('#tbl_waiting_list > tbody').append('<tr><td colspan="7">ไม่พบรายการ</td></tr>');
                            } else {
                                changwat.set_waiting_list(data);
                            }
                        });

                    },
                    onFormat: function (type) {
                        switch (type) {

                            case 'block':

                                if (!this.active)
                                    return '<li class="disabled"><a href="">' + this.value + '</a></li>';
                                else if (this.value != this.page)
                                    return '<li><a href="#' + this.value + '">' + this.value + '</a></li>';
                                return '<li class="active"><a href="#">' + this.value + '</a></li>';

                            case 'right':
                            case 'left':

                                if (!this.active) {
                                    return "";
                                }
                                return '<li><a href="#' + this.value + '">' + this.value + '</a></li>';

                            case 'next':

                                if (this.active) {
                                    return '<li><a href="#' + this.value + '">&raquo;</a></li>';
                                }
                                return '<li class="disabled"><a href="">&raquo;</a></li>';

                            case 'prev':

                                if (this.active) {
                                    return '<li><a href="#' + this.value + '">&laquo;</a></li>';
                                }
                                return '<li class="disabled"><a href="">&laquo;</a></li>';

                            case 'first':

                                if (this.active) {
                                    return '<li><a href="#' + this.value + '">&lt;</a></li>';
                                }
                                return '<li class="disabled"><a href="">&lt;</a></li>';

                            case 'last':

                                if (this.active) {
                                    return '<li><a href="#' + this.value + '">&gt;</a></li>';
                                }
                                return '<li class="disabled"><a href="">&gt;</a></li>';

                            case 'fill':
                                if (this.active) {
                                    return '<li class="disabled"><a href="#">...</a></li>';
                                }
                        }
                        return ""; // return nothing for missing branches
                    }
                });
            }
        });
    };

    changwat.set_waiting_list = function (data) {

        $('#tbl_waiting_list > tbody').empty();

        if (_.size(data.rows) > 0) {
            var i = 1;

            _.each(data.rows, function (v) {
                var tr_death = v.ptstatus == '2' ? 'class="danger"' : '';
                //var chk_import = v.RECORD_STATUS == '1' || v.RECORD_STATUS == '2' ? '<input type="checkbox" disabled>' : '<input type="checkbox" data-name="chk_import" data-id="' + v.ID + '">';
                var ptstatus = v.ptstatus == '1' ? 'หาย' : v.ptstatus == '2' ? 'ตาย' : v.ptstatus == '3' ? 'ยังรักษาอยู่' : v.ptstatus== '9' ? 'ไม่ทราบ' : '-';

                $('#tbl_waiting_list > tbody').append(
                    '<tr ' + tr_death + '>' +
                        '<td>' + v.datesick+'</td>' +
                        '<td>' + app.clear_null(v.cid) + '</td>' +
                        '<td>' + app.clear_null(v.name) + '</td>' +
                        '<td>' + app.clear_null(v.birth) + '</td>' +
                        '<td>' + v.age + '</td>' +
                        //'<td>' + ptstatus + '</td>' +
                        '<td>' + v.code506 + ' ' + app.strip(v.code506_name, 40) + '</td>' +
                        '<td>' + v.hospcode + ' ' + app.strip(v.hospname, 20) + '</td>' +
                        '<td><div class="btn-group">' +
                        '<a href="javascript:void(0);" class="btn btn-default" data-id="' + v.id + '" data-code506="' + v.code506 + '" ' +
                        'data-name="btn_approve" data-ptname="' + v.name + '"><i class="glyphicon glyphicon-check"></i></a>' +
                        '<a href="javascript:void(0);" class="btn btn-default" data-id="' + v.id + '"' +
                        'data-name="btn_detail" ><i class="glyphicon glyphicon-info-sign"></i></a>' +
                        '</div></td>' +
                        '</tr>'
                );
                i++;
            });
        }
        else {
            $('#tbl_waiting_list > tbody').append('<tr><td colspan="8">ไม่พบรายการ</td></tr>');
        }

    };

    $(document).on('click', 'a[data-name="btn_approve"]', function(e) {
        e.preventDefault();

        var ptname = $(this).data('ptname');
        var id = $(this).data('id');
        var code506 = $(this).data('code506');

        $('#txt_ap_id').val(id);
        $('#txt_ap_code506').val(code506);
        $('#txt_ap_ptname').html(ptname);

        changwat.modal.show_approve();
    });

    $('#btn_do_approve').on('click', function(e) {
        e.preventDefault();

        var id = $('#txt_ap_id').val();
        var code506 = $('#txt_ap_code506').val();

        if(!id) {
            app.alert('กรุณาระบุรหัส');
        } else {
            changwat.ajax.do_approve(id, code506, function(e) {
                if(e) {
                    app.alert(e);
                } else {
                    app.alert('ยืนยันข้อมูลเสร็จเรียบร้อยแล้ว');
                    changwat.modal.hide_approve();
                    changwat.get_waiting_list();
                    changwat.get_list();
                }
            });
        }
    });

    $(document).on('click', 'a[data-name="btn_detail"]', function(e) {
        e.preventDefault();

        var id = $(this).data('id');

        changwat.get_detail(id);
    });

    changwat.get_detail = function (id) {

        changwat.ajax.get_detail(id, function (err, data) {
            if (err) {
                app.alert(err);
            } else {
                changwat.set_detail(data.rows);
                changwat.modal.show_info();
            }
        });

    };

    changwat.get_organism = function (code506, org) {

        changwat.ajax.get_organism_list(code506, function (err, data) {
            $('#sl_organism').empty();
            if (!err) {
                _.each(data.rows, function (v) {
                    if (org == v.code)
                        $('#sl_organism').append('<option value="' + v.code + '" selected="selected">' + v.name + '</option>');
                    $('#sl_organism').append('<option value="' + v.code + '">' + v.name + '</option>');
                });
            }
        });

    };

    changwat.clear_form = function () {
        $('#txt_edit_id').val('');
        $('#txt_name').val('');
        $('#txt_lname').val('');
        $('#txt_cid').val('');
        $('#txt_birth').val('');
        $('#txt_age').val('');
        app.set_first_selected($('#sl_sex'));
        $('#sl_sex').removeProp('disabled');
        $('#txt_hn').val('');
        $('#txt_nmepate').val('').removeProp('disabled');

        app.set_first_selected($('#sl_mstatus'));
        app.set_first_selected($('#sl_nations'));
        app.set_first_selected($('#sl_occupation'));

        $('#sl_mstatus').removeProp('disabled');
        $('#sl_nations').removeProp('disabled');
        $('#sl_occupation').removeProp('disabled');

        $('#txt_address').val('').removeProp('disabled');
        $('#txt_soi').val('').removeProp('disabled');
        $('#txt_road').val('').removeProp('disabled');
        app.set_first_selected($('#sl_changwat'));

        $('#sl_changwat').removeProp('disabled');
        $('#sl_ampur').empty().removeProp('disabled');
        $('#sl_tambon').empty().removeProp('disabled');

        app.set_first_selected($('#sl_moo'));
        app.set_first_selected($('#sl_address_type'));

        $('#sl_address_type').removeProp('disabled');
        $('#sl_moo').removeProp('disabled');

        $('#sl_service_place').removeProp('disabled');
        $('#sl_patient_type').removeProp('disabled');

        $('#txt_school').val('').removeProp('disabled');
        $('#txt_school_class').val('').removeProp('disabled');
        $('#txt_illdate').val('');
        $('#txt_date_serv').val('');

        app.set_first_selected($('#sl_patient_type'));
        app.set_first_selected($('#sl_service_place'));

        $('#txt_icd10_code').val('');
        $('#txt_icd10_name').val('');

        app.set_first_selected($('#sl_code506'));
        app.set_first_selected($('#sl_ptstatus'));

        $('#sl_code506').removeProp('disabled');
        $('#sl_ptstatus').removeProp('disabled');
        $('#sl_complication').removeProp('disabled');
        $('#sl_organism').removeProp('disabled');


        $('#txt_date_death').val('').removeProp('disabled');
        $('#txt_date_record').val('').removeProp('disabled');
        $('#txt_date_report').val('').removeProp('disabled');

        $('#btn_save').fadeIn('slow');
    };

    changwat.set_detail = function (v) {

        var ptname = v.name.split(' ');

        $('#txt_edit_id').val(v.id);
        $('#txt_name').val(ptname[0]);
        $('#txt_lname').val(ptname[1]);
        $('#txt_cid').val(v.cid);
        $('#txt_birth').val(v.birth);
        $('#txt_age').val(v.age.year + '-' + v.age.month + '-' + v.age.day);
        $('#sl_sex').val(v.sex);
        $('#txt_hn').val(v.hn);
        $('#txt_nmepate').val(v.nmepate);
        $('#sl_mstatus').val(v.mstatus);
        $('#sl_nations').val(v.nation);
        $('#sl_occupation').val(v.occupation);
        $('#txt_address').val(v.address);
        $('#txt_soi').val(v.soi);
        $('#txt_road').val(v.road);
        $('#sl_changwat').val(v.chw);
        changwat.get_ampur_list(v.chw, v.amp);
        changwat.get_tambon_list(v.chw, v.amp, v.tmb);
        $('#sl_moo').val(v.moo);
        $('#sl_address_type').val(v.address_type);
        $('#txt_school').val(v.school);
        $('#txt_school_class').val(v.school_class);
        $('#txt_illdate').val(v.illdate);
        $('#txt_date_serv').val(v.date_serv);
        $('#sl_patient_type').val(v.patient_type);
        $('#sl_service_place').val(v.service_place);
        $('#txt_icd10_code').val(v.diagcode);
        $('#txt_icd10_name').val(v.diagname);
        $('#sl_code506').val(v.code506);
        $('#txt_e0_code506').val(v.code506);
        $('#sl_organism');
        changwat.get_organism(v.code506, v.organism);
        $('#sl_complication').val(v.complication);
        $('#sl_ptstatus').val(v.ptstatus);
        if (v.ptstatus == '2') $('#div_date_death').fadeIn('slow');
        $('#txt_date_death').val(v.date_death);
        $('#txt_date_record').val(v.date_record);
        $('#txt_date_report').val(v.date_report);
    };

    changwat.get_ampur_list = function (chw, amp) {

        $('#sl_ampur').empty();

        changwat.ajax.get_ampur_list(chw, function (err, data) {
            if (!err) {
                $('#sl_ampur').append('<option value="">-*-</option>');
                _.each(data.rows, function (v) {
                    if (v.code == amp)
                        $('#sl_ampur').append('<option value="' + v.code + '" selected="selected">[' + v.code + '] ' + v.name + '</option>');

                    $('#sl_ampur').append('<option value="' + v.code + '">[' + v.code + '] ' + v.name + '</option>');
                });
            }
        });

    };

    changwat.get_tambon_list = function (chw, amp, tmb) {

        $('#sl_tambon').empty();

        changwat.ajax.get_tambon_list(chw, amp, function (err, data) {
            if (!err) {
                $('#sl_tambon').append('<option value="">-*-</option>');
                _.each(data.rows, function (v) {
                    if (v.code == tmb)
                        $('#sl_tambon').append('<option value="' + v.code + '" selected="selected">[' + v.code + '] ' + v.name + '</option>');

                    $('#sl_tambon').append('<option value="' + v.code + '">[' + v.code + '] ' + v.name + '</option>');
                });
            }
        });

    };

    changwat.get_moo_list = function (chw, amp, tmb, moo) {

        $('#sl_moo').empty();

        changwat.ajax.get_moo_list(chw, amp, tmb, function (err, data) {
            if (!err) {
                $('#sl_moo').append('<option value="">-*-</option>');
                _.each(data.rows, function (v) {
                    if (v.code == moo)
                        $('#sl_moo').append('<option value="' + v.code + '" selected="selected">[' + v.code + '] ' + v.name + '</option>');

                    $('#sl_moo').append('<option value="' + v.code + '">[' + v.code + '] ' + v.name + '</option>');
                });
            }
        });

    };

    $('#mdl_edit_for_approve').on('hidden.bs.modal', function () {
        changwat.clear_form();
    })

    changwat.clear_form = function () {
        $('#txt_edit_id').val('');
        $('#txt_name').val('');
        $('#txt_lname').val('');
        $('#txt_cid').val('');
        $('#txt_birth').val('');
        $('#txt_age').val('');
        app.set_first_selected($('#sl_sex'));
        $('#sl_sex').removeProp('disabled');
        $('#txt_hn').val('');
        $('#txt_nmepate').val('').removeProp('disabled');

        app.set_first_selected($('#sl_mstatus'));
        app.set_first_selected($('#sl_nations'));
        app.set_first_selected($('#sl_occupation'));

        $('#sl_mstatus').removeProp('disabled');
        $('#sl_nations').removeProp('disabled');
        $('#sl_occupation').removeProp('disabled');

        $('#txt_address').val('').removeProp('disabled');
        $('#txt_soi').val('').removeProp('disabled');
        $('#txt_road').val('').removeProp('disabled');
        app.set_first_selected($('#sl_changwat'));

        $('#sl_changwat').removeProp('disabled');
        $('#sl_ampur').empty().removeProp('disabled');
        $('#sl_tambon').empty().removeProp('disabled');

        app.set_first_selected($('#sl_moo'));
        app.set_first_selected($('#sl_address_type'));

        $('#sl_address_type').removeProp('disabled');
        $('#sl_moo').removeProp('disabled');

        $('#sl_service_place').removeProp('disabled');
        $('#sl_patient_type').removeProp('disabled');

        $('#txt_school').val('').removeProp('disabled');
        $('#txt_school_class').val('').removeProp('disabled');
        $('#txt_illdate').val('');
        $('#txt_date_serv').val('');

        app.set_first_selected($('#sl_patient_type'));
        app.set_first_selected($('#sl_service_place'));

        $('#txt_icd10_code').val('');
        $('#txt_icd10_name').val('');

        app.set_first_selected($('#sl_code506'));
        app.set_first_selected($('#sl_ptstatus'));

        $('#sl_code506').removeProp('disabled');
        $('#sl_ptstatus').removeProp('disabled');
        $('#sl_complication').removeProp('disabled');
        $('#sl_organism').removeProp('disabled');


        $('#txt_date_death').val('').removeProp('disabled');
        $('#txt_date_record').val('').removeProp('disabled');
        $('#txt_date_report').val('').removeProp('disabled');

        $('#btn_save').fadeIn('slow');
    };

    $('#btn_save').on('click', function () {
        var items = {};
        items.id = $('#txt_e0_id').val();
        items.code506=$('#txt_e0_code506').val();
            if (confirm('คุณต้องการบันทึกรายการใช่หรือไม่?')) {
                changwat.ajax.save(items, function (err) {
                    if (err) {
                        app.alert(err);
                    } else {
                        app.alert('บันทึกรายการเสร็จเรียบร้อยแล้ว');
                        changwat.clear_form();
                        changwat.modal.hide_approve()
                        changwat.get_waiting_list();
                    }
                });
            }

    });

    changwat.ajax.get_waiting_list_total(function (err, v) {

        $('#spn_wait').html(app.add_commars_with_out_decimal(v.total));

    });

    changwat.get_list();

    app.set_runtime();
});