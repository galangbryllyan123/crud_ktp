$(function () {
    $('#provinsi').select2({
        theme: 'bootstrap4'
    });
    $('#kabupaten').select2({
        theme: 'bootstrap4'
    });
    $('#kecamatan').select2({
        theme: 'bootstrap4'
    });
    $('#pekerjaan').select2({
        theme: 'bootstrap4'
    });
});
$(function () {
    $("#tgl_lahir").on("keyup change", function(){
        var date = this.value.split('-');
        var newDate = date[2] + '' + date[1] + '' + date[0].slice(-2);
        $("#code_date").val(newDate);
        getNik();
    });
    $("#provinsi").on("change", function(){
        $("#kabupaten").html('<option value=""></option>');
        $("#kecamatan").html('<option value=""></option>');
        $("#nik").val('');
        var _token = $("input[name='_token']").val();
        var prov = $("#provinsi").val();
        $.ajax({
            url: BASE_URL+"/get-province",
            type:'POST',
            data: {_token:_token, prov:prov},
            success: function(data) {
                getCities(data.province.code);
            }
        });
    });
    $("#kabupaten").on("change", function(){
        $("#kecamatan").html('<option value=""></option>');
        $("#nik").val('');
        var _token = $("input[name='_token']").val();
        var kab = $("#kabupaten").val();
        $.ajax({
            url: BASE_URL+"/get-city",
            type:'POST',
            data: {_token:_token, kab:kab},
            success: function(data) {
                getDistricts(data.city.code);
            }
        });
    });
    $("#kecamatan").on("change", function(){
        $("#nik").val('');
        var _token = $("input[name='_token']").val();
        var kec = $("#kecamatan").val();
        $.ajax({
            url: BASE_URL+"/get-code",
            type:'POST',
            data: {_token:_token, kec:kec},
            success: function(data) {
                var code = data.districts.code;
                $("#code_district").val(code.replace(/\./g, ''));
                getNik();
            }
        });
    });
});

function getCities(code_province) {
    var _token = $("input[name='_token']").val();
    $.ajax({
        url: BASE_URL+"/get-cities",
        type:'POST',
        data: {_token:_token, code_province:code_province},
        success: function(data) {
            var html = '<option value=""></option>';
            $.each(data.cities, function(i, item) {
                html += "<option value=\""+item.id+"\">"+item.name+"</option>"
            });
            $("#kabupaten").html(html);
            $('#kabupaten').select2({
                theme: 'bootstrap4'
            });
        }
    });
}

function getDistricts(code_city) {
    var _token = $("input[name='_token']").val();
    $.ajax({
        url: BASE_URL+"/get-districts",
        type:'POST',
        data: {_token:_token, code_city:code_city},
        success: function(data) {
            var html = '<option value=""></option>';
            $.each(data.districts, function(i, item) {
                html += "<option value=\""+item.id+"\">"+item.name+"</option>"
            });
            $("#kecamatan").html(html);
            $('#kecamatan').select2({
                theme: 'bootstrap4'
            });
        }
    });
}

function getNik() {
    var code_district = $("#code_district").val();
    var code_date = $("#code_date").val();
    if (code_district != '' && code_date != '') {
        var nik = code_district+code_date+'0001';
        $.ajax({
            url: BASE_URL+"/check-nik/"+nik,
            type:'GET',
            success: function(data) {
                $("#nik").val(data.nik);
            }
        });
    }
}