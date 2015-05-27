<?php

/**
 * Create a jQuery slider control.
 * TODO: Migrate to an HTML5 range control. Range control are hard to style 'cause they don't display the value
 */
class Kirki_Controls_Slider_Control extends WP_Customize_Control {

	public $type = 'slider';

	public function enqueue() {

		wp_enqueue_script( 'jquery-ui' );
		wp_enqueue_script( 'jquery-ui-slider' );

		$config   = Kirki_Toolkit::config()->get_all();
		$root_url = ( '' != $config['url_path'] ) ? esc_url_raw( $config['url_path'] ) : KIRKI_URL;

		wp_enqueue_script( 'kirki-color-alpha', trailingslashit( $root_url ) . 'assets/js/kirki-color-alpha.js', array( 'jquery' ) );
		wp_enqueue_style( 'kirki-slider', trailingslashit( $root_url ) . 'assets/css/slider.css' );

	}

	public function render_content() { ?>
		<label>

			<span class="customize-control-title">
				<?php echo esc_attr( $this->label ); ?>
				<?php if ( ! empty( $this->description ) ) : ?>
					<?php // The description has already been sanitized in the Fields class, no need to re-sanitize it. ?>
					<span class="description customize-control-description"><?php echo $this->description; ?></span>
				<?php endif; ?>
			</span>

			<input type="text" class="kirki-slider" id="input_<?php echo $this->id; ?>" disabled value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?>/>

		</label>

		<div id="slider_<?php echo $this->id; ?>" class="ss-slider"></div>
		<script>
		jQuery(document).ready(function($) {
			$( '[id="slider_<?php echo $this->id; ?>"]' ).slider({
					value : <?php echo esc_attr( $this->value() ); ?>,
					min   : <?php echo $this->choices['min']; ?>,
					max   : <?php echo $this->choices['max']; ?>,
					step  : <?php echo $this->choices['step']; ?>,
					slide : function( event, ui ) { $( '[id="input_<?php echo $this->id; ?>"]' ).val(ui.value).keyup(); }
			});
			$( '[id="input_<?php echo $this->id; ?>"]' ).val( $( '[id="slider_<?php echo $this->id; ?>"]' ).slider( "value" ) );
		});
		</script>
		<?php

	}
}
