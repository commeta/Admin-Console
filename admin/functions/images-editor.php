<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="index.html">Управление сайтом</a></li>
			<li><a href="#">Редактор изображений</a></li>
		</ol>
	</div>
</div>


<div id="ckfinder"></div>
<p>По двойному клику добавляет в буфер обмена (правая панель)</p>


<script type="text/javascript">
$(document).ready(function() {
	var clip= 0;

	CKFinder.widget( 'ckfinder', { // Загрузим фотки филиала в редактор изображений ckfinder
		height: 600,
		chooseFiles: true,
		onInit: function( finder ) {
			finder.on( 'files:choose', function( evt ) { // Буфер обмена изображениями
				var file = evt.data.files.first();
				// Iterate over the files collection.
				evt.data.files.forEach( function( file ) {
					// Send command to the server.
					finder.request( 'command:send', {
						name: 'ImageInfo',
						folder: file.get( 'folder' ),
						params: { fileName: file.get( 'name' ) }
					} ).done( function( response ) {
						// Process server response.
						if ( response.error ) {
							// Some error handling.
							return;
						}

						$('#clipboard').append(
							`
							<div id="clip-${clip}">
								<a href="#" onclick="clipboard(this);return false" title="">
									<img src="${file.getUrl()}" alt=""><br />
									<b>Имя файла:</b> ${file.get( 'name' )}<br />
									<b>URL:</b> ${file.getUrl()}<br />
									<b>Размеры:</b> ${response.width}x${response.height}<br />
									<b>Размер:</b> ${response.size} Байт<br />
								</a>
							</div>
							`
						);
						
						$('#clipboard').BootSideMenu.open();
						clip++;
						
						// Log image data:
						console.log( '-------------------' );
						console.log( 'Name:', file.get( 'name' ) );
						console.log( 'URL:', file.getUrl() );
						console.log( 'Dimensions:', response.width + 'x' + response.height );
						console.log( 'Size:', response.size + 'B' );
					} );
				} );
				
			});
			finder.on( 'file:choose:resizedImage', function( evt ) {
				//document.getElementById( 'url' ).value = evt.data.resizedUrl;
				console.log( evt.data.resizedUrl );
			});
		}
	});
});
</script>
