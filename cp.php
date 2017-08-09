<? /**
 * @package Cykelpartner produktfremviser
 * @Author: Cykelpartner.dk - Dennis Drejer
 * @version 1.0.8
 */
/*
Plugin Name: Cykelpartner produktfremviser
Plugin URI: http://www.cykelpartner.dk/
Description: Get produkt from Cykelpartner.dk via affiliate network Partner Ads. A plugin for showing affiliate products. Go to the plugin options page to see usage.
Author: Cykelpartner.dk - Dennis Drejer
Version: 1.0.8
Author URI: http://www.cykelpartner.dk/

*/

if (!defined('WP_CONTENT_URL')) define('WP_CONTENT_URL', get_option('siteurl').'/wp-content');
if (!defined('WP_CONTENT_DIR')) define('WP_CONTENT_DIR', ABSPATH.'wp-content');
if (!defined('WP_PLUGIN_URL')) define('WP_PLUGIN_URL', WP_CONTENT_URL.'/plugins');
if (!defined('WP_PLUGIN_DIR')) define('WP_PLUGIN_DIR', WP_CONTENT_DIR.'/plugins');

//Install funcsion
function cp_install () {
	$td_db_version = '1.0';
	add_option('cp_db_version', $cp_db_version);
}

register_activation_hook(__FILE__, 'cp_install');
add_action('admin_menu', 'cp_plugin_menu');

function cp_plugin_menu() {
	add_options_page('Cykelpartner produktfremviser', 'Cykelpartner produktfremviser', 8, __FILE__, 'cp_plugin_options');
}

