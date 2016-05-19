<?php
	class acf_field_hidden extends acf_field {
		
		// vars
		var $settings, // will hold info such as dir / path
			$defaults; // will hold default field options

		function __construct() {
			// vars
			$this->name = 'hidden';
			$this->label = __('Hidden');
			$this->category = __("Basic",'acf'); // Basic, Content, Choice, etc
			$this->defaults = array(
			);
			
			parent::__construct();
	    	
	    	$this->settings = array(
				'path' => apply_filters('acf/helpers/get_path', __FILE__),
				'dir' => apply_filters('acf/helpers/get_dir', __FILE__),
				'version' => '1.0.0'
			);
		}
		
		function create_options( $field ){
		
			$key = $field['name'];
			
		}
		
		function create_field( $field ){ ?>
			<style type="text/css">.field_key-<?php echo $field['key']; ?>{display:none;}</style>
			<input type="hidden" name="<?php echo esc_attr($field['name']) ?>" id="input_key-<?php echo $field['key']; ?>" value="<?php echo esc_attr($field['value']) ?>" /><?php
		}
		
		function input_admin_enqueue_scripts(){
			
			wp_register_script( 'acf-input-hidden', $this->settings['dir'] . 'js/input.js', array('acf-input'), $this->settings['version'] );
			wp_register_style( 'acf-input-hidden', $this->settings['dir'] . 'css/input.css', array('acf-input'), $this->settings['version'] ); 
			
			wp_enqueue_script(array(
				'acf-input-hidden',	
			));
			
			wp_enqueue_style(array(
				'acf-input-hidden',	
			));

		}
		
		function load_value( $value, $post_id, $field ){
			// Note: This function can be removed if not used
			return $value;
		}
		
		
		function update_value( $value, $post_id, $field ){
			// Note: This function can be removed if not used
			return $value;
		}
		
		
		function format_value( $value, $post_id, $field ){
			// Note: This function can be removed if not used
			return $value;
		}
		
		function format_value_for_api( $value, $post_id, $field ){
			// Note: This function can be removed if not used
			return $value;
		}
		
		function load_field( $field ){
			// Note: This function can be removed if not used
			return $field;
		}
		
		function update_field( $field, $post_id ){
			// Note: This function can be removed if not used
			return $field;
		}
		
	}
	// create field
	new acf_field_hidden();
?>