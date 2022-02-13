<input type="hidden" id="kegiatan_id" name="kegiatan_id" 
value="0">

@error('kegiatan_id')
<div class="alert alert-danger" align="center" role="alert">
    <strong>Invalid QR</strong>
</div>
@enderror
<video id="preview"></video>

<script type="text/javascript">
  var vkegiatanid = document.getElementById("kegiatan_id");
  var vqrscan_form = document.getElementById("qrscan_form");

  let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
  scanner.addListener('scan', function (content) {
    vkegiatanid.value=content; 
    vqrscan_form.submit();
  });
  Instascan.Camera.getCameras().then(function (cameras) {
    if (cameras.length > 0) {
      scanner.start(cameras[0]);
    } else {
      console.error('No cameras found.');
    }
  }).catch(function (e) {
    console.error(e);
  });
</script>
