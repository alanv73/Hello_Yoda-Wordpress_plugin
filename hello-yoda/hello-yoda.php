<?php
/**
 * @package Hello_Yoda
 * @version 1.4.2
 */
/*
Plugin Name: Hello Yoda
Plugin URI: 
Description: These wise Yoda quotes will keep you on the Light Side of the Force and bring out the best in you. When activated you will randomly see a Yoda quote in the upper right of your admin screen on every page. Administrators are driven to to the dark side of the force and will see Darth Vader quotes.
Author: Alan Van Art
Version: 1.4.2
Author URI: 
*/

//Create a function called "hello_yoda_get_lyric" if it doesn't already exist
if ( !function_exists( 'hello_yoda_get_lyric' ) ) {
	function hello_yoda_get_lyric() {
		/** These are Yoda quotes */
		$yodaQuotes = "Meditate on this, I will.
Around the survivors, a perimeter create!
Much to learn, you still have.";
/*Destroy the Sith, we must.
Not if anything to say about it, I have!
Into exile I must go. Failed, I have.
If so powerful you are, why leave?
Help you I can! Yes! Mm!
Mine! Or I will help you not!
Mudhole? Slimy? My home this is!
You will be. You will be.
That is why you fail.
No! Try not. Do. Or do not. There is no try.
No. There is another.
Your father he is.
War does not make one great.
Yoda I am, fight I will.
Tired I am, rest I must.
A labyrinth of evil, this war has become.
My ally is the Force.
You must feel the Force around you.";*/

		// Here we split it into lines.
		$yodaQuotes = explode( "\n", $yodaQuotes );

		global $wpdb;
		$results = $wpdb->get_results("select quote from {$wpdb->prefix}quotes where LOWER(quotee) like '%yoda%'");

		// TODO check for empty results
		foreach($results as $row) {
			$quote = $row->quote; //$row->quote is a reference to db column
			array_push($yodaQuotes, $quote);
		}

		// And then randomly choose a line.
		return wptexturize( $yodaQuotes[ mt_rand( 0, count( $yodaQuotes ) - 1 ) ] );
	}
}

//Create a function called "hello_vader_get_lyric" if it doesn't already exist
if ( !function_exists( 'hello_vader_get_lyric' ) ) {
	function hello_vader_get_lyric() {
		/** These are Darth Vader quotes */
		$vaderQuotes = "I find your lack of faith disturbing
The Force is strong with this one
Obi-Wan has taught you well";
/*I am your father!
Give yourself to the Dark Side
I see through the lies of the Jedi
He will join us or die!
Give into your hate and anger
You have failed me for the last time
Only your hatred can destroy me
You were right about me
Now, release your anger
Only your hatred can destroy me
Your powers are weak, old man
Power! Unlimited power!
He will join us or die, Master
This will be a day long remembered
All too easy
Don’t fail me again, Admiral
He will not be permanently damaged";*/

		// Here we split it into lines.
		$vaderQuotes = explode( "\n", $vaderQuotes );

		global $wpdb;
		$results = $wpdb->get_results("select quote from {$wpdb->prefix}quotes where LOWER(quotee) like '%vader%'");

		// TODO check for empty results
		foreach($results as $row) {
			$quote = $row->quote; //$row->quote is a reference to db column
			array_push($vaderQuotes, $quote);
		}
		
		// And then randomly choose a line.
		return wptexturize( $vaderQuotes[ mt_rand( 0, count( $vaderQuotes ) - 1 ) ] );
	}
}

//Create a function called "hello_yoda" if it doesn't already exist
if ( !function_exists( 'hello_yoda' ) ) {
// This just echoes the chosen line, we'll position it later.
	function hello_yoda() {
		$chosen = hello_yoda_get_lyric();
		$lang   = '';
		if ( 'en_' !== substr( get_user_locale(), 0, 3 ) ) {
			$lang = ' lang="en"';
		}

		printf(
			'<p id="yoda"><span class="screen-reader-text">%s </span><span dir="ltr"%s>%s</span></p>',
			__( 'Master Yoda Quote:', 'hello-yoda' ),
			$lang,
			$chosen
		);
	}
}

