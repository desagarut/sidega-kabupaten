<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://cdn.jsdelivr.net/gh/somanchiu/Keyless-Google-Maps-API@v5.7/mapsJavaScriptAPI.js" async defer></script>

<script>

var PetaDesa
var LokasiKantorDesa
var WilayahDusun

function initMap() {
    <?php if (!empty($kabupaten['lat']) && !empty($kabupaten['lng'])): ?>
        var center = {
            lat: <?=$kabupaten['lat']?>,
            lng: <?=$kabupaten['lng']?>
        }
    <?php else: ?>
        var center = {
            lat: -7.229426071233562,
            lng: 107.88959092620838
        }
    <?php endif; ?>
        
    var zoom = 13
    //Jika posisi kantor desa belum ada, maka posisi peta akan menampilkan seluruh Indonesia
    PetaDesa = new google.maps.Map(document.getElementById("peta_wilayah_desa"), { center, zoom, mapTypeId:google.maps.MapTypeId.HYBRID });

    LokasiKantorDesa = new google.maps.Marker({
        position: center,
        map: PetaDesa,
        title: 'Lokasi Kantor <?php echo ucwords($this->setting->sebutan_desa)." "?><?php echo ucwords($kabupaten['nama_desa'])?>',
		animation: google.maps.Animation.BOUNCE,
    });

    <?php if (!empty($kabupaten['path'])): ?>
	let polygon_desa = <?= $kabupaten['path']; ?>;
	
	polygon_desa[0].map((arr, i) => {
		polygon_desa[i] = { lat: arr[0], lng: arr[1] }
	})
	
	//Style polygon batas wilayah desa
	var batasWilayah = new google.maps.Polygon({
		paths: polygon_desa,
		strokeColor: '#c31b68',
		strokeOpacity: 0.9,
		strokeWeight: 3,
		fillColor: '#fd7e14',
		fillOpacity: 0.25
	});

	batasWilayah.setMap(PetaDesa)
    <?php endif; ?>
	
    <?php if (!empty($dusun_gis)): ?>
        let polygon_dusun = <?= $dusun_gis; ?>;
        
        polygon_dusun[0].map((arr, i) => {
            polygon_dusun[i] = { lat: arr[0], lng: arr[1] }
        })
        
        //Style polygon batas wilayah Dusun
        var batasWilayahDusun = new google.maps.Polygon({
            paths: polygon_dusun,
            strokeColor: '#c31b68',
            strokeOpacity: 1,
            strokeWeight: 1,
            fillColor: '#fd7e14',
            fillOpacity: 0.5,
        });

        batasWilayahDusun.setMap(PetaDesa)
    <?php endif; ?>
}
</script>

<!-- widget Peta Wilayah Kelurahan -->

    <div class="row">
      <div class="col-sm-12">
                    <div id="peta_wilayah_desa" style="height: 350px"></div>
        <input type="hidden" id="path" name="path" value="<?= $wil_ini['path']?>">
      </div>
    </div>
