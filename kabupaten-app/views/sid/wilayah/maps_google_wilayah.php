<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://cdn.jsdelivr.net/gh/somanchiu/Keyless-Google-Maps-API@v5.7/mapsJavaScriptAPI.js" async defer></script>
<script>
  $(document).ready(function()
  {
    $('#simpan_wilayah').click(function()
    {
      var path = $('#path').val();
      $.ajax(
      {
        type: "POST",
        url: "<?=$form_action?>",
        dataType: 'json',
        data: {path},
      })
        .always(function (e) {
          alert('Perubahan yang dilakukan telah berhasil disimpan! Klik Kembali untuk pindah ke halaman sebelumnya!')
        });
    });
  });

  var batasWilayah
  var map
  var gmaps

  var daerah_kecamatan = <?=$wil_ini['path'] ?: 'null' ?>

  daerah_kecamatan && daerah_kecamatan[0].map((arr, i) => {
    daerah_kecamatan[i] = { lat: arr[0], lng: arr[1] }
  })

  function initMap() {
    gmaps = google.maps

    <?php if (!empty($wil_ini['lat']) && !empty($wil_ini['lng'])): ?>
        var center = {
            lat: <?=$wil_ini['lat']?>,
            lng: <?=$wil_ini['lng']?>
        }
    <?php else: ?>
        var center = {
            lat: <?=$wil_atas['lat']?>,
            lng: <?=$wil_atas['lat']?>
        }
    <?php endif; ?>
	
    
    var zoom = 13;
    map = new gmaps.Map($('#map')[0], {
      center,
      zoom,
      streetViewControl: true,
      mapTypeId:google.maps.MapTypeId.HYBRID,
    })
    
    <?php if (!empty($wil_ini['path'])): ?>
      //Style polygon
      batasWilayah = new gmaps.Polygon({
        paths: daerah_kecamatan,
        strokeColor: '#d10563',
        strokeOpacity: 1,
        strokeWeight: 3,
        fillColor: '#0028ea',
        fillOpacity: 0.15,
        editable: true,
        draggable: false
      });

      batasWilayah.setMap(map)
      batasWilayah.addListener('mouseup', editPath)
      batasWilayah.addListener('dragend', editPath)
    <?php endif; ?>
  }

  function editPath() {
    const PATHS = this.getPath()
    const NEWPATH = []
    
    for (var i = 0; i < PATHS.getLength(); i++) {
      const { lat, lng } = PATHS.getAt(i)
      NEWPATH.push([lat(), lng()])
    }

    $('#path').val(JSON.stringify([NEWPATH]))
  }

  function polygonDelete() {
    batasWilayah.setMap(null)
    batasWilayah = null
    $('#path').val(null);
  }

  function polygonAdd() {
    const { lat, lng } = map.getCenter()

    // Clear existing polygon
    if (batasWilayah) polygonDelete()

    // Re new polygon in new position
    batasWilayah = new gmaps.Polygon({
      paths: [
        { lat: lat() - 0.001,   lng: lng() - 0.002 }, // Left
        { lat: lat() + 0.001, lng: lng() - 0.002 }, // Right
        { lat: lat() + 0.001, lng: lng() },         // Top
      ],
      strokeColor: '#d10563',
      strokeOpacity: 1,
      strokeWeight: 3,
      fillColor: '#0028ea',
      fillOpacity: 0.15,
      editable: true,
      draggable: false
    });

    batasWilayah.setMap(map)
    batasWilayah.addListener('mouseup', editPath)
    batasWilayah.addListener('dragend', editPath)
  }

  function polygonReset() {
    // Clear existing polygon
    polygonDelete()

    // Create initial / last saved polygon
    batasWilayah = new gmaps.Polygon({
      paths: daerah_kecamatan,
      strokeColor: '#d10563',
      strokeOpacity: 1,
      strokeWeight: 3,
      fillColor: '#0028ea',
      fillOpacity: 0.15,
      editable: true,
      draggable: false
    });

    batasWilayah.setMap(map)
    batasWilayah.addListener('mouseup', editPath)
    batasWilayah.addListener('dragend', editPath)
  }