//Create a function called "hello_vader" if it doesn't already exist
if ( !function_exists( 'hello_vader' ) ) {
// This just echoes the chosen line, we'll position it later.
	function hello_vader() {
		$chosen = esc_html( hello_vader_get_lyric() );
		$lang   = '';
		if ( 'en_' !== substr( get_user_locale(), 0, 3 ) ) {
			$lang = ' lang="en"';
		}

		printf(
			'<p id="vader"><span class="screen-reader-text">%s </span><span dir="ltr"%s>%s</span></p>',
			__( 'Darth Vader Quote:', 'hello-vader' ),
			$lang,
			$chosen
		);
	}
}

//Create a function called "yoda_css" if it doesn't already exist
if ( !function_exists( 'yoda_css' ) ) {
// We need some CSS to position the paragraph.
	function yoda_css() {
		echo "
		<style type='text/css'>
		#yoda {
			float: right;
			padding: 5px 10px;
			margin: 0;
			font-size: 12px;
			line-height: 1.6666;
			color: forestgreen;
		}

		#vader {
			float: right;
			padding: 5px 10px;
			margin: 0;
			font-size: 12px;
			line-height: 1.6666;
			color: red;
		}

		.rtl #yoda {
			float: left;
		}

		.block-editor-page #yoda {
			display: none;
		}

		@media screen and (max-width: 782px) {
			#yoda,
			.rtl #yoda {
				float: none;
				padding-left: 0;
				padding-right: 0;
			}
		}

		.newquote, #quote_form {
			margin-bottom: 10px;
		}

		#quote_title {
			padding-top: 0;
			margin-bottom: 20px;
			font-size: 3em;
			font-weight: lighter;
		}

		#quote_subtitle {
			font-weight: lighter;
			font-size: .6em;
		}

		.form-label, small {
			display: block;
		}

		.container {
			width: 60%;
			padding: 20px 60px;
			background: #f8f9fa;
			margin: 50px auto 0;
			border-radius: 15px;
		}

		#quote {
			width: 100%;
		}

		#quotee {
			width: 35%;
		}

		/*
		* Bootstrap style table
		*/
		.table {
			width: 100%;
			max-width: 100%;
			margin-bottom: 1rem;
		}

		.table th,
		.table td {
			padding: 0.75rem;
			padding-left: 1.88rem;
			vertical-align: top;
			border-top: 1px solid #eceeef;
		}

		.table #quotee {
			padding-left: 2.25rem;
		}

		.table thead th {
			vertical-align: bottom;
			border-bottom: 2px solid #eceeef;
		}
			
		.table tbody + tbody {
			border-top: 2px solid #eceeef;
		}
			
		.table .table {
			background-color: #fff;
		}
			
		.table-sm th,
		.table-sm td {
			padding: 0.3rem;
			padding-left: 0.75rem;
		}

		.table-sm #quotee {
			padding-left: 1.25rem;
		}
			
		.table-bordered {
			border: 1px solid #eceeef;
		}
			
		.table-bordered th,
		.table-bordered td {
			border: 1px solid #eceeef;
		}
			
		.table-bordered thead th,
		.table-bordered thead td {
			border-bottom-width: 2px;
		}
			
		.table-striped tbody tr:nth-of-type(odd) {
			background-color: rgba(0, 0, 0, 0.05);
		}
			
		.table-hover tbody tr:hover {
			background-color: rgba(0, 0, 0, 0.075);
		}
			
		.table-active,
		.table-active > th,
		.table-active > td {
			background-color: rgba(0, 0, 0, 0.075);
		}
			
		.table-hover .table-active:hover {
			background-color: rgba(0, 0, 0, 0.075);
		}
			
		.table-hover .table-active:hover > td,
		.table-hover .table-active:hover > th {
			background-color: rgba(0, 0, 0, 0.075);
		}
			
		.table-success,
		.table-success > th,
		.table-success > td {
			background-color: #dff0d8;
		}
			
		.table-hover .table-success:hover {
			background-color: #d0e9c6;
		}
			
		.table-hover .table-success:hover > td,
		.table-hover .table-success:hover > th {
			background-color: #d0e9c6;
		}
			
		.table-info,
		.table-info > th,
		.table-info > td {
			background-color: #d9edf7;
		}
			
		.table-hover .table-info:hover {
			background-color: #c4e3f3;
		}
			
		.table-hover .table-info:hover > td,
		.table-hover .table-info:hover > th {
			background-color: #c4e3f3;
		}
			
		.table-warning,
		.table-warning > th,
		.table-warning > td {
			background-color: #fcf8e3;
		}
			
		.table-hover .table-warning:hover {
			background-color: #faf2cc;
		}
			
		.table-hover .table-warning:hover > td,
		.table-hover .table-warning:hover > th {
			background-color: #faf2cc;
		}
			
		.table-danger,
		.table-danger > th,
		.table-danger > td {
			background-color: #f2dede;
		}
			
		.table-hover .table-danger:hover {
			background-color: #ebcccc;
		}
			
		.table-hover .table-danger:hover > td,
		.table-hover .table-danger:hover > th {
			background-color: #ebcccc;
		}
			
		.thead-inverse th {
			color: #fff;
			background-color: #292b2c;
		}
			
		.thead-default th {
			color: #464a4c;
			background-color: #eceeef;
		}
			
		.table-inverse {
			color: #fff;
			background-color: #292b2c;
		}
			
		.table-inverse th,
		.table-inverse td,
		.table-inverse thead th {
			border-color: #fff;
		}
			
		.table-inverse.table-bordered {
			border: 0;
		}
			
		.table-responsive {
			display: block;
			width: 100%;
			overflow-x: auto;
			-ms-overflow-style: -ms-autohiding-scrollbar;
		}
			
		.table-responsive.table-bordered {
			border: 0;
		}

		.table .submit {
			padding: 0 10px;
			margin: 0;
		}

		.table .delete-button {
			border: none;
			background: none;
			transition: all .2s cubic-bezier(0, 1.26, .8, 1.28);
		}

		.table .delete-button:hover {
			color: red;
			transform: scale(1.2, 1.2);
		}

		.table .delete-button:focus {
			outline: transparent;
		}

		.table .delete-button:active {
			color: gray;
			outline: transparent;
		}

		</style>
		";

		if( is_plugin_active( 'font-awesome/font-awesome.php' ) ) {
			echo "
			<style type='text/css'>

			/* Font Awesome Plugin Required for dash icon */
			#toplevel_page_hello_yoda .wp-menu-image.dashicons-before::before {
				font-family: 'Font Awesome 5 Brands';
				font-weight: 400;
				content: '\\f50e';
			}

			</style>
			";
		}
	}
}