//Funcion para crear los elementos del menu
function cp_plugin_options() {
?>
<style type="text/css">
.form-table th {
	font-weight: bold;
}
</style>
<div class="wrap">
<h1>Cykelpartner produktfremviser</h1>
	<p>Support kan f&#229;s p&#229; <a href="mailto:webmaster@cykelpartner.dk">webmaster@cykelpartner.dk</a>.</p>
	<form method="post" action="options.php">
		<?php wp_nonce_field('update-options'); ?>
		<table width="100%" class="form-table">
			<tr valign="top">
				<th colspan="2" scope="row"><h3>Indstillinger</h3></th>
			</tr>
			
			<?
			/*
			<tr valign="top">
				<td width="40%" scope="row"><div align="left">Tradedoubler Affiliate ID</div></td>
				<td width="40%"><input type="text" name="cp_td" value="<?php echo get_option('cp_td'); ?>" /></td>
			</tr>
			*/
			?>
			<tr valign="top">
				<td width="40%" scope="row"><div align="left">Partner Ads Affiliate ID</div></td>
				<td width="40%"><input type="text" name="cp_pa" value="<?php echo get_option('cp_pa'); ?>" /></td>
			</tr>
			<tr valign="top">
				<td width="40%" scope="row"><div align="left">Produktfeed Cache (i sekunder, en dag = 86400, en uge = 604800) Standard er en uge.</div></td>
				<td width="40%"><input type="text" name="cp_cache_timeout" value="<?php echo get_option('cp_cache_timeout'); ?>" /></td>
		  </tr>
		</table>
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="page_options" value="cp_td,cp_pa,cp_cache_timeout" />
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>
	
	<table width="100%" class="form-table">
		<tr valign="top">
			<th scope="row"><h3>Brug</h3></th>
		</tr>
		<tr valign="top">
			<td scope="row">[CPxml <? /*network="NETV&#198;RK" */?>query="S&#216;GEORD1|S&#216;GEORD2"]</td>
		</tr>
		<tr valign="top">
			<td scope="row">[CPxml <? /*network="NETV&#198;RK" */?>query="S&#216;GEORD1|S&#216;GEORD2" sorting="FELT" exclude="UDELUK1|UDELUK2" template="FILNAVN" newlineafter="ANTAL_PRODUKTER_F&#216;R_LINJESKIFT" limit="ANTAL_PRODUKTER"]</td>
		</tr>
		<tr valign="top">
			<th scope="row"><h3>Standard v&#230;rdier</h3></th>
		</tr>
		<tr valign="top">
			<td>
				<table>
					<tr>
						<th>Felt</th>
						<th>Standardv&#230;rdi</th>
						<th>Muligheder</th>
						<th>Funtkion</th>
					</tr>
					<?
					/*
					<tr>
						<td>network</td>
						<td><i>n/a</i></td>
						<td>pa, td</td>
						<td>V&#230;lg om du vil bruge links fra Partner Ads eller Tradedoubler.</td>
					</tr>
					*/
					?>
					<tr>
						<td>query</td>
						<td><i>n/a</i></td>
						<td>Opdel ord med |</td>
						<td>Finder kun produkter som indeholder alle s&#248;geordene.</td>
					</tr>
					<tr>
						<td>sorting</td>
						<td>price</td>
						<td>productsid, productsname, productsdescription, productsprice, productsurl, productsimageurl, categoryname, brand, currency</td>
						<td>Hvilken v&#230;rdi du vil sortere produktlisten efter.</td>
					</tr>
					<tr>
						<td>exclude</td>
						<td><i>n/a</i></td>
						<td>Opdel ord med |</td>
						<td>Finder kun produkter, som ikke indeholder minimum 1 af ordene.</td>
					</tr>
					<tr>
						<td>template</td>
						<td>template.tpl</td>
						<td>Opret flere templates.</td>
						<td>Du kan her definerer hvilken template der skal bruges til at vise de valgte produkter.</td>
					</tr>
					<tr>
						<td>newlineafter</td>
						<td>2</td>
						<td>1-10</td>
						<td>V&#230;lg hvor mange produkter der skal vises f&#248;r der kommer et tvunget linjeskift.</td>
					</tr>
					<tr>
						<td>limit</td>
						<td>99999999</td>
						<td>1-&infin;</td>
						<td>V&#230;lg hvor mange produkter der skal vises.</td>
					</tr>
				</table>
			</td>			
		</tr>
	</table>

	<table width="100%" class="form-table">
		<tr valign="top">
			<th scope="row"><h3>Template muligheder</h3></th>
		</tr>
		<tr valign="top">
			<td>
				<p>Templatefilen finder du i pluginmappen. Den hedder <b>template.tpl</b>. Du kan kopirer denne fil og lave en template1.tpl, template2.tpl m.f. hvis du &#248;nsker at have flere muligheder for at fremvise produkter.</p>
				<table>
					<tr>
						<th>Feltnavn</th>
						<th>Beskrivelse</th>
					</tr>
					<tr>
						<td>[PRODUCTSID]</td>
						<td>Varenummeret</td>
					</tr>
					<tr>
						<td>[PRODUCTSNAME]</td>
						<td>Produktnavnet</td>
					</tr>
					<tr>
						<td>[PRODUCTSDESCRIPTION]</td>
						<td>Produktbeskrivelsen</td>
					</tr>
					<tr>
						<td>[PRODUCTSPRICE]</td>
						<td>Produktpris</td>
					</tr>
					<tr>
						<td>[PRODUCTSURL]</td>
						<td>Produkturl inkl. affiliate tracking.</td>
					</tr>
					<tr>
						<td>[PRODUCTSIMAGEURL]</td>
						<td>Produktbilledeurl</td>
					</tr>
					<tr>
						<td>[CATEGORYNAME]</td>
						<td>Kategorinavn</td>
					</tr>
					<tr>
						<td>[BRAND]</td>
						<td>M&#230;rke</td>
					</tr>
					<tr>
						<td>[CURRENCY]</td>
						<td>Valuta</td>
					</tr>
					
				</table>
			</td>			
		</tr>
	</table>
</div>

<?
}
require_once(dirname(__FILE__).'/function.php');
add_shortcode('CPxml', 'CPxmlProductsViewer');
?>