</script>
<style>
#float-btn {
	position: absolute;
	top: 10px;
	right: 15%;
	z-index: 5;
	font-family: 'Roboto', 'sans-serif';
}
#float-btn button {
	line-height: 20px;
	margin: 1px 0;
	margin-right: -5px;
	padding: 10px 15px;
	background: #ffffff;
	border: none;
	border-radius: 2px;
	font-size: initial;
	box-shadow: 1px 1px 4px 0px silver;
}
#float-btn button:hover {
	background: #ddd
}
#map {
	width: 100%;
	height: 450px;
	border: 1px solid #000;
}
</style>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Peta <?= $nama_wilayah ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?= site_url('beranda')?>"><i class="fa fa-home"></i> Beranda</a></li>
      <?php foreach ($breadcrumb as $tautan): ?>
      <li><a href="<?= $tautan['link'] ?>">
        <?= $tautan['judul'] ?>
        </a></li>
      <?php endforeach; ?>
      <li class="active">Peta <?= $wilayah ?>
      </li>
    </ol>
  </section>
  <section class="content">
    <form action="<?= $form_action?>" method="post" id="validasi" enctype="multipart/form-data">
      <div class='modal-body'>
        <div class="row">
          <div class="col-sm-12">
            <div id="float-btn">
              <button type="button" onclick="polygonAdd()">Tambah</button>
              <button type="button" onclick="polygonDelete()">Hapus</button>
              <button type="button" onclick="polygonReset()">Reset</button>
            </div>
            <div id="map"></div>
            <input type="hidden" id="path" name="path" value="<?= $wil_ini['path']?>">
            <input type="hidden" name="id" id="id"  value="<?= $wil_ini['id']?>"/>
          </div>
        </div>
      </div>
        <div class="modal-footer">
            <div class='col-sm-12'>
            <div class="row col-sm-7">
              <div class="form-group">
                    <div class="col-md-6">
                    <label class="col-sm-4 control-label "  for="lat">Lat: </label>
                    <input type="text" class="col-md-6" name="lat" id="lat" value="<?= $wil_ini['lat']?>"/><br/>
                    <label class="col-sm-4 control-label "  for="lng"> Lng: </label>
                    
                    <input type="text" class="col-md-6" name="lng" id="lng" value="<?= $wil_ini['lng']?>" /></div>
                    <div class="col-sm-6">
                    <label class="col-sm-4"  for="zoom"> Zoom: </label>
                   
                    <input type="text" class="col-md-6" width="5px" name="zoom" id="zoom" value="<?= $wil_ini['zoom']?>" /><br/>
                    <label class="col-sm-4"  for="map_tipe"> Map Tipe: </label>
                    
                 <select class="input-sm pull-left" name="map_tipe" id="map_tipe">
                    <option value="ROADMAP" <?php selected($map_tipe, 'ROADMAP'); ?>>ROADMAP</option>
                    <option value="SATELLITE" <?php selected($map_tipe, 'SATELLITE'); ?>>SATELLITE</option>
                    <option value="HYBRID" <?php selected($map_tipe, 'HYBRID'); ?>>HYBRID</option>
                </select>
                    <!-- <input type="text" class="col-md-6" width="5px" name="map_tipe" id="map_tipe" value="<?= $wil_ini['map_tipe']?>" />--></div>
                </div>
            </div>
                
            <div class="row col-sm-5">
                <a href="<?= site_url('identitas')?>" class="btn btn-social btn-box bg-purple btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" title="Kembali"><i class="fa fa-arrow-circle-o-left"></i> Kembali</a>
                <?php if ($this->CI->cek_hak_akses('h')): ?>
                <a href="#" class="btn btn-social btn-box btn-success btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" download="SIDeGa_Lokasi_Wilayah_<?php echo ucwords($kabupaten['nama_desa'])?>.gpx" id="exportGPX"><i class='fa fa-download'></i> Export ke GPX</a>
                <button type="reset" class="btn btn-social btn-box btn-danger btn-sm" data-dismiss="modal"><i class='fa fa-sign-out'></i> Tutup</button>
                <button type="submit" class="btn btn-social btn-box btn-info btn-sm"><i class='fa fa-check'></i> Simpan</button>
                <?php endif; ?>
            </div>
            </div>
        </div>
    </form>
  </section>
</div>
