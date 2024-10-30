<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * @package ARGPD
 * @subpackage Ui
 * @since 0.0.0
 *
 * @author César Maeso <info@superadmin.es>
 *
 * @copyright (c) 2018, César Maeso (https://superadmin.es)
 */

/**
 * Ui class.
 *
 * @since  0.0.0
 */
class ARGPD_Ui {

	/**
	 * Parent plugin class.
	 *
	 * @var    string
	 * @since  0.0.0
	 */
	protected $plugin = null;

	/**
	 * Parent plugin class.
	 *
	 * @var    string
	 * @since  1.3.7
	 */
	const WP_DATATABLE_VERSION = '1.13.1';

	/**
	 * Constructor.
	 *
	 * @since  0.0.0
	 *
	 * @param string $plugin Plugin name.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;

		$this->register();
		$this->hooks();
	}

	/**
	 * Initiate our hooks.
	 *
	 * @since  0.0.0
	 */
	public function hooks() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		
		add_action( 'argpd_settings_tab', array( $this, 'argpd_ajustes_tab' ), 10 );
		add_action( 'argpd_settings_tab', array( $this, 'argpd_paginas_tab' ), 10 );
		add_action( 'argpd_settings_tab', array( $this, 'argpd_cookies_tab' ), 10 );
		add_action( 'argpd_settings_tab', array( $this, 'argpd_ayuda_tab' ), 10 );
		add_action( 'argpd_settings_content', array( $this, 'argpd_ajustes_content' ), 10 );	
		add_action( 'argpd_settings_content', array( $this, 'argpd_paginas_content' ), 10 );
		add_action( 'argpd_settings_content', array( $this, 'argpd_cookies_content' ), 10 );	
		add_action( 'argpd_settings_content', array( $this, 'argpd_ayuda_content' ), 10 );		

		// ajax scripts.		
		add_action( 'wp_ajax_argpd_get_states', array( $this, 'argpd_get_states' ) );
		add_action( 'wp_ajax_consents_load_data', array( $this, 'ajax_consents_load_data' ) );		
		add_action( 'wp_ajax_argpd_create_page', array( $this, 'create_page' ) );

		// print scripts to the footer.
		add_action( 'admin_footer', array( $this, 'admin_scripts' ) );
		add_action( 'admin_footer', array( $this, 'change_country' ) );
		add_action( 'admin_footer', array( $this, 'toggle_bussines_view' ) );
		add_action( 'admin_footer', array( $this, 'update_theme_preview' ) );

		// enqueue admin styles and scripts.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
	}


	/**
    * Register styles and scripts.
    *
    * @since  0.0.0
    */
	public function register() {
		wp_register_style(
			'wp-datatable-style',
			$this->plugin->url . 'assets/css/jquery.dataTables.min.css?v=' . $this::WP_DATATABLE_VERSION,
			array(),
			$this->plugin->version
		);

		wp_register_script(
			'wp-datatable-script',
			$this->plugin->url . 'assets/js/jquery.dataTables.min.js?v=' . $this::WP_DATATABLE_VERSION,
			array(),
			$this->plugin->version
		);
	}


    /**
     * Register scripts and Styles.
     *
     * @param string $hook is the hookname.
     * @since  0.0.0
     */
    public function enqueue_admin_assets( $hook ) {
        // Load assets only on plugin page ?page=argpd-consents.
        if ( 'adapta-rgpd_page_argpd-consents' != $hook ) {
            return;
        }

        wp_enqueue_style( 'wp-datatable-style' );
        wp_enqueue_script( 'wp-datatable-script' );
    }


	/**
	 * Function wp-ajax to create pages
	 *
	 * @since  1.0.1
	 */
	public function create_page() {
		check_ajax_referer( 'argpd_create_page', 'security' );

		$id   = 0;
		$page = ! empty( $_POST['page'] ) ? sanitize_text_field( wp_unslash( $_POST['page'] ) ) : '';

		switch ( $page ) {
			case 'crear-pagina-legal':
				$id = $this->plugin->pages->create_legal_page();
				break;
			case 'crear-pagina-privacidad':
				$id = $this->plugin->pages->create_privacy_page();
				break;
			case 'crear-pagina-cookies':
				$id = $this->plugin->pages->create_cookies_page();
				break;
			case 'create-custom-cookies-page':
				$id = $this->plugin->pages->create_custom_cookies_page();
				break;
			default:
				break;
		}
		echo esc_attr( $id );
		wp_die();
	}


	/**
	 * Function wp-ajax to echo states
	 *
	 * @since  1.0.0
	 */
	public function change_country() {
		?>
		<script type="text/javascript" >
			var ajaxurl = '<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>';
			jQuery(document).ready(function($) {			
				$('body').on('change', '.countries', function() {    				
					  var countryid = $(this).val();
					  if(countryid != '') {
						var data = {
							  action: 'argpd_get_states',
							  country: countryid,
							  'security': '<?php echo esc_attr( wp_create_nonce( 'load_states' ) ); ?>'
						}
						
						$('.load-state').html("<span><?php esc_html_e( 'cargando...', 'argpd' ); ?></span>");
						$.post(ajaxurl, data, function(response) {
							  $('.load-state').html(response);
						});
					  }
				});

				// Eventos al activar la página de "Aviso Legal".
				$( "input[name*='avisolegal-enabled']" ).on('click', function(e){
					$('#avisolegal').toggle();
					$('.avisolegal-description').toggle();
				});

				// Eventos al activar la página de "Política de Privacidad".
				$( "input[name*='privacidad-enabled']" ).on('click', function(e){
					$('#privacidad').toggle();
					$('.privacidad-description').toggle();
				});

				// Eventos al activar la página de "Política de Cookies".
				$( "input[name*='cookies-enabled']" ).on('click', function(e){
					$('#cookies').toggle();
					$('.cookies-description').toggle();
				});

				// Eventos al activar la página de "Personalizar cookies".
				$( "input[name*='custom-cookies-page-enabled']" ).on('click', function(e){
					$('#custom-cookies-page').toggle();
					$('.custom-cookies-page-description').toggle();
				});

			});
		</script> 
		<?php
	}


	/**
	 * Print admin scripts to the footer.
	 *
	 * @since  1.0.0
	 */
	public function admin_scripts() {
		$settings = $this->plugin->argpd_settings;
		?>

<script type="text/javascript" >			
	jQuery(document).ready(function($) {
		'use strict';

		window.AdminScripts = window.AdminScripts || {};

		AdminScripts.ajaxurl = '<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>';

		AdminScripts.auth = function () {
			return fetch('https://superapis.es/legaltech360/api/v1/auth', {
				method: 'POST',
				headers: {
      				'Accept': 'application/json',
      				'Content-Type': 'application/json',
				},
				body: JSON.stringify({"token": "<?php echo esc_attr( $settings->get_setting( 'apikey' ) ); ?>" })
			})
   			.then((resp) => resp.text())
			.then((text) => {
      			return text;
    		})
    		.catch(error => console.warn(error));			
		}

		AdminScripts.getCookies= function (jwt) {
			var payload = [];
			if (document.cookie && document.cookie != '') {
				var documentCookies = document.cookie.split(";");

				documentCookies = documentCookies.filter(function(value, index, array){
					return (!value.trim().startsWith("wp-settings-"))
				});

				for (var i = 0; i < documentCookies.length; i++) {
					var name_value = documentCookies[i].split("=");
					payload.push({'name': name_value[0].trim()});
				}
			}

			return fetch('https://superapis.es/legaltech360/api/v1/opencookiedatabase/cookies', {
				method: 'POST',
				headers: {
      				'Accept': 'application/json',
      				'Content-Type': 'application/json',
      				'Authorization': `Bearer ${jwt}`,
				},
				body: JSON.stringify(payload)
			})
			.then((resp) => resp.json())
			.then((data) => {
      			return data;
    		})
    		.catch(error => console.warn(error));
		}

		AdminScripts.getQuotas= function (jwt) {
			return fetch('https://superapis.es/legaltech360/api/v1/datacontrollers/datacontroller', {
				method: 'GET',
				headers: {
      				'Accept': 'application/json',
      				'Content-Type': 'application/json',
      				'Authorization': `Bearer ${jwt}`,
				},
			})
			.then((resp) => resp.json())
			.then((data) => {
      			return data;
    		})
    		.catch(error => console.warn(error));
		}		

		AdminScripts.events= function(){
			// search cookies event.
			$( "#js-search-cookies" ).on('click', function(e){
				AdminScripts.auth().then( jwt => {
					if ( typeof(jwt) == "undefined" ) {						
						$('.api-message').append('La clave API no es correcta');
						return;
					}
					AdminScripts.getCookies(jwt).then( resp => {
						if ('undefined' !== typeof resp && resp.hasOwnProperty('result')) {
							var result = resp.result.sort((a,b) => (a.name > b.name) ? 1 : ((b.name > a.name) ? -1 : 0))
							var text = '<ul>';
							result.forEach(item => {
								text +='<li>';
								text += (item.category == '')?`<strong>${item.name}</strong>`:`
									<strong>${item.name}</strong>
									<br/>${item.desc}
									<br/>Categoría: ${item.category}.
									<br/>Duración: ${item.retention}.
									<br/>Política de privacidad: <a rel="nofollow" href=${item["privacy-url"]}>${item["privacy-url"]}</a>`;
								text +='</li>';
							})
							text +='</ul>';
							tinymce.get('cookies-list').setContent(text);
						}
					});
				});
			});

			// search consent by uuid.
			$( "#js-search-by-consent-uuid" ).on('click', function(e){
				var uuid = $('#js-consent-uuid').val();

			    const data = new FormData();
        		data.append( 'action', 'consents_load_data' );
        		data.append( 'security', '<?php echo esc_attr( wp_create_nonce( 'consents_load_data' ) ); ?>' );
				data.append( 'filter', uuid );

				fetch(AdminScripts.ajaxurl, {
					method: 'POST',
					credentials: 'same-origin',
					body: data
				})
				.then((resp) => resp.json())
				.then((data) => {
      				var dataTable = $('#argpd-table-consents').DataTable();
					dataTable.clear();
					dataTable.rows.add(data.result).draw();
    			})
    			.catch(error => console.warn(error));
			});

			// create legal page
			$('.js-create-legal-page').on('click', function(e){
				var pagename= e.target.id;
				if(pagename != '') {
					var data = {
						action: 'argpd_create_page',
						page: pagename,
						'security': '<?php echo esc_attr( wp_create_nonce( 'argpd_create_page' ) ); ?>'
					}
					$.post(AdminScripts.ajaxurl, data, function(response) {    						
						  if (!isNaN(parseFloat(response)) && isFinite(response) && response>0){
							  location.replace(location.href+"&message=saved");
						  } else {
							  location.replace(location.href+"&message=");
						  }
					});
				}
			});
		} // AdminScripts.events

		// Check api quota.
		AdminScripts.quota = function() {
			if ( $( "#argpd-table-consents" ).length == 0 ) {
				return;
			}

			AdminScripts.auth().then( jwt => {
				if ( typeof(jwt) == "undefined" ) {
					$('.api-message').append('La clave API no es correcta');
					return;
				}
				AdminScripts.getQuotas(jwt).then( resp => {
					if ('undefined' !== typeof resp && resp.hasOwnProperty('result')) {
						var result = resp.result;
						var current = result.hasOwnProperty('monthly-consents')?result['monthly-consents']:0;						
						var quota = result.hasOwnProperty('monthly-quota')?result['monthly-quota']:0;
						$("#js-quota").text(quota);
						$("#js-current").text(current);
					}
				});
			});			
		}

		// Print consents table.
		AdminScripts.dataTable = function() {
			if ( $( "#argpd-table-consents" ).length == 0 ) {
				return;
			}

			const ajaxurl = '<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>';
			var data= {
				'action': 'consents_load_data',            
				'security': '<?php echo esc_attr( wp_create_nonce( 'consents_load_data' ) ); ?>'
			}

			$.fn.dataTable.ext.errMode = 'throw';
			$('#argpd-table-consents').DataTable( {
				"ajax": {
					"url": ajaxurl,
					"data": data,
					"dataSrc": 'result',
				},
				"drawCallback" : function(settings, json ) {					
					// event to open raw content popup
					$( ".js-open-raw-popup" ).on('click', function() {
						var raw = $(this).data("raw");
						$( '#raw-consent-content' ).text(JSON.stringify(raw, null, "\t"));
  						$( '#argpd-raw-consent-popup' ).addClass("show");
					});

					// event to open raw content popup
					$( ".js-close-raw-popup" ).on('click', function() {
						$( '#argpd-raw-consent-popup' ).removeClass("show");
					});
				},
				"columnDefs": [
					{
				 	"targets": 0,
				 	"data": "id",
				 	"render": function (data, type, row) {
				 		if (null == data) return '';
				 		return '<span style="word-break: break-all;">' + data + '</span>';
				 		},
				 	},
					{
				 	"targets": 5,
				 	"data": "id",
				 	"render": function (data, type, row) {
				 		if (null == data) return '';
				 		return data.length > 40 ?
				 			 '<span title="'+data+'">' + data.substr( 0, 24 ) + '</span>' : data;
				 		},
				 	},								 	
					{
				 	"targets": [6, 7, 8, 9, 10],
				 	"data": "id",
				 	"render": function (data, type, row) {
				 		if (null == data) return '';
				 		return data ? 
				 			'<span class="dashicons dashicons-yes"></span>':'<span class="dashicons dashicons-no"></span>';
				 		},
				 	},
					{
						"targets": 11,
						"data": "id",
						"render": function (data, type, row) {
							return '<span class="js-open-raw-popup" data-raw=\'' + data + '\'><span class="dashicons dashicons-info-outline"></span></span>';
						},
					},
				],
				"columns": [
					{ "data": "id" },
					{ "data": "date" },
					{ "data": "username" },									
					{ "data": "ip" },									
					{ "data": "ua" },
					{ "data": "uri" },
					{ "data": "purpose-necessary" },
					{ "data": "purpose-non-necessary" },
					{ "data": "purpose-analytics" },
					{ "data": "purpose-marketing" },
					{ "data": "purpose-advertisement" },
					{ "data": "raw" },
				],
				"aaSorting": [ 
					[1, 'desc'],
				],
				"searching": false,
				"language": {
					"decimal":        "",
					"emptyTable":     "Sin datos",
					"info":           "Mostrando los consentimientos de la _START_ a la _END_ de un total de _TOTAL_",
					"infoEmpty":      "Mostrando 0 a 0 de 0 consentimientos",
					"infoFiltered":   "(filtered from _MAX_ total entries)",
					"infoPostFix":    "",
					"thousands":      ",",
					"lengthMenu":     "Mostrar _MENU_ entradas",
					"loadingRecords": "Cargando...",
					"processing":     "Cargando...",
					"search":         "Buscar:",
					"zeroRecords":    "Ningún resultado",
					"paginate": {
						"first":      "Primera",
						"last":       "Última",
						"next":       "Siguiente",
						"previous":   "Anterior"
					},
					"aria": {
						"sortAscending":  ": activate to sort column ascending",
						"sortDescending": ": activate to sort column descending"
					}
				},
        		"dom": 'Bfrtip',
       			"buttons": [
       			],       			
			});
		};
		
		AdminScripts.init = function(){
			AdminScripts.dataTable();
			AdminScripts.quota();
			AdminScripts.events();			
		}

		AdminScripts.init();
	});

</script> 
		<?php
	}

	/**
	 * Toggle business visualization
	 *
	 * @since  1.2
	 */
	public function toggle_bussines_view() {
		?>
		<script type="text/javascript" >					
			jQuery(document).ready(function($) {				
				$('body').on('change', '#empresa-switch', function() {					
					if( this.checked == true ){
						$('.empresa').show();
						$('.particular').hide();
					} else {
						$('.empresa').hide();
						$('.particular').show();
					}
				});
			});
		</script> 
		<?php
	}

	/**
	 * Updates the image of theme preview
	 *
	 * @since 1.3.4
	 */
	public function update_theme_preview() {
		?>
		<script type="text/javascript">
			jQuery(document).ready(function($) {

				// First load
				load_img($( "#cookies-theme option:selected" ).val());

				$('body').on('change', '#cookies-theme', function() {
					load_img(this.value);
				});

				function load_img(value) {
					var ruta = '<?php echo esc_url( WP_PLUGIN_URL . '/adapta-rgpd/assets/images/' ); ?>';
					var img_name;
					switch(value) {
						default:
						case "classic":
						case "classic-top":
							img_name = "clasico.png";
							break;
						case "modern-light":
							img_name = "moderno-claro.png";
							break;
						case "modern-dark":
							img_name = "moderno-oscuro.png";
							break;
						case "modern-flex":
							img_name = "moderno-oscuro-columnas.png";
							break;
					}
					$('#theme-preview').attr("src", ruta + img_name);	
				}
			});
		</script>
		<?php
	}

	/**
	 * Function wp-ajax to get states by country
	 *
	 * @since  1.0.0
	 */
	public function argpd_get_states() {
		check_ajax_referer( 'load_states', 'security' );
		$country = ! empty( $_POST['country'] ) ? sanitize_text_field( wp_unslash( $_POST['country'] ) ) : 'ES';

		$settings = $this->plugin->argpd_settings;
		$states   = $settings->get_states( $country );
		?>
		 
			<select name="provincia-code" id="provincia-code">
				<option value="" selected="selected">Selecciona</option>
				<?php
				foreach ( $states as $i ) {
					$selected = ( $i['code'] == $settings->get_setting( 'provincia-code' ) ) ? ( 'selected="selected"' ) : '';
					printf( '<option value="%s" %s>%s</option>', esc_attr( $i['code'] ), esc_attr( $selected ), esc_html( $i['name'] ) );
				}
				?>
			</select>

		<?php
		wp_die();
	}

	/**
	 * Echo 'Titular' tab of plugin settings
	 *
	 * @since  0.0.0
	 */
	public function argpd_ajustes_tab() {
		global $argpd_active_tab;
		$classname = ( ! empty( $argpd_active_tab ) && 'ajustes' == $argpd_active_tab ) ? 'nav-tab-active' : '';
		?>
		<a 	class="nav-tab <?php echo esc_attr( $classname ); ?>" 
			href="<?php echo esc_attr( admin_url( 'admin.php?page=argpd&tab=ajustes' ) ); ?>">
			<?php esc_html_e( 'Responsable', 'argpd' ); ?> 
		</a>
		<?php
	}

	/**
	 * Muestra el contenido de la pestaña Responsable.
	 *
	 * @since  0.0.0
	 */
	public function argpd_ajustes_content() {
		global $argpd_active_tab;
		if ( empty( $argpd_active_tab ) || 'ajustes' != $argpd_active_tab ) {
			return;
		}

		$settings = $this->plugin->argpd_settings;

		$classes = array();
		$classes['empresa'] = $settings->get_setting( 'es-empresa' ) ? 'empresa' : 'empresa oculto';
		$classes['particular'] = $settings->get_setting( 'es-empresa' ) ? 'particular oculto' : 'particular';
		?>
		
		<form method="post" action="admin-post.php" class="pt20">
			<?php wp_nonce_field( 'argpd' ); ?>
			<input type="hidden" value="argpd_setup" name="action"/>

			<div class="argpd-panel">
			<table class="form-table">
				<tbody>
					<tr>	
					<th>						
						<h2 class="title"><?php esc_html_e( 'Responsable del Tratamiento', 'argpd' ); ?></h2>
					</th>
						<td>
							<?php
								$checked = ( $settings->get_setting( 'es-empresa' ) == 1 ) ? ( 'checked' ) : '';
							?>
			
							<?php esc_html_e( 'Particular', 'argpd' ); ?>&nbsp;&nbsp;
							<label class="argpd-switch">
							  <input type="checkbox" id="empresa-switch" name="es-empresa" <?php echo esc_attr( $checked ); ?>>
							  <span class="argpd-slider argpd-round"></span>
							</label>

							<?php esc_html_e( 'Empresa o autónomo', 'argpd' ); ?>
						</td>
					</tr>
					
					<!-- Titular -->
					<tr>
						<th scope="row">
							<label for="titular">
								<span class="<?php echo esc_attr( $classes['particular'] ); ?>">
									<?php
										printf(
											'%s<br>%s',
											esc_html__( 'Nombre y apellidos', 'argpd' ),
											esc_html__( 'de Contacto', 'argpd' )
										);
									?>
								</span>
								<span class="<?php echo esc_attr( $classes['empresa'] ); ?>">
									<?php
										printf(
											'%s<br>%s',
											esc_html__( 'Denominación social', 'argpd' ),
											esc_html__( 'o Titular', 'argpd' )
										);
									?>
								</span>
							</label>
						</th>
						<td>
							<input 	type="text" 
									name="titular" 
									value="<?php echo esc_attr( $settings->get_setting( 'titular' ) ); ?>" 
									/>			
						</td>
					</tr>
					
					<!-- Identificador Fiscal -->
					<tr>
						<th scope="row">
							<label for="id-fiscal">
								<span class="<?php echo esc_attr( $classes['particular'] ); ?>">
									<?php echo esc_attr( $settings->get_setting( 'id-fiscal-nombre' ) ); ?>
								</span>
								<span class="<?php echo esc_attr( $classes['empresa'] ); ?>">
									<?php

										printf(
											'%s<br>%s',
											esc_html__( 'Identificador fiscal', 'argpd' ),
											esc_html__( 'NIF o CIF', 'argpd' )
										);
									?>
								</span>

							</label>
						</th>
						<td>
							<input 	type="text" 
									name="id-fiscal" 
									value="<?php echo esc_attr( $settings->get_setting( 'id-fiscal' ) ); ?>" 
									/>				
						</td>
					</tr>

					<!-- Colegio Profesional -->
					<tr class="<?php echo esc_attr( $classes['empresa'] ); ?>">
						<th scope="row">
							<label for="colegio">								
							<?php
								printf(
									'%s<br>%s',
									esc_html__( 'Datos del', 'argpd' ),
									esc_html__( 'Colegio Profesional', 'argpd' )
								);
							?>
							</label>
						</th>
						<td>
							<input 	type="text" 
									name="colegio" 
									value="<?php echo esc_attr( $settings->get_setting( 'colegio' ) ); ?>" 
									/>	
							<p class="description">								
								<?php esc_html_e( 'Opcional', 'argpd' ); ?>
							</p>			
						</td>
					</tr>
					
					<!-- Registro mercantil -->
					<tr class="<?php echo esc_attr( $classes['empresa'] ); ?>">
						<th scope="row">
							<label for="registro-mercantil">								
							<?php
								printf(
									'%s<br>%s',
									esc_html__( 'Datos del', 'argpd' ),
									esc_html__( 'Registro mercantil', 'argpd' )
								);
							?>
							</label>
						</th>
						<td>
							<span><?php esc_html_e( 'Registro mercantil de', 'argpd' ); ?></span>:&nbsp;<input type="text" 
									name="mercantil-ciudad" 
									value="<?php echo esc_attr( $settings->get_setting( 'mercantil-ciudad' ) ); ?>" 
									/>
							<br/><br/>
							<span><?php esc_html_e( 'Tomo', 'argpd' ); ?></span>:&nbsp;<input 	
									type="text" 
									name="mercantil-tomo" 
									size="1"
									value="<?php echo esc_attr( $settings->get_setting( 'mercantil-tomo' ) ); ?>" 
									/>
							<span><?php esc_html_e( 'Libro', 'argpd' ); ?></span>:&nbsp;<input 	
									type="text" 
									name="mercantil-libro" 
									size="1"
									value="<?php echo esc_attr( $settings->get_setting( 'mercantil-libro' ) ); ?>" 
									/>
							<span><?php esc_html_e( 'Sección', 'argpd' ); ?></span>:&nbsp;<input 	
									type="text" 
									name="mercantil-seccion" 
									size="1"
									value="<?php echo esc_attr( $settings->get_setting( 'mercantil-seccion' ) ); ?>" 
									/>
							<br/><br/>
							<span><?php esc_html_e( 'Folio', 'argpd' ); ?></span>:&nbsp;<input 	
									type="text" 
									name="mercantil-folio" 
									size="1"
									value="<?php echo esc_attr( $settings->get_setting( 'mercantil-folio' ) ); ?>" 
									/>
							<span><?php esc_html_e( 'Hoja', 'argpd' ); ?></span>:&nbsp;<input 	
									type="text" 
									name="mercantil-hoja" 
									size="1"
									value="<?php echo esc_attr( $settings->get_setting( 'mercantil-hoja' ) ); ?>" 
									/>									
							<span><?php esc_html_e( 'Inscripción', 'argpd' ); ?></span>:&nbsp;<input 	
									type="text" 
									name="mercantil-inscripcion" 
									size="1"
									value="<?php echo esc_attr( $settings->get_setting( 'mercantil-inscripcion' ) ); ?>" 
									/>
						</td>
					</tr>					

					<!-- Domicilio -->
					<tr>
						<th scope="row">
							<span class="<?php echo esc_attr( $classes['particular'] ); ?>"><?php esc_html_e( 'Domicilio', 'argpd' ); ?></span>
							<span class="<?php echo esc_attr( $classes['empresa'] ); ?>"><?php esc_html_e( 'Domicilio social', 'argpd' ); ?></span>
						</th>
						<td>

							<input 	type="text" 
									name="domicilio" 
									value="<?php echo esc_attr( $settings->get_setting( 'domicilio' ) ); ?>" 
									/>
							<p>								
							
							<span class="load-state">
							<select name="provincia-code" id="provincia-code">
								<option value="" selected="selected">Selecciona</option>
								<?php
									$country = $settings->get_setting( 'pais' );
									$states  = $settings->get_states( $country );
									foreach ( $states as $i ) {
										$selected = ( $i['code'] == $settings->get_setting( 'provincia-code' ) ) ? ( 'selected="selected"' ) : '';
										printf( '<option value="%s" %s>%s</option>', esc_attr( $i['code'] ), esc_attr( $selected ), esc_html( $i['name'] ) );
									}
								?>
							</select>

							</span>

							<select name="pais" id="pais" class="countries">
								<?php
									$countries = $settings->get_countries();
									foreach ( $countries as $key => $value ) {
										$selected = ( $key == $settings->get_setting( 'pais' ) ) ? ( 'selected="selected"' ) : '';
										printf( '<option value="%s" %s>%s</option>', esc_attr( $key ), esc_attr( $selected ), esc_html( $value ) );
									}
								?>
							</select>
							</p>			
						</td>
					</tr>						
										
					<!-- correo electrónico -->
					<tr>
						<th scope="row">
							<label for="correo">								
							<?php
								printf(
									'%s<br>%s',
									esc_html__( 'Correo electrónico', 'argpd' ),
									esc_html__( 'de contacto', 'argpd' )
								);
							?>
							</label>
						</th>
						<td>
							<input 	type="text" name="correo" value="<?php echo esc_attr( $settings->get_setting( 'correo' ) ); ?>" />
							<p class="description">
								<?php
									printf(
										'%s<br>%s',
										esc_html__( 'Correo electrónico dónde ejercen sus', 'argpd' ),
										esc_html__( 'derechos los usuarios', 'argpd' )
									);
								?>
							</p>
						</td>
					</tr>

					<!-- teléfono -->
					<tr class="<?php echo esc_attr( $classes['empresa'] ); ?>">
						<th scope="row">							
							<label for="telefono"><?php esc_html_e( 'Teléfono', 'argpd' ); ?></label>							
						</th>
						<td>
							<input 	type="text" name="telefono" value="<?php echo esc_attr( $settings->get_setting( 'telefono' ) ); ?>" />
							<p class="description">
								<?php esc_html_e( 'Opcional', 'argpd' ); ?>
							</p>
						</td>
					</tr>					
				</tbody>
			</table>
			<?php submit_button(); ?>
			</div>

			<!-- Sobre el sitio web -->
			<br>
			<div class="argpd-panel">
				<h2 class="title"><?php esc_html_e( 'Sobre el sitio Web', 'argpd' ); ?></h2>
			
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row">
							<label for="dominio">
								<?php
									/* translators: en el contexto: Dirección web del sitio */
									printf(
										'%s<br>%s',
										esc_html__( 'Dirección web', 'argpd' ),
										esc_html__( 'del sitio', 'argpd' )
									);
								?>
							</label>			
						</th>
						<td>
							<input 	type="text" 
									name="dominio" 
									value="<?php echo esc_attr( $settings->get_setting( 'dominio' ) ); ?>" 
									/>							
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="finalidad">
								<span class="<?php echo esc_attr( $classes['particular'] ); ?>">
									<?php
										printf(
											'%s<br>%s',
											esc_html__( 'Actividad del', 'argpd' ),
											esc_html__( 'Sitio Web', 'argpd' )
										);
									?>
								</span>
								<span class="<?php echo esc_attr( $classes['empresa'] ); ?>">
									<?php
										printf(
											'%s<br>%s',
											esc_html__( 'Actividad de', 'argpd' ),
											esc_html__( 'la Empresa', 'argpd' )
										);
									?>
								</span>				
							</label>				
						</th>
						<td>
							<textarea 
								name="finalidad" 
								id="finalidad" 
								cols="24"
								rows="3"
								><?php echo esc_html( $settings->get_setting( 'finalidad' ) ); ?></textarea>
							<p class="description">
								<?php esc_html_e( 'Por ejemplo, tienda de venta de zapatos', 'argpd' ); ?>
							</p>
							<br/>
						</td>
					</tr>
					<tr class="<?php echo esc_attr( $classes['empresa'] ); ?>">
						<th scope="row">
							<label for="es-tienda"><?php esc_html_e( 'Tienda online', 'argpd' ); ?></label>
						</th>
						<td>							
							<fieldset>
								<label  for="es-tienda">
									<input 	name="es-tienda" 
											type="checkbox" 
											id="es-tienda" 
											value="1"
											<?php ( $settings->get_setting( 'es-tienda' ) == 1 ) && printf( 'checked' ); ?>
											>											
											Venta de productos o servicios
								</label>
								&nbsp;
								<a 	href="https://superadmin.es/blog/que-es/lssi/" 
									target="_blank"
									rel="nofollow"
									>
									<span style="text-decoration: none" class="dashicons dashicons-editor-help"></span>								
									<?php esc_html_e( '¿Qué es la LSSI?', 'argpd' ); ?>
								</a>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="hosting-info">								
							<?php
								printf(
									'%s<br>%s',
									esc_html__( 'Proveedor del', 'argpd' ),
									esc_html__( 'alojamiento web', 'argpd' )
								);
							?>
							</label>
						</th>
						<td>
							<input 	type="text" 
									name="hosting-info" 
									value="<?php echo esc_attr( $settings->get_setting( 'hosting-info' ) ); ?>" 
									/>
							<!--<p class="description">
								Indica tu proveedor de alojamiento o hosting y un enlace a su política de privacidad.
							</p>-->				
						</td>
					</tr>					
					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Servicios de Terceros', 'argpd' ); ?></label>
						</th>
						<td>
							<fieldset>
								<b>Análisis web</b><br/>
								<label for="thirdparty-ganalytics">
									<input 	name="thirdparty-ganalytics" 
											type="checkbox" 
											id="thirdparty-ganalytics" 
											value="1"
											<?php ( $settings->get_setting( 'thirdparty-ganalytics' ) == 1 ) && printf( 'checked' ); ?>
											>											
											Google Analytics
								</label>
								<br/>
								
								<br/><b>Publicidad</b><br/>
								<label for="thirdparty-dclick">
									<input 	name="thirdparty-dclick" 
											type="checkbox" 
											id="thirdparty-dclick" 
											value="1"
											<?php ( $settings->get_setting( 'thirdparty-dclick' ) == 1 ) && printf( 'checked' ); ?>
											>											
											DoubleClick by Google
								</label>
								<br/>								
								<label for="thirdparty-adsense">
									<input 	name="thirdparty-adsense" 
											type="checkbox" 
											id="thirdparty-adsense" 
											value="1"
											<?php ( $settings->get_setting( 'thirdparty-adsense' ) == 1 ) && printf( 'checked' ); ?>
											>											
											Google AdSense
								</label>
								<br/>

								<label for="thirdparty-amazon">
									<input 	name="thirdparty-amazon" 
											type="checkbox" 
											id="thirdparty-amazon" 
											value="1" 
											<?php ( $settings->get_setting( 'thirdparty-amazon' ) == 1 ) && printf( 'checked' ); ?>
											>
											<?php esc_html_e( 'Programa de Afiliados de Amazon de la UE', 'argpd' ); ?>
								</label>							
								<br/>

								<br/><b>Email Marketing</b><br/>
								<label for="thirdparty-activecampaign">
									<input 	name="thirdparty-activecampaign" 
											type="checkbox" 
											id="thirdparty-activecampaign" 
											value="1" 
											<?php ( $settings->get_setting( 'thirdparty-activecampaign' ) == 1 ) && printf( 'checked' ); ?>
											>
											Active Campaign
								</label>
								<br/>
								<label for="thirdparty-getresponse">
									<input 	name="thirdparty-getresponse" 
											type="checkbox" 
											id="thirdparty-getresponse" 
											value="1" 
											<?php ( $settings->get_setting( 'thirdparty-getresponse' ) == 1 ) && printf( 'checked' ); ?>
											>
											GetResponse
								</label>
								<br/>
								<label for="thirdparty-mailchimp">
									<input 	name="thirdparty-mailchimp" 
											type="checkbox" 
											id="thirdparty-mailchimp" 
											value="1" 
											<?php ( $settings->get_setting( 'thirdparty-mailchimp' ) == 1 ) && printf( 'checked' ); ?>
											>
											Mailchimp
								</label>
								<br/>
								<label for="thirdparty-mailerlite">
									<input 	name="thirdparty-mailerlite"
											type="checkbox" 
											id="thirdparty-mailerlite"
											value="1" 
											<?php ( $settings->get_setting( 'thirdparty-mailerlite' ) == 1 ) && printf( 'checked' ); ?>
											>
											MailerLite
								</label>							
								<br/>								
								<label for="thirdparty-mailpoet">
									<input 	name="thirdparty-mailpoet"
											type="checkbox" 
											id="thirdparty-mailpoet"
											value="1" 
											<?php ( $settings->get_setting( 'thirdparty-mailpoet' ) == 1 ) && printf( 'checked' ); ?>
											>
											MailPoet
								</label>							
								<br/>
								<label for="thirdparty-mailrelay">
									<input 	name="thirdparty-mailrelay" 
											type="checkbox" 
											id="thirdparty-mailrelay" 
											value="1" 
											<?php ( $settings->get_setting( 'thirdparty-mailrelay' ) == 1 ) && printf( 'checked' ); ?>
											>
											Mailrelay											
								</label>							
								<br/>

								<label for="thirdparty-sendinblue">
									<input 	name="thirdparty-sendinblue"
											type="checkbox" 
											id="thirdparty-sendinblue"
											value="1" 
											<?php ( $settings->get_setting( 'thirdparty-sendinblue' ) == 1 ) && printf( 'checked' ); ?>
											>
											Sendinblue
								</label>							
								<br/>								

								<br/><b>Redes Sociales</b><br/>
								<label for="thirdparty-social">
									<input 	name="thirdparty-social" 
											type="checkbox" 
											id="thirdparty-social" 
											value="1" 
											<?php ( $settings->get_setting( 'thirdparty-social' ) == 1 ) && printf( 'checked' ); ?>
											>
											<?php esc_html_e( 'Facebook, Twitter, Linkedin, YouTube o Instagram', 'argpd' ); ?>
								</label>
								<br/>
							</fieldset>
						</td>
					</tr>
				</tbody>
			</table>
			<?php submit_button(); ?>
		</div>

			<!-- Más ajustes -->
			<br>
			<div class="argpd-panel">
				<h2 class="title"><?php esc_html_e( 'Más Ajustes', 'argpd' ); ?></h2>
			
			<table class="form-table">
				<tbody>	
					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Cláusulas', 'argpd' ); ?></label>
						</th>
						<td>
							<fieldset>							
							<label for="clause-exclusion">
							<input 	name="clause-exclusion" 
									type="checkbox" 
									id="clause-exclusion" 
									value="1"
									<?php ( $settings->get_setting( 'clause-exclusion' ) == 1 ) && printf( 'checked' ); ?>
									>
									<?php esc_html_e( 'Reservar el Derecho de exclusión', 'argpd' ); ?>
							</label>
							<br/>
							<label for="clause-terceros">
							<input 	name="clause-terceros" 
									type="checkbox" 
									id="clause-terceros" 
									value="1" 
									<?php ( $settings->get_setting( 'clause-terceros' ) == 1 ) && printf( 'checked' ); ?>
									>
									<?php esc_html_e( 'Cesión de datos a terceros', 'argpd' ); ?>
							</label>
							<br/>
							
							<!-- Clausula mayoría de edad -->
							<label for="clause-edad">
							<input 	name="clause-edad" 
									type="checkbox" 
									id="clause-edad" 
									value="1" 
									<?php ( $settings->get_setting( 'clause-edad' ) == 1 ) && printf( 'checked' ); ?>
									>									
									<?php esc_html_e( 'Requisito mayoría edad. ', 'argpd' ); ?>
									Ciudadanos europeos: 
									<input 	
									type="text" 
									name="edad-ue" 
									size="1"
									value="<?php echo esc_attr( $settings->get_setting( 'edad-ue' ) ); ?>" 									
									/>&nbsp;<?php esc_html_e( 'años', 'argpd' ); ?>,
									&nbsp;<?php esc_html_e( 'otros', 'argpd' ); ?>
									<input 	
									type="text" 
									name="edad-otros" 
									size="1"
									value="<?php echo esc_attr( $settings->get_setting( 'edad-otros' ) ); ?>"
									/>&nbsp;<?php esc_html_e( 'años', 'argpd' ); ?>
							</label>						
							<br/>

							<label for="clause-protegidos">
							<input 	name="clause-protegidos" 
									type="checkbox" 
									id="clause-protegidos" 
									value="1" 
									<?php ( $settings->get_setting( 'clause-protegidos' ) == 1 ) && printf( 'checked' ); ?>
									>
									<?php esc_html_e( 'Datos especialmente protegidos: médicos, religiosos, orientación sexual...', 'argpd' ); ?>
							</label>
							<br/>

							<!-- Clausula portabilidad --> 
							<label for="clause-portabilidad">
							<input 	name="clause-portabilidad" 
									type="checkbox" 
									id="clause-portabilidad" 
									value="1" 
									<?php ( $settings->get_setting( 'clause-portabilidad' ) == 1 ) && printf( 'checked' ); ?>
									>
									<?php esc_html_e( 'Permitir la Portabilidad de datos', 'argpd' ); ?>
							</label>
							<br/>

							<!-- clausula errores tipográficos -->
							<label for="clause-errores">
							<input 	name="clause-errores" 
									type="checkbox" 
									id="clause-errores" 
									value="1" 
									<?php ( $settings->get_setting( 'clause-errores' ) == 1 ) && printf( 'checked' ); ?>
									>
									<?php esc_html_e( 'Error tipográfico y fe de erratas', 'argpd' ); ?>
							</label>
							<br/>

							<!-- clausula renuncia fuero propio  -->
							<label for="clause-fuero">
							<input 	name="clause-fuero" 
									type="checkbox" 
									id="clause-fuero" 
									value="1" 
									<?php ( $settings->get_setting( 'clause-fuero' ) == 1 ) && printf( 'checked' ); ?>
									>
									<?php esc_html_e( 'Renuncia de fuero propio', 'argpd' ); ?>
							</label>
							<br/>

							</fieldset>
						</td>
					</tr>
				</tbody>
			</table>

			<?php submit_button(); ?>
			</div>
		</form>
		<?php
	}


	/**
	 * Echo 'Integracion' tab of plugin settings
	 *
	 * @since  0.0.0
	 */
	public function argpd_paginas_tab() {
		global $argpd_active_tab;
		$classname = ( ! empty( $argpd_active_tab ) && 'paginas' == $argpd_active_tab ) ? 'nav-tab-active' : '';
		?>
		<a 	class="nav-tab <?php echo esc_attr( $classname ); ?>" 
			href="<?php echo esc_url( admin_url( 'admin.php?page=argpd&tab=paginas' ) ); ?>">
			<?php esc_html_e( 'Textos Legales', 'argpd' ); ?> 
		</a>
		<?php
	}


	/**
	 * Echo 'Integracion' content of plugin settings
	 *
	 * @since  0.0.0
	 */
	public function argpd_paginas_content() {
		global $argpd_active_tab;
		if ( empty( $argpd_active_tab ) || 'paginas' != $argpd_active_tab ) {
			return;
		}

		$settings = $this->plugin->argpd_settings;
		?>
 
		<br/>
		<form method="post" action="admin-post.php">
			<?php wp_nonce_field( 'argpd' ); ?>
			<input type="hidden" value="argpd_pages_setup" name="action"/>
			<div class="argpd-panel">
				<h2 class="title"><?php esc_html_e( 'Páginas Legales', 'argpd' ); ?></h2>				
				<table class="wp-list-table widefat fixed striped posts">
					<thead>
						<tr>
							<td><?php esc_html_e( 'Texto Legal', 'argpd' ); ?></td>
							<td><?php esc_html_e( 'Página en la que aparece', 'argpd' ); ?></td>
							<td><?php esc_html_e( 'Ayuda', 'argpd' ); ?></td>
						</tr>
					</thead>
					<tbody>
						<!-- Aviso Legal -->
						<tr>
							<th scope="row">
								<?php
									$checked = ( $settings->get_setting( 'avisolegal-disabled' ) == 0 ) ? ( 'checked' ) : '';
								?>
								<label class="argpd-switch">
								  <input type="checkbox" name="avisolegal-enabled" <?php echo esc_attr( $checked ); ?>>
								  <span class="argpd-slider argpd-round"></span>
								</label>

								<label for="avisolegal"><?php esc_html_e( 'Aviso Legal', 'argpd' ); ?></label>
								<?php if ( $checked && $settings->get_setting( 'avisolegalID' ) != 0 ) { ?>
								<div class="row-actions">
									<span class="view argpd-view">
										<?php
										printf(
											'<a href="%s">%s</a>',
											esc_attr( $settings->get_setting( 'avisolegalURL' ) ),
											esc_html__( 'Ver', 'argpd' )
										);
										?>
									</span>
								</div>
								<?php } ?> 
							</th>
							<td>								
								<select name="avisolegal" id="avisolegal" class="<?php echo esc_attr( $settings->get_setting( 'avisolegal-disabled' ) == 0 ) ? '' : 'oculto'; ?>">
									<option value="0"
											<?php
											if ( $settings->get_setting( 'avisolegalID' ) == 0 ) {
												printf( 'selected="selected"' );}
											?>
											>
											Ninguna</option>
									<?php
									foreach ( get_pages() as $page ) {
										$selected = ( $page->ID == $settings->get_setting( 'avisolegalID' ) ) ? ( 'selected="selected"' ) : '';
										printf( '<option value="%s" %s>%s</option>', esc_attr( $page->ID ), esc_attr( $selected ), esc_html( $page->post_title ) );
									}
									?>
								</select>								

								<?php
								$match = false;
								foreach ( get_pages() as $page ) {
									if ( $page->ID == $settings->get_setting( 'avisolegalID' ) ) {
										$match = true;
									}
								}
								if ( ! $match && $settings->get_setting( 'avisolegal-disabled' ) == 0 ) {
									?>
								<p class="description avisolegal-description">
									Escoge la página dónde aparecerá <br/>el Aviso Legal, <a id="crear-pagina-legal" class="js-create-legal-page" style="cursor:pointer">crea una nueva</a> o usa el <br/>shortcode [argpd_aviso-legal/]
								</p>
								<?php } ?>
							</td>
							<td>
								<a 	href="https://superadmin.es/blog/que-es/lssi/" 
									class="button" 
									target="_blank"
									style="background-color: #03A9F4;color: white;border-color: #03A9F4;"
								>Qué es la LSSI</a>
							</td>
						</tr>

						<!-- Política de privacidad -->
						<tr>
							<th scope="row">
								<?php
									$checked = ( $settings->get_setting( 'privacidad-disabled' ) == 0 ) ? ( 'checked' ) : '';
								?>
								<label class="argpd-switch">
								  <input type="checkbox" name="privacidad-enabled" <?php echo esc_attr( $checked ); ?>>
								  <span class="argpd-slider argpd-round"></span>
								</label>

								<label for="privacidad"><?php esc_html_e( 'Política de Privacidad', 'argpd' ); ?></label>
								<?php if ( $checked && $settings->get_setting( 'privacidadID' ) != 0 ) { ?>
								<div class="row-actions">
									<span class="view argpd-view">
										<?php
										printf(
											'<a href="%s">%s</a>',
											esc_attr( $settings->get_setting( 'privacidadURL' ) ),
											esc_html__( 'Ver', 'argpd' )
										);
										?>
									</span>				
								</div>
								<?php } ?> 
							</th>
							<td>
								<select name="privacidad" id="privacidad" class="<?php echo esc_attr( $settings->get_setting( 'privacidad-disabled' ) == 0 ) ? '' : 'oculto'; ?>">
									<option value="0"
											<?php
											if ( $settings->get_setting( 'privacidadID' ) == 0 ) {
												printf( 'selected="selected"' );}
											?>
											>
											Ninguna</option>
									<?php
									foreach ( get_pages() as $page ) {
										$selected = ( $page->ID == $settings->get_setting( 'privacidadID' ) ) ? ( 'selected="selected"' ) : '';
										printf( '<option value="%s" %s>%s</option>', esc_attr( $page->ID ), esc_attr( $selected ), esc_html( $page->post_title ) );
									}
									?>
								</select>
								<?php
								$match = false;
								foreach ( get_pages() as $page ) {
									if ( $page->ID == $settings->get_setting( 'privacidadID' ) ) {
										$match = true;
									}
								}
								if ( ! $match && $settings->get_setting( 'privacidad-disabled' ) == 0 ) {
									?>
								<p class="description privacidad-description">
									Selecciona la página dónde aparecerá <br/>la Política de Privacidad, <a id="crear-pagina-privacidad" class="js-create-legal-page" style="cursor:pointer">crea una nueva</a> o usa el <br/>shortcode [argpd_politica-privacidad/]
								</p>
								<?php } ?>

							</td>
							<td>
								<a 	href="https://superadmin.es/blog/privacidad/crear-politica-de-privacidad-en-wordpress/?utm_source=wordpressorg&utm_campaign=adapta_rgpd&utm_medium=direct" 
									class="button" 
									target="_blank"
									style="background-color: #03A9F4;color: white;border-color: #03A9F4;"
								>Aprende a crear la Política de Privacidad</a>
							</td>
						</tr>

						<!-- Política de cookies -->
						<tr>
							<th scope="row">								
								<?php
									$checked = ( $settings->get_setting( 'cookies-disabled' ) == 0 ) ? ( 'checked' ) : '';
								?>
								<label class="argpd-switch">
								  <input type="checkbox" name="cookies-enabled" <?php echo esc_attr( $checked ); ?>>
								  <span class="argpd-slider argpd-round"></span>
								</label>

								<label for="cookies"><?php esc_html_e( 'Política de Cookies', 'argpd' ); ?></label>

								<?php if ( $checked && $settings->get_setting( 'cookiesID' ) != 0 ) { ?>
								<div class="row-actions">
									<span class="view argpd-view">
										<?php
										printf(
											'<a href="%s">%s</a>',
											esc_attr( $settings->get_setting( 'cookiesURL' ) ),
											esc_html__( 'Ver', 'argpd' )
										);
										?>
									</span>
								</div>
								<?php } ?> 
							</th>
							<td>
								<select name="cookies" id="cookies" class="<?php echo esc_attr( $settings->get_setting( 'cookies-disabled' ) == 0 ) ? '' : 'oculto'; ?>">
									<option value="0"
											<?php
											if ( $settings->get_setting( 'cookiesID' ) == 0 ) {
												printf( 'selected="selected"' );}
											?>
											>
											Ninguna</option>
									<?php
									foreach ( get_pages() as $page ) {
										$selected = ( $page->ID == $settings->get_setting( 'cookiesID' ) ) ? ( 'selected="selected"' ) : '';
										printf( '<option value="%s" %s>%s</option>', esc_attr( $page->ID ), esc_attr( $selected ), esc_html( $page->post_title ) );
									}
									?>
								</select>
								<?php
								$match = false;
								foreach ( get_pages() as $page ) {
									if ( $page->ID == $settings->get_setting( 'cookiesID' ) ) {
										$match = true;
									}
								}
								if ( ! $match && $settings->get_setting( 'cookies-disabled' ) == 0 ) {
									?>
									<p class="description cookies-description">
										Selecciona la página dónde aparecerá <br/>la Política de Cookies, <a id="crear-pagina-cookies" class="js-create-legal-page" style="cursor:pointer">crea una nueva</a> o usa el <br/>shortcode [argpd_politica-cookies/]
									</p>
								<?php } ?>
							</td>
							<td>
								<a 	href="https://superadmin.es/blog/privacidad/crear-banner-de-cookies-en-wordpress/?utm_source=wordpressorg&utm_campaign=adapta_rgpd&utm_medium=direct" 
									class="button" 
									target="_blank"
									style="background-color: #03A9F4;color: white;border-color: #03A9F4;"
								>Aprende a cumplir la Ley de Cookies</a>
							</td>
						</tr>
						<!-- Personalizar cookies -->
						<tr>
							<th scope="row">								
								<?php
									$checked = ( $settings->get_setting( 'custom-cookies-page-disabled' ) == 0 ) ? ( 'checked' ) : '';
								?>
								<label class="argpd-switch">
								  <input type="checkbox" name="custom-cookies-page-enabled" <?php echo esc_attr( $checked ); ?>>
								  <span class="argpd-slider argpd-round"></span>
								</label>

								<label for="custom-cookies-page"><?php esc_html_e( 'Preferencias de Cookies', 'argpd' ); ?></label>

								<?php if ( $checked && $settings->get_setting( 'custom-cookies-page-id' ) != 0 ) { ?>
								<div class="row-actions">
									<span class="view argpd-view">
										<?php
										printf(
											'<a href="%s">%s</a>',
											esc_attr( $settings->get_setting( 'custom-cookies-page-url' ) ),
											esc_html__( 'Ver', 'argpd' )
										);
										?>
									</span>
								</div>
								<?php } ?> 
							</th>
							<td>
								<select name="custom-cookies-page-id" id="custom-cookies-page-id" class="<?php echo esc_attr( $settings->get_setting( 'custom-cookies-page-disabled' ) == 0 ) ? '' : 'oculto'; ?>">
									<option value="0"
											<?php
											if ( $settings->get_setting( 'custom-cookies-page-id' ) == 0 ) {
												printf( 'selected="selected"' );}
											?>
											>
											Ninguna</option>
									<?php
									foreach ( get_pages() as $page ) {
										$selected = ( $page->ID == $settings->get_setting( 'custom-cookies-page-id' ) ) ? ( 'selected="selected"' ) : '';
										printf( '<option value="%s" %s>%s</option>', esc_attr( $page->ID ), esc_attr( $selected ), esc_html( $page->post_title ) );
									}
									?>
								</select>
								<?php
								$match = false;
								foreach ( get_pages() as $page ) {
									if ( $page->ID == $settings->get_setting( 'custom-cookies-page-id' ) ) {
										$match = true;
									}
								}
								if ( ! $match && $settings->get_setting( 'custom-cookies-page-disabled' ) == 0 ) {
									?>
									<p class="custom-cookies-page-description">
										Selecciona la página dónde aparecerá <br/>la Personalización de Cookies o <a id="create-custom-cookies-page" class="js-create-legal-page" style="cursor:pointer">créala</a>.
									</p>
								<?php } ?>
							</td>
							<td>
								<p class="description">
									Página que permite al usuario configurar sus preferencias en relación con las cookies.
								</p>
							</td>
						</tr>			
					</tbody>
				</table>
				<p>
					<?php esc_html_e( 'Textos revisados por profesionales legales y actualizados en 2022.', 'argpd' ); ?>
				</p>

	
				<table class="form-table">
					<tr>
						<td>
							<fieldset>
								<br/>
								<label  for="robots-index">
									<?php
										$checked = ( $settings->get_setting( 'robots-index' ) == 1 ) ? ( 'checked' ) : '';
									?>
									<input 	name="robots-index" 
											type="checkbox" 
											id="robots-index" 
											value="1"							
											<?php echo esc_attr( $checked ); ?>						
										>
									<?php esc_html_e( 'Los buscadores de Google y Bing indexan los textos legales', 'argpd' ); ?>
									<a 	href="https://superadmin.es/adapta-rgpd/nofollow-politica-privacidad/?utm_source=wordpressorg&utm_campaign=adapta_rgpd&utm_medium=direct" 
										target="_blank"
										rel="nofollow"
										>
										<span style="text-decoration: none" class="dashicons dashicons-editor-help"></span>
										Indexar o no indexar
									</a>
									<p class="description">
										<?php esc_html_e( 'No recomendado.', 'argpd' ); ?>			
									</p>
								</label>
							</fieldset>
						</td>
					</tr>
				</table>

				<?php submit_button(); ?>				
				
			</div>

			<br><br>
			<div class="argpd-panel">
				<h2 class="title"><?php esc_html_e( 'Primera capa informativa en formularios y pie de página', 'argpd' ); ?></h2>
				<p>
					<?php esc_html_e( 'Este apartado sirve para cumplir el deber de informar. Aprende los conceptos que necesitas en', 'argpd' ); ?> 
					<a href="https://superadmin.es/blog/privacidad/cumplir-deber-de-informar-rgpd/?utm_source=wordpressorg&utm_campaign=adapta_rgpd&utm_medium=direct" 
							 target="_blank"
							 >							
							<?php esc_html_e( 'esta guía.', 'argpd' ); ?>
					</a>
				</p>
				<hr/>
			
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row">
								<label><?php esc_html_e( 'Activar en', 'argpd' ); ?></label>
							</th>
							<td>
								<fieldset>
								<label for="option-comments">
									<input 	name="option-comments" 
										type="checkbox" 
										id="option-comments" 
										value="1"							
										<?php ( $settings->get_setting( 'option-comments' ) == 1 ) && printf( 'checked' ); ?>
										>
										<?php esc_html_e( 'Comentarios ', 'argpd' ); ?>
										<p class="description">
											<?php esc_html_e( 'Activa la primera capa informativa y la casilla de aceptación en los comentarios.', 'argpd' ); ?>
										</p>
								</label>
							<br/>

							<label  for="option-forms">
								<input 	name="option-forms" 
										type="checkbox" 
										id="option-forms" 
										value="1"							
										<?php ( $settings->get_setting( 'option-forms' ) == 1 ) && printf( 'checked' ); ?>
										>
										<?php esc_html_e( 'Formularios', 'argpd' ); ?>
										<a href="https://superadmin.es/blog/privacidad/adecuar-formulario-al-rgpd/?utm_source=wordpressorg&utm_campaign=adapta_rgpd&utm_medium=direct" 
											target="_blank"><span style="text-decoration: none" class="dashicons dashicons-editor-help"></span>
											<?php esc_html_e( 'Guía para adecuar los formularios', 'argpd' ); ?>
										</a>
								<p class="description">
									<?php esc_html_e( 'Recomendado.', 'argpd' ); ?>
								</p>
							</label>
							<br/>
							<br/>
							<b>Pie de página</b><br/>

							<label  for="option-footer">
								<input 	name="option-footer" 
										type="checkbox" 
										id="option-footer" 
										value="1"							
										<?php ( $settings->get_setting( 'option-footer' ) == 1 ) && printf( 'checked' ); ?>
										>
										<?php esc_html_e( 'Menú en el pie de página', 'argpd' ); ?>
										<a href="https://superadmin.es/adapta-rgpd/pie-de-pagina-ley-proteccion-de-datos/?utm_source=wordpressorg&utm_campaign=adapta_rgpd&utm_medium=direct" target="_blank">
											<span style="text-decoration: none;" class="dashicons dashicons-editor-help"></span>
											<?php esc_html_e( 'Añade más enlaces', 'argpd' ); ?>
										</a>
								<p class="description">
									<?php esc_html_e( 'Crea un menú en el pie de página con enlaces a los textos legales.', 'argpd' ); ?>
								</p>
							</label>
							<br/>
							<br/>
							<b>WooCommerce</b><br/>

							<label  for="option-wc-top-layer">
								<input 	name="option-wc-top-layer" 
										type="checkbox" 
										id="option-wc-top-layer" 
										value="1"							
										<?php ( $settings->get_setting( 'option-wc-top-layer' ) == 1 ) && printf( 'checked' ); ?>
										>
										<?php esc_html_e( 'Carrito de la compra', 'argpd' ); ?>
								<p class="description">
									<?php esc_html_e( 'Activa la primera capa informativa en la página de checkout de WooCommerce.', 'argpd' ); ?>
								</p>
							</label>
							<br/>

							<label  for="option-wc-promo">
								<input 	name="option-wc-promo" 
										type="checkbox" 
										id="option-wc-promo" 
										value="1"							
										<?php ( $settings->get_setting( 'option-wc-promo' ) == 1 ) && printf( 'checked' ); ?>
										>
										<?php esc_html_e( 'Consentimiento promocional', 'argpd' ); ?>
								<p class="description">
									<?php esc_html_e( 'Activa la casilla de consentimiento para promociones en la página de checkout de WooCommerce.', 'argpd' ); ?>
								</p>
							</label>

							<br/>
							<br/>
							<b>Otros</b><br/>
							<label>
								<input 	type="checkbox" 										
										value="1"							
										checked disabled 
										>
										<?php esc_html_e( 'Shortcodes', 'argpd' ); ?>
								<p class="description">									
									<span><?php esc_html_e( 'Inserta la capa informativa en cualquier lugar usando el shortcode:', 'argpd' ); ?></span>
									<br/>
									<?php esc_html_e( '[argpd_deber_de_informar finalidad="Cumplir con la prestación contratada" destinatarios="No se ceden los datos" legitimacion="Ejecución del contrato"/]', 'argpd' ); ?></span>
								</p>
							</label>
							</fieldset>
						</td>
					</tr>
					
					<!-- Texto de consentimiento -->
					<tr>
						<th scope="row">
							<label for="consentimiento-label"><?php esc_html_e( 'Textos', 'argpd' ); ?></label>
						</th>
						<td>
							<p class="argpd-label"><?php esc_html_e( 'Texto para solicitar el consentimiento en la primera capa informativa:', 'argpd' ); ?></p>

								<textarea 
									name="consentimiento-label" 
									id="consentimiento-label" 
									cols="60"
									rows="3"
									placeholder="He leído y acepto la política de privacidad."
									><?php echo esc_html( $settings->get_setting( 'consentimiento-label' ) ); ?></textarea>						
									<p class="description">
										<?php esc_html_e( 'Para mostrar el texto por defecto deja en blanco.', 'argpd' ); ?>	
									</p>
						</td>
					</tr>

					<!-- Texto de consentimiento promocional-->
					<tr>
						<th scope="row">
							
						</th>
						<td>
							<p class="argpd-label"><?php esc_html_e( 'Texto para solicitar el consentimiento promocional:', 'argpd' ); ?></p>

								<textarea 
									name="wc-consent-promo" 
									id="wc-consent-promo" 
									cols="60"
									rows="3"
									placeholder="Acepto recibir ofertas, noticias y otras recomendaciones sobre productos o servicios."
									><?php echo esc_html( $settings->get_setting( 'wc-consent-promo' ) ); ?></textarea>						
									<p class="description">
										<?php esc_html_e( 'Para mostrar el texto por defecto deja en blanco.', 'argpd' ); ?>	
									</p>
						</td>
					</tr>

					<!-- Diseño de las listas -->
								<tr>
									<th scope="row">
										<label><?php esc_html_e( 'Diseño', 'argpd' ); ?></label>
									</th>
									<td>
										<select name="informbox-theme" id="informbox-theme">
										<?php
											$informbox_themes = $settings->get_informbox_themes();
										foreach ( $informbox_themes as $key => $value ) {
											$selected = ( $key == $settings->get_setting( 'informbox-theme' ) ) ? ( 'selected="selected"' ) : '';
											printf( '<option value="%s" %s>%s</option>', esc_attr( $key ), esc_attr( $selected ), esc_html( $value ) );
										}
										?>
										</select>
									</td>
								</tr>

				</tbody>
			</table>
			<?php submit_button(); ?>
			</div>
				
		</form>
		
		<?php
	}


	/**
	 * Echo 'Integracion' tab of plugin settings
	 *
	 * @since  0.0.0
	 */
	public function argpd_cookies_tab() {
		global $argpd_active_tab;
		$classname = ( ! empty( $argpd_active_tab ) && 'cookies' == $argpd_active_tab ) ? 'nav-tab-active' : '';
		?>
		<a 	class="nav-tab <?php echo esc_attr( $classname ); ?>" 
			href="<?php echo esc_url( admin_url( 'admin.php?page=argpd&tab=cookies' ) ); ?>">
			<?php esc_html_e( 'Banner de Cookies', 'argpd' ); ?> 
		</a>
		<?php
	}


	/**
	 * Muestra el apartado "Ley de Cookies"
	 *
	 * @since  0.0.0
	 */
	public function argpd_cookies_content() {

		global $argpd_active_tab;

		if ( empty( $argpd_active_tab ) || 'cookies' != $argpd_active_tab ) {
			return;
		}

		$settings = $this->plugin->argpd_settings;
		$all_settings = $this->plugin->argpd_settings->get_settings();
		?>
 
		<form method="post" action="admin-post.php" class="pt20">
			<?php wp_nonce_field( 'argpd' ); ?>
			<input type="hidden" value="argpd_cookies_setup" name="action"/>
			
			<div class="argpd-panel">
				<h2 class="title"><?php esc_html_e( 'Banner de Cookies', 'argpd' ); ?></h2>			
				<p>
					<?php esc_html_e( 'Este apartado sirve para cumplir la ley de Cookies.', 'argpd' ); ?>
					<a 	href="https://superadmin.es/blog/privacidad/crear-banner-de-cookies-en-wordpress" 
						target="_blank"
						>
						Aprende más aquí.
					</a>
				</p>
				<div>					
					<hr/>
					<table class="form-table">
						<tbody>	
							<tr>
								<th scope="row">
									<label for="option-cookies"><?php esc_html_e( 'Activar', 'argpd' ); ?></label>
								</th>
								<td>
									<label  for="option-cookies">
									<input 	name="option-cookies" 
											type="checkbox" 
											id="option-cookies" 
											value="1"							
											<?php ( $settings->get_setting( 'option-cookies' ) == 1 ) && printf( 'checked' ); ?>
											>
											<?php esc_html_e( 'Banner de Cookies ', 'argpd' ); ?>
									</label>
								</td>
							</tr>								

							<tr>
								<th scope="row">
									<label for="cookies-label"><?php esc_html_e( 'Textos', 'argpd' ); ?></label>
								</th>
								<td>
									
									<p class="argpd-label"><?php esc_html_e( 'Texto para solicitar el consentimiento:', 'argpd' ); ?></p>
									<div style="max-width: 540px">
									<?php
										wp_editor( $settings->get_setting( 'cookies-label' ), "cookies-label", array(
											'textarea_rows' => 3,
											'media_buttons' => false,
											'quicktags' => false,
										) );
									?>
									</div>

									<p class="description">
										<?php esc_html_e( 'Para mostrar el texto por defecto deja en blanco.', 'argpd' ); ?>
									</p>
											
									<p class="argpd-label pt20"><?php esc_html_e( 'Texto para el enlace a la Política de cookies:', 'argpd' ); ?></p>
									<input 	name="cookies-linklabel" 
											type="text"
											id="cookies-linklabel" 
											size="25"
											value="<?php echo esc_attr( $settings->get_setting( 'cookies-linklabel' ) ); ?>"
											placeholder="Configurar y más información"
											>
													
									<p class="argpd-label pt20"><?php esc_html_e( 'Texto para el botón Aceptar:', 'argpd' ); ?></p>
									<input 	name="cookies-btnlabel" 
											id="cookies-btnlabel" 
											type="text"
											size="10"
											value="<?php echo esc_attr( $settings->get_setting( 'cookies-btnlabel' ) ); ?>"
											>

									<p class="argpd-label pt20"><?php esc_html_e( 'Texto para el botón Rechazar:', 'argpd' ); ?></p>
									<input 	name="cookies-rejectlabel" 
											id="cookies-rejectlabel" 
											type="text"
											size="10"
											value="<?php echo esc_attr( $settings->get_setting( 'cookies-rejectlabel' ) ); ?>"
											>
								</td>
							</tr>

							<?php if ( $settings->get_setting( 'cookies-disabled' ) == 1 ) : ?>
							<tr>
								<th scope="row">
									<label for="cookies">
									<?php
										printf(
											'%s<br>%s',
											esc_html__( 'Página vinculada a', 'argpd' ),
											esc_html__( 'la Política de Cookies', 'argpd' )
										);
									?>
									</label>										
								</th>
								<td>
									<select name="cookies-id" id="cookies-id">
										<option value="-1"
												<?php
												if ( ! strlen( $settings->get_setting( 'cookiesURL' ) == 0 ) ) {
													printf( 'selected="selected"' );}
												?>
												>
												Ninguna</option>											
											<?php
											foreach ( get_pages() as $page ) {
												$permalink = get_permalink( $page->ID );
												$selected = ( $permalink == $settings->get_setting( 'cookiesURL' ) ) ? ( 'selected="selected"' ) : '';
												printf( '<option value="%s" %s>%s</option>', esc_attr( $page->ID ), esc_attr( $selected ), esc_html( $page->post_title ) );
											}
											?>
									</select>
									<p class="description">											
										<?php esc_html_e( 'Selecciona la página a la que apunta el enlace "Ver Política de Cookies".', 'argpd' ); ?>
									</p>
								</td>
							</tr>
							<?php endif; ?>

							<tr>
								<th scope="row">
									<label for="cookies-theme"><?php esc_html_e( 'Diseño', 'argpd' ); ?></label>
								</th>
								<td>
									<select name="cookies-theme" id="cookies-theme">
										<?php
											$cookie_themes = $settings->get_cookie_themes();
											foreach ( $cookie_themes as $key => $value ) {
												$selected = ( $key == $settings->get_setting( 'cookies-theme' ) ) ? ( 'selected="selected"' ) : '';
												printf( '<option value="%s" %s>%s</option>', esc_attr( $key ), esc_attr( $selected ), esc_html( $value ) );
											}
										?>
									</select>		
									<a 	href="https://superadmin.es/adapta-rgpd/personalizar-banner-cookies" target="_blank">
										<span style="text-decoration: none" class="dashicons dashicons-editor-help"></span>
										<?php esc_html_e('Cómo personalizar con CSS', 'argpd'); ?>
									</a>
									<br/><br/>
									<img id="theme-preview" src="" width="500px">
									<br/><br/>
									
									<label  for="cookies-settings-button">
										<input 	name="cookies-settings-button" 
												type="checkbox" 
												id="cookies-settings-button"
												value="1"							
												<?php ( $settings->get_setting( 'cookies-settings-button' ) == 1 ) && printf( 'checked' ); ?>
												>
												<?php esc_html_e( 'Botón para &laquo;Configurar cookies&raquo;', 'argpd' ); ?> 
												<br/>
												<p class="description">
													<?php esc_html_e( 'Recomendado', 'argpd' ); ?>
												</p>
									</label>

									<label  for="cookies-sticky-button">
										<input 	name="cookies-sticky-button" 
												type="checkbox" 
												id="cookies-sticky-button"
												value="1"							
												<?php ( $settings->get_setting( 'cookies-sticky-button' ) == 1 ) && printf( 'checked' ); ?>
												>
												<?php esc_html_e( 'Botón flotante para mostrar el Banner de Cookies', 'argpd' ); ?> 
												<br/>
												<p class="description">
													<?php esc_html_e( 'Recomendado', 'argpd' ); ?>
												</p>
									</label>
								</td>
							</tr>	

						</tbody>
					</table>
				</div>
				<?php submit_button(); ?>
			</div>

			<div class="argpd-panel">
				<h2 class="title"><?php esc_html_e( 'Listado de Cookies', 'argpd' ); ?></h2>			
				<hr/>
				<table class="form-table">
					<tbody>	
						<tr>
							<th scope="row">
								<label for="js-search-cookies">
								<?php
									printf(
										'%s<br>%s',
										esc_html__( 'Listado', 'argpd' ),
										esc_html__( 'de cookies', 'argpd' )
									);
								?>
								</label>
							</th>
							<td>
								<div>
								<?php
										wp_editor( $all_settings['lista-cookies'], "cookies-list", array(
											'textarea_rows' => 10,
											'media_buttons' => false,
											'quicktags' => false,
										) );
								?>

								</div>
								<div>
									<br/>
									<a 	id="js-search-cookies"
										class="button button-primary <?php ( $settings->get_setting( 'apikey' ) == "" ) && printf( 'button-disabled' ); ?>"
										value="<?php esc_attr_e( 'Detectar cookies ahora', 'argpd' ); ?>" 
										>											
										<?php esc_html_e( 'Detectar cookies ahora', 'argpd' ); ?>
									</a>
								</div>
								<p class="api-message"></p>
								<?php if ( $settings->get_setting( 'apikey' ) == "" ) : ?>
								<p class="description">
									Para activar el detector de cookies obtén una clave de API. Para más detalles, consulta <a href="<?php echo esc_attr( admin_url( 'admin.php?page=argpd-addons' ) ); ?>">aquí</a>.
								</p>
								<?php endif ?>
							</td>
						</tr>
					</tbody>
				</table>
				<div>
					<?php submit_button(); ?>
				</div>
			</div>

			<div class="argpd-panel">
				<h2 class="title"><?php esc_html_e( 'Bloqueo de Cookies', 'argpd' ); ?></h2>
				<hr/>
				<table class="form-table">
					<tbody>	
					<?php /* Bloqueo de scripts */ ?>
						<tr>
							<th scope="row">
								<label for="cookies-linklabel">
								<?php
									printf(
										'%s<br>%s',
										esc_html__( 'Bloqueo de', 'argpd' ),
										esc_html__( 'scripts', 'argpd' )
									);
								?>
								</label>
							</th>
							<td>
								<div>
									<div>
										<label for="cookies-filter-known-scripts">
											<input 	name="cookies-filter-known-scripts" 
													type="checkbox" 
													id="cookies-filter-known-scripts"
													value="1"							
													<?php ( $settings->get_setting( 'cookies-filter-known-scripts' ) == 1 ) && printf( 'checked' ); ?>
													>
													<?php esc_html_e( 'Bloquea scripts conocidos', 'argpd' ); ?>
										</label>
										<p class="description">
											<?php esc_html_e( 'Bloquea los scripts conocidos de analítica como Google analytics, Recaptcha, Facebook analytics, ... y de redes sociales como Twitter o Disqus mientras no haya consentimiento.', 'argpd' ); ?>
											<br/>											
											<?php esc_html_e( 'Recomendado.', 'argpd' ); ?>
										</p>
									</div>
									<div>
										<label  for="remove-iframes">
											<input 	name="remove-iframes" 
													type="checkbox" 
													id="remove-iframes"
													value="1"							
													<?php ( $settings->get_setting( 'remove-iframes' ) == 1 ) && printf( 'checked' ); ?>
													>
													<?php esc_html_e( 'Bloquea iframes', 'argpd' ); ?>
										</label>
										<p class="description">
											<?php esc_html_e( 'Bloquea iframes mientras no haya consentimiento.', 'argpd' ); ?>
											<br/>											
											<?php esc_html_e( 'Recomendado.', 'argpd' ); ?>
										</p>
									</div>									
									
									<br/><br/><b><?php esc_html_e( 'Bloquea scripts registrados por plugins instalados', 'argpd' ); ?></b><br/><br/>
										<?php
										$collection = $this->collect_assets();
										foreach ( $collection as $el => &$i ) {
											$checked = '';
											$scripts = $settings->get_setting( 'scripts-reject' );
											if ( is_array( $scripts ) || is_object( $scripts ) ) {
												foreach ( $scripts as $script ) {
													if ( $script == $el ) {
														$checked = 'checked';
													}
												}
											}
											?>
											<div style="padding: 2px 0">
												<label class="argpd-switch">												
													<input 
														id="scripts-reject-<?php echo esc_attr( $el ); ?>"
														name="scripts-reject-<?php echo esc_attr( $el ); ?>"
														type="checkbox" <?php echo esc_attr( $checked ); ?>>
													<span class="argpd-slider argpd-round"></span>
												</label>
											<?php
												printf( '%s (%s)', esc_html( $i['title'] ), esc_html( $i['script_name'] ) );
											?>
											</div>
											<?php
										}

										if ( sizeof( $collection ) == 0 ) { ?>
											<p class="description">
												<?php esc_html_e( 'Ningún script detectado.', 'argpd' ); ?>
											</p>
										<?php } else { ?>
											<p class="description">
												<?php esc_html_e( 'Desactiva los scripts marcados mientras el usuario no dé el consentimiento para instalar cookies.', 'argpd' ); ?>												
											</p>
										<?php }
										?>

								</div>
								
								<br/><br/><b><?php esc_html_e( 'Avanzado', 'argpd' ); ?></b><br/><br/>
								<div>
									<label  for="cookies-reload">
									<input 	name="cookies-reload" 
											type="checkbox" 
											id="cookies-reload" 
											value="1"							
											<?php ( $settings->get_setting( 'cookies-reload' ) == 1 ) && printf( 'checked' ); ?>
											>
											<?php esc_html_e( 'Recarga la página cuando el usuario acepte las cookies', 'argpd' ); ?>
									</label>
									<p class="description">
										<?php esc_html_e( 'Recomendado.', 'argpd' ); ?>			
									</p>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<div>
					<?php submit_button(); ?>
				</div>
			</div>
		</form>
	<?php
	}

	/**
	 * Echo 'Ayuda' tab of plugin settings
	 *
	 * @since  0.0.0
	 */
	public function argpd_ayuda_tab() {
		global $argpd_active_tab;
		$classname = ( ! empty( $argpd_active_tab ) && 'ayuda' == $argpd_active_tab ) ? 'nav-tab-active' : '';
		?>
		<a 	class="nav-tab <?php echo esc_attr( $classname ); ?>" 
			href="<?php echo esc_url( admin_url( 'admin.php?page=argpd&tab=ayuda' ) ); ?>">
			<?php esc_html_e( 'Ayuda', 'argpd' ); ?> 
		</a>
		<?php
	}

	/**
	 * Echo 'Ayuda' content of plugin settings
	 *
	 * @since  0.0.0
	 */
	public function argpd_ayuda_content() {
		global $argpd_active_tab;
		if ( empty( $argpd_active_tab ) || 'ayuda' != $argpd_active_tab ) {
			return;
		}
		?>
 
			<div>
				<h2 class="title"><?php esc_html_e( 'Ayuda', 'argpd' ); ?></h2>
				
				<?php
					echo $this->plugin->pages->help_tab_view();
					echo $this->plugin->pages->disclaimer();
				?>

			</div>		
		<?php
	}

	/**
	 * Echo plugin settings view
	 *
	 * @since  0.0.0
	 */
	public function options_ui() {
		global $argpd_active_tab;
		$argpd_active_tab = ! empty( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'ajustes';
		$this->ui_header();

		$settings = $this->plugin->argpd_settings;
		if ( $settings->get_setting( 'renuncia' ) == 0 ) { return; }
		?>
		<div class="wrap">
			<div>
				<h2 class="nav-tab-wrapper">
					<?php
					do_action( 'argpd_settings_tab' );
					?>
				</h2>
		
				<?php
					do_action( 'argpd_settings_content' );
				?>
			</div>
			<?php
				$this->ui_footer();
			?>
		</div>
		<?php
	}


	/**
	 * echo addons_ui page
	 *
	 * @since  1.3.5
	 */
	public function addons_ui() {
		global $argpd_active_tab;
		$argpd_active_tab = ! empty( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'settings';

		$this->ui_header();

		$settings = $this->plugin->argpd_settings;
		$all_settings = $this->plugin->argpd_settings->get_settings();
		if ( $settings->get_setting( 'renuncia' ) == 0 ) { return; }
		?>

		<div class="wrap">			
			<form method="post" action="admin-post.php" class="pt20">
				<?php wp_nonce_field( 'argpd' ); ?>
				<input type="hidden" value="argpd_addons_setup" name="action"/>
				
				<div class="argpd-panel">
					<h2 class="title"><?php esc_html_e( 'Clave de la API', 'argpd' ); ?></h2>
					<div>					
						<hr/>
						<table class="form-table">
							<tbody>	
								<tr>
									<th scope="row">
										<label for="option-apikey"><?php esc_html_e( 'Clave de la API', 'argpd' ); ?></label>
									</th>
									<td>
										<div>
											Consigue tu Clave API. Podrás escanear tu sitio y obtener información detallada de las cookies instaladas, Local Storage, pixels y otras tecnologías de rastreo con sólo hacer click en un botón y, la versión plus recoger consentimientos de tus visitantes. Para más detalles, <a href="https://superadmin.es/adapta-rgpd/subscribete/"> clica aquí para conseguir tu clave</a>.
										</div>
										<div class="pt20">
										<input 	type="text" 
												name="apikey" 
												id="js-apikey"
												value="<?php echo esc_attr( $settings->get_setting( 'apikey' ) ); ?>" 
												/>
										</div>
										<div>
											<?php submit_button(); ?>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</form>
		</div>
		<?php
		$this->ui_footer();
	}


	/**
	 * echo addons_ui page
	 *
	 * @since  1.3.5
	 */
	public function consents_ui() {
		global $argpd_active_tab;
		$argpd_active_tab = ! empty( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'settings';

		$this->ui_header();

		$settings = $this->plugin->argpd_settings;
		$all_settings = $this->plugin->argpd_settings->get_settings();
		if ( $settings->get_setting( 'renuncia' ) == 0 ) { return; }
		?>

		<div class="wrap">			
			<form method="post" action="admin-post.php" class="pt20">
				<?php wp_nonce_field( 'argpd' ); ?>
				<input type="hidden" value="argpd_consents_setup" name="action"/>
				<div class="argpd-panel">
					<h2 class="title"><?php esc_html_e( 'Consentimientos', 'argpd' ); ?></h2>
					<div>					
						<hr/>
						<table class="form-table">
							<tbody>
								<tr>	
									<th>						
										<label for="option-store-consents"><?php esc_html_e( 'Recoger consentimientos', 'argpd' ); ?></label>
									</th>
									<td>
										<?php										
										$disabled = strlen ( $settings->get_setting( 'apikey' ) ) == 0;
										if ( $disabled ) {
											$atts = 'disabled';
										} else {
											$atts = $settings->get_setting( 'option-store-consents' ) == 1  ? ( 'checked' ) : '';
										}
										?>
										<label class="argpd-switch">
										  <input type="checkbox" id="option-store-consents-switch" name="option-store-consents" <?php echo esc_attr( $atts ); ?>>
										  <span class="argpd-slider argpd-round"></span>
										</label>
										
										<a href="https://superadmin.es/adapta-rgpd/documentacion-del-consentimiento/" target="_blank">
										<span style="text-decoration: none" class="dashicons dashicons-editor-help"></span>
										<?php esc_html_e('Documentación del consentimiento', 'argpd'); ?>

										<?php if ( $disabled ) : ?>
										<p class="description">
											Para activar el gestor de consentimientos obtén una clave de API. Para más detalles, consulta <a href="<?php echo esc_attr( admin_url( 'admin.php?page=argpd-addons' ) ); ?>">aquí</a>.
										</p>
										<?php endif ?>
									</td>
								</tr>
								<tr>
									<td>
										<?php submit_button(); ?>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<?php if ( !$disabled && $settings->get_setting( 'option-store-consents' ) == 1 ) : ?>
						<br/><h2>Registro de consentimientos <small>(<span id="js-current">0</span> de <span id="js-quota">0</span> en los últimos 30 días)</small></h2>
						<p class="api-message"></p>
						<div>
							<table class="form-table">
								<tbody>	
									<tr>
										<td>
											<div class="pt20">
											<input 	type="text" 
													name="consent" 
													id="js-consent-uuid"
													/>
											</div>
											<br/>
											<div>
												<a 	id="js-search-by-consent-uuid"
													class="button button-primary"
													>											
													<?php esc_html_e( 'Buscar', 'argpd' ); ?>
												</a>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>

						<div>			
							<table id="argpd-table-consents" class="display" style="width:100%">
								<thead>
									<tr>
										<th class="dt-head-left" style="text-align: center; max-width: 150px"><?php esc_html_e( 'Id', 'argpd' ); ?></th>
										<th class="dt-head-left" style="text-align: center; max-width: 120px"><?php esc_html_e( 'Fecha', 'argpd' ); ?></th>
										<th class="dt-head-left" style="text-align: center; max-width: 60px"><?php esc_html_e( 'Usuario', 'argpd' ); ?></th>
										<th class="dt-head-left" style="text-align: center; max-width: 60px"><?php esc_html_e( 'Ip', 'argpd' ); ?></th>		
										<th class="dt-head-left" style="text-align: center; max-width: 120px"><?php esc_html_e( 'User agent', 'argpd' ); ?></th>
										<th class="dt-head-left" style="text-align: center; max-width: 60px"><?php esc_html_e( 'Url', 'argpd' ); ?></th>
										<th class="dt-head-left" style="text-align: center; max-width: 40px"><?php esc_html_e( 'Nec.', 'argpd' ); ?></th>
										<th class="dt-head-left" style="text-align: center; max-width: 40px"><?php esc_html_e( 'No nec.', 'argpd' ); ?></th>
										<th class="dt-head-left" style="text-align: center; max-width: 40px"><?php esc_html_e( 'Anltca', 'argpd' ); ?></th>
										<th class="dt-head-left" style="text-align: center; max-width: 40px"><?php esc_html_e( 'Markt.', 'argpd' ); ?></th>
										<th class="dt-head-left" style="text-align: center; max-width: 40px"><?php esc_html_e( 'Promoc.', 'argpd' ); ?></th>
										<th class="dt-head-left" style="text-align: center; max-width: 40px"><?php esc_html_e( 'Raw', 'argpd' ); ?></th>
									</tr>
								</thead>
								<tbody></tbody>
								<tfoot>
									<tr>
										<th class="dt-head-left" style="text-align: center; max-width: 150px"><?php esc_html_e( 'Id', 'argpd' ); ?></th>
										<th class="dt-head-left" style="text-align: center; max-width: 120px"><?php esc_html_e( 'Fecha', 'argpd' ); ?></th>
										<th class="dt-head-left" style="text-align: center; max-width: 60px"><?php esc_html_e( 'Usuario', 'argpd' ); ?></th>				
										<th class="dt-head-left" style="text-align: center; max-width: 60px"><?php esc_html_e( 'IP', 'argpd' ); ?></th>		
										<th class="dt-head-left" style="text-align: center; max-width: 120px"><?php esc_html_e( 'User agent', 'argpd' ); ?></th>
										<th class="dt-head-left" style="text-align: center; max-width: 60px"><?php esc_html_e( 'Url', 'argpd' ); ?></th>
										<th class="dt-head-left" style="text-align: center; max-width: 40px"><?php esc_html_e( 'Nec.', 'argpd' ); ?></th>
										<th class="dt-head-left" style="text-align: center; max-width: 40px"><?php esc_html_e( 'No nec.', 'argpd' ); ?></th>
										<th class="dt-head-left" style="text-align: center; max-width: 40px"><?php esc_html_e( 'Anltca', 'argpd' ); ?></th>
										<th class="dt-head-left" style="text-align: center; max-width: 40px"><?php esc_html_e( 'Markt.', 'argpd' ); ?></th>
										<th class="dt-head-left" style="text-align: center; max-width: 40px"><?php esc_html_e( 'Promoc.', 'argpd' ); ?></th>
										<th class="dt-head-left" style="text-align: center; max-width: 40px"><?php esc_html_e( 'Raw', 'argpd' ); ?></th>
									</tr>
								</tfoot>
							</table>
 							<div id="argpd-raw-consent-popup" class="argpd-popup">
    						    <div class="content">
    						    	<pre id="raw-consent-content"></pre>
    						        <span class="js-close-raw-popup"><?php esc_html_e( 'Cerrar', 'argpd' ); ?></span>
    						    </div>
    						</div>
						</div>
					<?php endif ?>
				</div>
			</form>
		</div>
		<?php
		$this->ui_footer();
	}

	/**
	 * Echo plugin settings view
	 *
	 * @since  1.3.5
	 */
	public function ui_footer() { 
		?>
		<hr/>
		<p style="font-size: 1.1em; text-align: center">
			★ <a title="superadmin.es - Hosting Premium WordPress Administrado" href="https://superadmin.es" target="blank">Superadmin.es</a> ★ 
			<br/>Hosting Premium WordPress Administrado
		</p
	<?php }
	/**
	 * Echo plugin settings view
	 *
	 * @since  1.3.5
	 */
	public function ui_header() { 
		$message       = __( 'Algo fue mal.', 'argpd' );
		$message_class = 'notice-success';

		if ( isset( $_GET['message'] ) ) {
			switch ( $_GET['message'] ) {
				case 'saved':
					$message = __( 'Los cambios se han guardado.', 'argpd' );
					break;
				default:
					$message       = __( 'La página ya existe.', 'argpd' );
					$message_class = 'notice-error';
					break;
			}
			?>
			<div id="message" 
				 class="notice <?php echo esc_attr( $message_class ); ?> is-dismissible"
				 >
				 <p><?php echo esc_html( $message ); ?></p>
				 <button type="button" 
						  class="notice-dismiss"
						  >
						  <span class="screen-reader-text">
							  Descartar este aviso.
						  </span>
				</button>
			</div>
		<?php } ?>
		
		<div class="wrap">		
			<h1>Cumple con la RGPD</h1>
			
			<p style="font-size: 1.1em">
				<b>¡Ayuda a mejorar el plugin!</b> Danos tu valoración de ★★★★★ <span><b><a href="https://wordpress.org/support/plugin/adapta-rgpd/reviews?rate=5#new-post">aquí</a>.</b></span>&nbsp;
			</p

			<?php
				$settings = $this->plugin->argpd_settings;
			if ( $settings->get_setting( 'renuncia' ) == 0 ) {
				?>
				<div>
					<div>
						<?php echo $this->plugin->pages->disclaimer(); ?>
						<form method="post" action="admin-post.php">
						<?php wp_nonce_field( 'argpd' ); ?>
							<input type="hidden" value="argpd_disclaimer" name="action"/>

							<p class="submit">
								<input 	type="submit" 
										name="submit" 
										id="submit" 
										class="button button-primary" 
										value="Aceptar">
							</p>
						</form>
					</div>
				</div>		
			<?php }
			?>
		</div>
		<?php
	}


	/**
	 * Exception for address starting from "//example.com" instead of
	 * "http://example.com". WooCommerce likes such a format
	 *
	 * @param string $url   Incorrect URL.
	 *
	 * @return string      Correct URL.
	 */
	public function prepare_url( $url ) {
		if ( isset( $url[0] ) && isset( $url[1] ) && '/' == $url[0] && '/' == $url[1] ) {
			$out = ( is_ssl() ? 'https:' : 'http:' ) . $url;
		} else {
			$out = $url;
		}

		return $out;
	}

	/**
	 * Get plugin data from folder name
	 *
	 * @param $name
	 *
	 * @return array
	 */
	public function get_plugin_data( $name ) {
		$data = [];

		if ( $name ) {
			if ( ! function_exists( 'get_plugins' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}
			$all_plugins = get_plugins();
			if ( ! empty( $all_plugins ) ) {
				foreach ( $all_plugins as $plugin_path => $plugin_data ) {
					if ( strpos( $plugin_path, $name . '/' ) !== false ) {
						$data             = $plugin_data;
						$data['basename'] = $plugin_path;
						break;
					}
				}
			}
		}

		return $data;
	}

	/**
	 * Get information regarding used assets
	 *
	 * @return bool
	 */
	public function collect_assets() {
		$collection = [];
		global $wp_scripts;
		$data = $wp_scripts;

		foreach ( $data->done as $el ) {
			if ( isset( $data->registered[ $el ] ) ) {

				if ( 'argpd-cookies-eu-banner' == $el ) {
					continue;
				}

				if ( isset( $data->registered[ $el ]->src ) ) {
					$url       = $this->prepare_url( $data->registered[ $el ]->src );
					$url_short = str_replace( get_home_url(), '', $url );

					if ( strpos( $url, plugins_url() ) !== 0 ) {
						continue;
					}

					$clean_url     = str_replace( WP_PLUGIN_URL . '/', '', $url );
					$url_parts     = explode( '/', $clean_url );
					$resource_name = ! empty( $url_parts[0] ) ? $url_parts[0] : null;

					if ( ! isset( $collection[ $el ] ) ) {
						$plugin_data = $this->get_plugin_data( $resource_name );
						$collection[ $el ] = [
							'url_full'  => $url,
							'url_short' => $url_short,
							'resource_name' => $resource_name,
							'script_name' => substr( $url_short, strrpos( $url_short, '/' ) + 1 ),
							'title' => $plugin_data['Title'],
							'author' => $plugin_data['Author'],
							'el' => $el,
						];
					}
				}
			}
		}
		return $collection;
	}

	/**
	 * Get shifts data via Ajax.
	 *
	 * @since  0.0.0
	 */
	public function ajax_consents_load_data() {
		check_ajax_referer( 'consents_load_data', 'security' );		

		$settings = $this->plugin->argpd_settings;
		$option_store_consents = $settings->get_setting( 'option-store-consents' );
		$apikey = $settings->get_setting( 'apikey' );
		$jwt_token = "";

		if ($option_store_consents && strlen($apikey) > 0 ) {
			// get auth
			$args = array(
				'method' => 'POST',
			    'headers' => array(
			   	'Content-Type' => 'application/json'
			    ),
			   'body' => json_encode(array('token' => $apikey )),
			);
			$response = wp_remote_post ("https://superapis.es/legaltech360/api/v1/auth", $args);
			if ( is_wp_error( $response ) ) {
			   wp_die();
			} else {
			   $jwt_token = $response['body'];
			}

			if ( strlen( $jwt_token ) == 0 ) {
				wp_die();
			}

			// retrieve consents.
			$args = array(
				'method' => 'GET',
			    'headers' => array(
			   	'Content-Type' => 'application/json',
			   	'Authorization' => 'Bearer ' . $jwt_token,
			   	'Origin' => esc_url ( get_site_url() ),
			    ),
			);

			$url = "https://superapis.es/legaltech360/api/v1/consents/consent";
			$filter = trim( sanitize_text_field ( $_REQUEST['filter'] ) );

			if ( strlen( $filter ) ) {
				$url = sprintf( "%s/%s", $url, $filter );
			}
			

			$response = wp_remote_post ($url, $args);
			if ( is_wp_error( $response ) ) {
			   wp_die();
			} else {
			   echo $response['body'];
			}			
		}
		wp_die();
	}
}