if ( !function_exists( 'hello_yoda_load_for_user' ) ) {
	function hello_yoda_load_for_user(){
		// Now we set that function up to execute when the admin_notices action is called.
		if (current_user_can('activate_plugins')){
			add_action( 'admin_notices', 'hello_vader' );
			// add_action( 'admin_head', 'vader_css' );
		} else {
			add_action( 'admin_notices', 'hello_yoda' );
			// add_action( 'admin_head', 'yoda_css' );
		}
		add_action( 'admin_head', 'yoda_css' );
	}
	add_action( 'plugins_loaded', 'hello_yoda_load_for_user' );
}

if ( !function_exists( 'hello_yoda_options_page_html' ) ) {
	function hello_yoda_options_page_html() {
		?>
		<div class="wrap">
			<div class="container">
				<h1 id="quote_title"><i class="fab fa-jedi-order"></i> The Hello Yoda Plugin <span id="quote_subtitle">by Alan</span></h1>
				<p>&quotPass on what you have learned.&quot --Yoda</p>
			</div>
		</div>
		<?php
	}
}

// Font Awesome Plugin Required for dash icon
if ( !function_exists( 'hello_yoda_options_page' ) ) {
	add_action( 'admin_menu', 'hello_yoda_options_page' );
	function hello_yoda_options_page() {
		add_menu_page(
			'The Hello Yoda Plugin by Alan',
			'Hello Yoda',
			'read',
			'hello_yoda',
			'hello_yoda_options_page_html',
			'dashicons-admin-generic',
			20
		);
	}
}

