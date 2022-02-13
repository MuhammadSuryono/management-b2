
$('#btnAdd_Member').click(function () {
    var data = $('#formAvailable').serialize();
    alert("Add Member alert");
    $.ajax({
        dataType: "json",
        type: 'ajax',
        method: 'POST',
        url: "<?php echo base_url('/kelompok/add_member');?>",
        async: false,
        data: data,
        success: function (msg) {
            available_list();
            member_list();
        }
    })
});

$('#btnDel_Member').click(function () {
    var data = $('#formMember').serialize();
    alert("Del Member alert");
    $.ajax({
        dataType: "json",
        type: 'ajax',
        method: 'POST',
        url: "<?php echo base_url('kelompok/delete_member');?>",
        async: false,
        data: data,
        success: function (msg) {
            available_list();
            member_list();
        }
    })
});


function available_list() {
    var project = $('#project').val();
    var modul = $('#modul').val();

    $.ajax({
        dataType: "json",
        type: 'ajax',
        method: 'GET',
        url: "<?php echo base_url('pembagian/available_member') ?>",
        async: false,
        data: {
            modul: modul
        },
        success: function (msg) {
            console.log(msg);
            var html = '';
            for (var i = 0; i < msg.length; i++) {
                html += '<tr>' +
                    '<td><input type="checkbox" name="id_submodul[]" id="id_sub[]" value="' + msg[i].id_submodul + '"></td>' +
                    '<td>' + msg[i].nama_submodul + '</td>' +
                    '<td>' + msg[i].harga + '</td>' +
                    '</tr>';
            }
            $('#available_member').html(html);
        }
    });
}

function member_list() {
    var project = $('#project').val();
    var modul = $('#modul').val();

    $.ajax({
        dataType: "json",
        type: 'ajax',
        method: 'GET',
        url: "<?php echo base_url('pembagian/dataAssign') ?>",
        async: false,
        data: {
            modul: modul
        },
        success: function (msg) {
            var html = '';
            for (var i = 0; i < msg.length; i++) {
                html += '<tr>' +
                    '<td><input type="checkbox" name="id_assign[]" id="id_sub[]" value="' + msg[i].id_assign + '"></td>' +
                    '<td>' + msg[i].nama_submodul + '</td>' +
                    '<td>' + addCommas(msg[i].harga) + '</td>' +
                    '</tr>';

            }

            $('#assign').html(html);
        }
    });
