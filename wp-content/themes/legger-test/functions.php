<?php
add_action( 'after_setup_theme', 'blankslate_setup' );
function blankslate_setup() {
load_theme_textdomain( 'blankslate', get_template_directory() . '/languages' );
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'responsive-embeds' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'html5', array( 'search-form', 'navigation-widgets' ) );
add_theme_support( 'appearance-tools' );
add_theme_support( 'woocommerce' );
global $content_width;
if ( !isset( $content_width ) ) { $content_width = 1920; }
register_nav_menus( array( 'main-menu' => esc_html__( 'Main Menu', 'blankslate' ) ) );
}
add_action( 'wp_enqueue_scripts', 'blankslate_enqueue' );
function blankslate_enqueue() {
wp_enqueue_style( 'blankslate-style', get_stylesheet_uri() );
wp_enqueue_script( 'jquery' );
}
add_filter( 'document_title_separator', 'blankslate_document_title_separator' );
function blankslate_document_title_separator( $sep ) {
$sep = esc_html( '|' );
return $sep;
}
add_filter( 'the_title', 'blankslate_title' );
function blankslate_title( $title ) {
if ( $title == '' ) {
return esc_html( '...' );
} else {
return wp_kses_post( $title );
}
}
function blankslate_schema_type() {
$schema = 'https://schema.org/';
if ( is_single() ) {
$type = "Article";
} elseif ( is_author() ) {
$type = 'ProfilePage';
} elseif ( is_search() ) {
$type = 'SearchResultsPage';
} else {
$type = 'WebPage';
}
echo 'itemscope itemtype="' . esc_url( $schema ) . esc_attr( $type ) . '"';
}
add_filter( 'nav_menu_link_attributes', 'blankslate_schema_url', 10 );
function blankslate_schema_url( $atts ) {
$atts['itemprop'] = 'url';
return $atts;
}
if ( !function_exists( 'blankslate_wp_body_open' ) ) {
function blankslate_wp_body_open() {
do_action( 'wp_body_open' );
}
}
add_filter( 'big_image_size_threshold', '__return_false' );
add_filter( 'intermediate_image_sizes_advanced', 'blankslate_image_insert_override' );
function blankslate_image_insert_override( $sizes ) {
unset( $sizes['medium_large'] );
unset( $sizes['1536x1536'] );
unset( $sizes['2048x2048'] );
return $sizes;
}
add_action( 'wp_head', 'blankslate_pingback_header' );
function blankslate_pingback_header() {
if ( is_singular() && pings_open() ) {
printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
}
}
// Add Bootstrap Framework
function enqueue_assets() {
    // Registrar Bootstrap CSS
    wp_enqueue_style(
        'bootstrap-css',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        array(),
        '5.3.3', 
        'all'
    );
    // Registrar Bootstrap JS
    wp_enqueue_script(
        'bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
        array(),
        '5.3.3',
        true
    );
    // Registrar Custom JS
    wp_enqueue_script(
        'main-js',
        get_template_directory_uri() . '/js/main.js',
        array(),
        true
    ); 
}
add_action('wp_enqueue_scripts', 'enqueue_assets');

// Enqueue form Ajax
function dcms_insert_custom_js(){
	wp_register_script('dcms_script', get_stylesheet_directory_uri(). '/js/form.js', array('jquery'), '1.0.0', true );
	wp_localize_script('dcms_script', 'dcms_form',
		[ 'ajaxUrl'=>admin_url('admin-ajax.php'),
		  'frmNonce' => wp_create_nonce('secret-key-form')
		]);
	wp_enqueue_script('dcms_script');
}
add_action('wp_enqueue_scripts', 'dcms_insert_custom_js');