if ( !function_exists( 'hello_yoda_add_quote_page_html' ) ) {
	function hello_yoda_add_quote_page_html() {
		// check user capabilities
		if (!current_user_can('read')) {
			return;
		}
		?>
		<div class="wrap">
			<div class="container" id="quote-container">
				<h1 id="quote_title"><i class="fab fa-jedi-order"></i> Add Quote</h1>
				<p>Add your favorite Yoda or Darth Vader quote to the pool of quotes. One will
				be chosen at random to be displayed in the upper-right of the admin screen.</p>
				<form id="quote_form" action="" method="post">
					<div class="form-group newquote">
						<label class="form-label" for="quote">New Quote</label>
						<textarea type="text" name="quote" id="quote" class="form-control" rows="4" REQUIRED></textarea>
					</div>
					<div class="form-group newquote">
						<label class="form-label" for="quotee">Originator</label>
						<!-- <input type="text" name="quotee" id="quotee" class="form-control" aria-describedby="quoteeHelp" REQUIRED> -->
						<select name="quotee" id="quotee" class="form-control" REQUIRED>
							<option value="">-- Select One --</option>
							<option value="Yoda">Yoda</option>
							<option value="Darth Vader">Darth Vader</option>
						</select>
						<small id="quoteeHelp" class="form-text text-muted">The person who said the new quote.</small>
					</div>
					<?php submit_button('Save Settings'); ?>
				</form>
			</div>
		</div>
		<?php
	}
}

if ( !function_exists( 'hello_yoda_add_quote_page' ) ) {
	function hello_yoda_add_quote_page() {
		$hookname = add_submenu_page(
			'hello_yoda',
			'Add Quote',
			'Add Quote',
			'read',
			'add_quote',
			'hello_yoda_add_quote_page_html'
		);
		remove_submenu_page('hello_yoda', 'hello_yoda');
		add_action( 'load-' . $hookname, 'hello_yoda_add_quote_submit');
	}
add_action('admin_menu', 'hello_yoda_add_quote_page');
}

if ( !function_exists( 'hello_yoda_remove_quote_page' ) ) {
	function hello_yoda_remove_quote_page() {
		$hookname = add_submenu_page(
			'hello_yoda',
			'Remove Quote',
			'Remove Quote',
			'read',
			'remove_quote',
			'hello_yoda_remove_quote_page_html'
		);
		add_action( 'load-' . $hookname, 'hello_yoda_remove_quote_submit');
	}
add_action('admin_menu', 'hello_yoda_remove_quote_page');
}

if ( !function_exists( 'hello_yoda_activation' ) ) {
	function hello_yoda_activation() {

		Global $wpdb;

		$table_name = $wpdb->prefix . 'quotes';

		$sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
			id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
			quote TEXT NOT NULL, 
			quotee VARCHAR(255) NOT NULL
			)";

		$wpdb->query( $sql );

		// testing purposes
		// $sql = "INSERT INTO {$wpdb->prefix}quotes ( quote, quotee ) values 
		// 	('Meditate on this, I will.', 'Yoda'),
		// 	('Now, release your anger!', 'Darth Vader')";

		// $wpdb->query( $sql );
		
	}
	register_activation_hook( __FILE__, 'hello_yoda_activation' );
}

if ( !function_exists( 'hello_yoda_add_quote_submit' ) ) {
	function hello_yoda_add_quote_submit() {
		If ( 'POST' === $_SERVER['REQUEST_METHOD'] ) {
			Global $wpdb;
			// sanitize & use prepared statement
			$quote = sanitize_text_field( $_POST['quote'] );
			$quotee = sanitize_text_field( $_POST['quotee'] );

			if (!empty($quote) && !empty($quotee)){
				if (($quotee == "Yoda") || ($quotee == "Darth Vader")){
					$wpdb->query(
						$wpdb->prepare(
							"insert into {$wpdb->prefix}quotes
							( quote, quotee ) values ( %s, %s )",
							$quote, $quotee
						)
					);

					if($wpdb->last_error === '') :
						do_action( 'dbsuccess_notice', 'New quote successfully added.' );
					endif;

				} else {
					do_action( 'dbfailure_notice', 'Invalid Quotee. Record not saved.' );
				}
			}
			
		}
	}
}

