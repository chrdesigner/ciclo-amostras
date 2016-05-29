		</div>  <!-- #main -->
		
		
		<footer id="footer-restrita" class="fusion-footer-copyright-area">
			<div class="fusion-row">
				<div class="fusion-copyright-content">

					<?php 
					/**
					 * avada_footer_copyright_content hook
					 *
					 * @hooked avada_render_footer_copyright_notice - 10 (outputs the HTML for the Theme Options footer copyright text)
					 * @hooked avada_render_footer_social_icons - 15 (outputs the HTML for the footer social icons)
					 */						
					do_action( 'avada_footer_copyright_content' ); 
					?>

				</div> <!-- fusion-fusion-copyright-area-content -->
			</div> <!-- fusion-row -->
		</footer> <!-- #footer -->

		<!-- W3TC-include-js-head -->

		<?php 
		wp_footer();

		// Echo the scripts added to the "before </body>" field in Theme Options
		echo $smof_data['space_body']; 
		?>

		<!--[if lte IE 8]>
			<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/respond.js"></script>
		<![endif]-->
	</body>
</html>