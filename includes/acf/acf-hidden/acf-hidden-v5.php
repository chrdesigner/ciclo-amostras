<?php
class acf_field_hidden extends acf_field {
	
	function __construct() {
		
		$this->name = 'hidden';
		
		$this->label = __('Hidden', 'acf-hidden');
		
		$this->category = 'basic';
		
		$this->defaults = array(
			'font_size'	=> 14,
		);
		
		$this->l10n = array(
			'error'	=> __('Error! Please enter a higher value', 'acf-hidden'),
		);

		// do not delete!
    	parent::__construct();
    	
	}
	
	function render_field_settings( $field ) {

	}
	
	function render_field( $field ) {
		?>
		<style type="text/css">.field_key-<?php echo $field['key']; ?>{display:none;}</style>
		<input type="hidden" name="<?php echo esc_attr($field['name']) ?>" value="<?php echo esc_attr($field['value']) ?>" />
		<?php
	}
	
	function input_admin_enqueue_scripts() {

		$dir = plugin_dir_url( __FILE__ );
		
		// register & include JS
		wp_register_script( 'acf-input-hidden', "{$dir}js/input.js" );
		wp_enqueue_script('acf-input-hidden');
		
		// register & include CSS
		wp_register_style( 'acf-input-hidden', "{$dir}css/input.css" ); 
		wp_enqueue_style('acf-input-hidden');
		
		
	}

}

new acf_field_hidden();
?>