if ( !function_exists( 'hello_yoda_remove_quote_submit' ) ) {
	function hello_yoda_remove_quote_submit() {
		If ( 'POST' === $_SERVER['REQUEST_METHOD'] ) {
			Global $wpdb;
			
			$id = sanitize_text_field( $_POST['id'] );

			if (!empty($id)) {
				$wpdb->delete(
					"{$wpdb->prefix}quotes",
					array( 'id' => $id )
				);
			}

			if($wpdb->last_error === '') :
    			do_action( 'dbsuccess_notice', 'Selected quote successfully removed.' );
			endif;
		}
	}
}

if ( !function_exists( 'hello_yoda_uninstall' ) ) {
	register_uninstall_hook(__FILE__, 'hello_yoda_uninstall');
	function hello_yoda_uninstall() {
		Global $wpdb;

		$table_name = $wpdb->prefix . 'quotes';

		$wpdb->query( 
			"DROP TABLE IF EXISTS {$table_name}"
		 );
	}
}

if ( !function_exists( 'console_log' ) ) {
	function console_log($output, $with_script_tags = true) {
		$js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
		if ($with_script_tags) {
			$js_code = '<script>' . $js_code . '</script>';
		}
		echo $js_code;
	}
}

if ( !function_exists( 'hello_yoda_admin_notice__warning' ) ) {
	function hello_yoda_admin_notice__warning() {
		if( !is_plugin_active( 'font-awesome/font-awesome.php' ) ) {
			$user_id = get_current_user_id();
    		if ( !get_user_meta( $user_id, 'hello_yoda_fa_dismissed' ) ) {  ?>
				<div class="notice notice-warning is-dismissible">
					<p><?php _e('The Font Awesome plugin is recommended for use with the Hello Yoda plugin.', 'textdomain') ?></p>
					<!-- <a href="?hello-yoda-fa-dismissed">Dismiss</a> -->
				</div>
			<?php }
		}
	}
	add_action( 'admin_notices', 'hello_yoda_admin_notice__warning' );
}

function hello_yoda_notice_dismissed() {
    $user_id = get_current_user_id();
    if ( isset( $_GET['hello-yoda-fa-dismissed'] ) )
        add_user_meta( $user_id, 'hello_yoda_fa_dismissed', 'true', true );
}
add_action( 'admin_init', 'hello_yoda_notice_dismissed' );

add_action( 'dbsuccess_notice', 'hello_yoda_admin_notice__dbsuccess' );
function hello_yoda_admin_notice__dbsuccess($message) {
	?>
		<div class="notice notice-success is-dismissible">
			<p><?php _e("$message", 'hello_yoda') ?></p>
		</div>
	<?php
}

add_action( 'dbfailure_notice', 'hello_yoda_admin_notice__dbfailure' );
function hello_yoda_admin_notice__dbfailure($message) {
	?>
		<div class="notice notice-warning is-dismissible">
			<p><?php _e("$message", 'hello_yoda') ?></p>
		</div>
	<?php
}

if ( !function_exists( 'hello_yoda_remove_quote_page_html' ) ) {
	function hello_yoda_remove_quote_page_html() {
		// check user capabilities
		if (!current_user_can('read')) {
			return;
		}

		global $wpdb;

		if (current_user_can('activate_plugins')){
			// Vader
			$results = $wpdb->get_results("select * from {$wpdb->prefix}quotes where LOWER(quotee) like '%vader%'");
		} else {
			// Yoda
			$results = $wpdb->get_results("select * from {$wpdb->prefix}quotes where LOWER(quotee) like '%yoda%'");
		}

		?>
		<div class="wrap">
			<div class="container" id="quote-container">
				<h1 id="quote_title"><i class="fab fa-galactic-republic"></i> Remove Quote</h1>
				<p>Select a quote to be removed from the database.</p>
				<table class="table">
					<thead>
						<tr>
						<th scope="col">Delete</th>
						<th scope="col">Quote</th>
						<th scope="col">Quotee</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($results as $row) { ?>
						<tr>
							<th scope="row">
								<form name="form-delete" action="" method="post">
									<button name="id" class="delete-button" value="<?php echo $row->id; ?>"><span class="dashicons dashicons-dismiss"></span></button>
								</form>
							</th>
							<td><?php echo $row->quote; ?></td>
							<td id="quotee"><?php echo $row->quotee; ?></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
		<?php
	}
}