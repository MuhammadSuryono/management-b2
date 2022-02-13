<script>
$("#btn_Close_absensi").click(function(){
    var d = new Date();
	var jam_tutup=d.getHours() + ":" + d.getMinutes();
	$("#absen_tutup").val(jam_tutup);
});
</script>
