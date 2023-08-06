<?php
/**
 * Class Sub Menu
 *
 * @author Alexander Geilhaupt <alex@htmlkombinat.com> http://www.htmlkombinat.com
 */
 
class hk_sub_menu extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'hk_sub_menu', // Base ID
			__( 'Submenu for pages', 'htmlkombinat' ), // Name
			array( 'description' => __( 'A sub menu for your page sidebar to display child pages.', 'htmlkombinat' ) ) // Args
		);
	}	
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		global $post;
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		$parent = $post->ID;
		if($post->post_parent){
			$ancestors = get_post_ancestors( $post->ID );
			$root = ( count( $ancestors ) -1 );
			$parent = $ancestors[ $root ];
		}
		
		$parent_permalink = get_permalink($parent);
		$parent_title = get_the_title($parent);
		
		$arguments = array(
			'child_of' => $parent,
			'sort_column ' => 'menu_order',
			'title_li' => ''
		);
		
		$find_children = get_pages( $arguments );
		if( count( $find_children ) == 0 ) {
			return;
		}
		
		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
		
		echo '<ul class="hk-submenu-pages">';
		echo '<li><a href="'.$parent_permalink.'">'.$parent_title.'</a>';
		echo '<ul class="children">';
		wp_list_pages($arguments);
		echo '</ul></ul>';
		
		echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'htmlkombinat' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'default' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}

}

add_action( 'widgets_init', create_function( '', 'register_widget( "hk_sub_menu" );' ) );

?>