// Create the Register form
add_filter('the_content', 'dcms_show_contact_ajax_form');
function dcms_show_contact_ajax_form( $content ){
	if ( ! is_page('registro') ) return $content;
	ob_start();
	?>
    <form id="form-registro" class="p-4 p-md-5 border rounded-3 bg-light" action="">
        <h3 class="pb-4 text-body-tertiary"><span class="circle-number">1</span> Inscripción punto de venta</h3>
        <!-- Campo Nombre del Cliente -->
        <div class="mb-3">
            <input type="text" class="form-control" id="name" name="name" placeholder="Nombre del Cliente" required pattern="^[A-Za-zÀ-ÿÑñ\s]+$" title="Solo se permiten letras, incluidas tildes y ñ.">
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" id="nit" name="nit" placeholder="NIT" required pattern="^[^#“,*+¿¡?]+$" title="No se permiten caracteres especiales (# “ , * + ¿ ¡ ?).">
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" id="namePunto" name="namePunto" placeholder="Nombre del punto" pattern="^[^#“,*+¿¡?]+$" title="No se permiten caracteres especiales (# “ , * + ¿ ¡ ?).">
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" id="nameEquipo" name="nameEquipo" placeholder="Nombre del equipo" pattern="^[^#“,*+¿¡?]+$" title="No se permiten caracteres especiales (# “ , * + ¿ ¡ ?).">
        </div>
        <select class="form-select mb-3" id="city" name="city">
            <option value="" disabled selected>Ciudad</option>
            <option value="bogota">Bogotá</option>
            <option value="medellin">Medellín</option>
            <option value="cali">Cali</option>
            <option value="barranquilla">Barranquilla</option>
            <option value="cartagena">Cartagena</option>
            <option value="bucaramanga">Bucaramanga</option>
            <option value="cucuta">Cúcuta</option>
            <option value="pereira">Pereira</option>
            <option value="santa_marta">Santa Marta</option>
            <option value="ibague">Ibagué</option>
            <option value="manizales">Manizales</option>
            <option value="villavicencio">Villavicencio</option>
            <option value="neiva">Neiva</option>
            <option value="armenia">Armenia</option>
        </select>
        <div class="mb-3">
            <input type="text" class="form-control" id="promotor" name="promotor" placeholder="Promotor" pattern="^[^#“,*+¿¡?]+$" title="No se permiten caracteres especiales (# “ , * + ¿ ¡ ?).">
        </div>
        <div class="mb-3">
            <?php $rtc = isset($_GET['rtc']) ? sanitize_text_field($_GET['rtc']) : ''; ?>
            <input type="number" readonly value="<?php echo $rtc; ?>" class="form-control" id="rtc" name="rtc" placeholder="RTC">
        </div>
        <div class="mb-3">
            <input type="text" oninput="this.value = this.value.toLowerCase();" class="form-control" id="capitan" name="capitan" placeholder="Capitán y/o Usuario (Solo minúsculas)" pattern="^[^#“,*+¿¡?]+$" title="No se permiten caracteres especiales (# “ , * + ¿ ¡ ?).">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="dataPolicy" name="dataPolicy" required>
            <label for="dataPolicy" class="form-check-label">He leido y acepto las politicas de tratamiento de datos personales. Conoce los <a href="#">Terminos y condiciones</a></label>
        </div>
        <input type="hidden" id="ip" name="ip">
        <button class="w-100 btn btn-lg btn-primary" id="submit" type="submit">Siguiente</button>
    </form>
	<?php
	$htm_form = ob_get_contents();
	ob_end_clean();

	return $content . $htm_form;
}

function dcms_process_contact_form() {
	$nonce = $_POST['nonce']??'';

	dcms_validate_nonce($nonce, 'secret-key-form');

    $form_data = [
        'name_cliente' => sanitize_text_field($_POST['name']),
        'nit' => sanitize_text_field($_POST['nit']),
        'name_punto' => isset($_POST['namePunto']) ? sanitize_text_field($_POST['namePunto']) : null,
        'name_equipo' => isset($_POST['nameEquipo']) ? sanitize_text_field($_POST['nameEquipo']) : null,
        'city' => isset($_POST['city']) ? sanitize_text_field($_POST['city']) : null,
        'promotor' => isset($_POST['promotor']) ? sanitize_text_field($_POST['promotor']) : null,
        'rtc' => isset($_POST['rtc']) ? sanitize_text_field($_POST['rtc']) : null,
        'capitan' => isset($_POST['capitan']) ? sanitize_text_field($_POST['capitan']) : null,
        'acepta_terminos' => isset($_POST['dataPolicy']) ? 1 : 0,
        'ip' => sanitize_text_field($_POST['ip']),
    ];

    $call_api = save_api($form_data);

    $res = $call_api ? [ 'status' => 1, 'message' => 'Se envió correctamente el formulario' ]
                    :[ 'status' => 0, 'message' => 'Hubo un error en el envío' ];

	wp_send_json($res);
}
add_action('wp_ajax_nopriv_dcms_ajax_frm_contact','dcms_process_contact_form');
add_action('wp_ajax_dcms_ajax_frm_contact','dcms_process_contact_form');

function dcms_validate_nonce( $nonce, $nonce_name ){
	if ( ! wp_verify_nonce( $nonce, $nonce_name ) ) {
		$res = [ 'status' => 0, 'message' => '✋ Error nonce validation!!' ];
		wp_send_json($res);
	}
}

function save_form($form_data, $response_body) {
    global $wpdb;

    // Insertar datos en la tabla personalizada
    $wpdb->insert(
        $wpdb->prefix . 'form_leads',
        [
            'name_cliente' => $form_data['name_cliente'],
            'nit' => $form_data['nit'],
            'name_punto' => $form_data['name_punto'],
            'name_equipo' => $form_data['name_equipo'],
            'city' => $form_data['city'],
            'promotor' => $form_data['promotor'],
            'rtc' => $form_data['rtc'],
            'capitan' => $form_data['capitan'],
            'acepta_terminos' => $form_data['acepta_terminos'],
            'ip' => $form_data['ip'],
            'response_api' => $response_body,
        ]
    );
}

// Insert data in API
function save_api($form_data) {
    $url = 'https://app-edu-recaudocursos-php.azurewebsites.net/api-cursos/public/crear-logs';

    $data = [
        'identificador' => current_time('Y-m-d'),
        'tipo' => 'Prueba Form Jhonatan',
        'info' => [
            'name_cliente' => $form_data['name_cliente'],
            'nit' => $form_data['nit'],
            'name_punto' => $form_data['name_punto'],
            'name_equipo' => $form_data['name_equipo'],
            'city' => $form_data['city'],
            'promotor' => $form_data['promotor'],
            'rtc' => $form_data['rtc'],
            'capitan' => $form_data['capitan'],
            'acepta_terminos' => $form_data['acepta_terminos'],
            'ip' => $form_data['ip'],
        ]
    ];

    $body = json_encode($data);

    $args = [
        'method'    => 'POST',
        'body'      => $body,
        'headers'   => [
            'Content-Type' => 'application/json',
        ],
    ];

    $response = wp_remote_request($url, $args);

    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        error_log("Error al enviar datos a la API: $error_message");
    } else {
        $response_body = wp_remote_retrieve_body($response);
        error_log("Respuesta de la API: $response_body");
    }
    // Guardar los datos en la base de datos
    save_form($form_data, $response_body);

    return $response_body;
}

function export_leads_excel() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'form_leads';

    $results = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

    if (empty($results)) {
        wp_die('No hay datos para exportar.');
    }
 
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="custom-table-export.xls"');
    header('Cache-Control: max-age=0');

    $output = fopen('php://output', 'w');

    fputcsv($output, array_keys($results[0]), "\t");

    foreach ($results as $row) {
        fputcsv($output, $row, "\t");
    }

    fclose($output);
    exit;
}
add_action('admin_post_export_leads', 'export_leads_excel');
add_action('admin_post_nopriv_export_leads', 'export_leads_excel');

function add_export_button() {
    echo '<a href="' . admin_url('admin-post.php?action=export_leads') . '" class="btn btn-primary">Exportar Leads</a>';
}
add_shortcode('export_button', 'add_export_button');
