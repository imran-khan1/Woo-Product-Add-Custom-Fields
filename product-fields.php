<?php
// Display Fields Admin Side
add_action( 'woocommerce_product_options_general_product_data', 'ik_custom_general_fields' );

// Save Fields
add_action( 'woocommerce_process_product_meta', 'ik_custom_general_fields_save' );


function ik_custom_general_fields() {

  global $woocommerce, $post;
  
  echo '<div class="options_group">';
  
  // Custom fields will be created here...
  // Text Field
woocommerce_wp_text_input( 
	array( 
		'id'          => '_text_field', 
		'label'       => __( 'My Text Field', 'woocommerce' ), 
		'placeholder' => 'http://',
		'desc_tip'    => 'true',
		'description' => __( 'Enter the custom value here.', 'woocommerce' ) 
	)
);

// Number Field
woocommerce_wp_text_input( 
	array( 
		'id'                => '_number_field', 
		'label'             => __( 'My Number Field', 'woocommerce' ), 
		'placeholder'       => '', 
		'description'       => __( 'Enter the custom value here.', 'woocommerce' ),
		'type'              => 'number', 
		'custom_attributes' => array(
				'step' 	=> 'any',
				'min'	=> '0'
			) 
	)
);


// Textarea
woocommerce_wp_textarea_input( 
	array( 
		'id'          => '_textarea', 
		'label'       => __( 'My Textarea', 'woocommerce' ), 
		'placeholder' => '', 
		'description' => __( 'Enter the custom value here.', 'woocommerce' ) 
	)
);


// Select
woocommerce_wp_select( 
array( 
	'id'      => '_select', 
	'label'   => __( 'My Select Field', 'woocommerce' ), 
	'options' => array(
		'one'   => __( 'Option 1', 'woocommerce' ),
		'two'   => __( 'Option 2', 'woocommerce' ),
		'three' => __( 'Option 3', 'woocommerce' )
		)
	)
);


// Checkbox
woocommerce_wp_checkbox( 
array( 
	'id'            => '_checkbox', 
	'wrapper_class' => 'show_if_simple', 
	'label'         => __('My Checkbox Field', 'woocommerce' ), 
	'description'   => __( 'Check me!', 'woocommerce' ) 
	)
);



// Hidden field
woocommerce_wp_hidden_input(
array( 
	'id'    => '_hidden_field', 
	'value' => 'hidden_value'
	)
);



// Custom field Type
?>
<p class="form-field custom_field_type">
	<label for="custom_field_type"><?php echo __( 'Custom Field Type', 'woocommerce' ); ?></label>
	<span class="wrap">
		<?php $custom_field_type = get_post_meta( $post->ID, '_custom_field_type', true ); ?>	
		<input placeholder="<?php _e( 'Field One', 'woocommerce' ); ?>" class="" type="number" name="_field_one" value="<?php echo $custom_field_type[0]; ?>" step="any" min="0" style="width: 80px;" />
		<input placeholder="<?php _e( 'Field Two', 'woocommerce' ); ?>" type="number" name="_field_two" value="<?php echo $custom_field_type[1]; ?>" step="any" min="0" style="width: 80px;" />
	</span>
	<span class="description"><?php _e( 'Place your own description here!', 'woocommerce' ); ?></span>
</p>


<!-- product select -->

<p class="form-field product_field_type">
<label for="product_field_type"><?php _e( 'Product Select', 'woocommerce' ); ?></label>
<select id="product_field_type" name="product_field_type[]" class="wc-enhanced-select" multiple="multiple" data-placeholder="<?php _e( 'Search for a product&hellip;', 'woocommerce' ); ?>">
	<?php
	
 $query = new WC_Product_Query( array(
    'limit' => 7,
    'orderby' => 'date',
    'order' => 'DESC',
    'return' => 'ids',
) );
$product_ids = $query->get_products();  

       
		if ( $product_ids ) {
		  
          $i=0;
			foreach ( $product_ids as $product_id ) {
				
                $product      = get_product( $product_id );
				$product_name = woocommerce_get_formatted_product_name( $product );
                
                
                $product_field_type_ids = get_post_meta( $post->ID, '_product_field_type_ids', true );
                $prod_ids = ! empty( $product_field_type_ids ) ? array_map( 'absint',  $product_field_type_ids ) : null;
                
                
                if($product_id == $prod_ids[$i])
                {
                   echo '<option value="' . esc_attr( $product_id ) . '" selected="selected">' . esc_html( $product_name ) . '</option>';
                         
                       
                }
                else
                {
                    echo '<option value="' . esc_attr( $product_id ) . ' ">' . esc_html( $product_name ) . '</option>';
                }
                
                $i++;
                    
                
			}
            
            
		}
	?>
</select> <img class="help_tip" data-tip='<?php _e( 'Your description here', 'woocommerce' ) ?>' src="<?php echo $woocommerce->plugin_url(); ?>/assets/images/help.png" height="16" width="16" />
</p>
<?php


  
  echo '</div>';
	
}





//Saving Fields Values
function ik_custom_general_fields_save( $post_id ){
	
	// Text Field
	$woocommerce_text_field = $_POST['_text_field'];
	if( !empty( $woocommerce_text_field ) )
		update_post_meta( $post_id, '_text_field', esc_attr( $woocommerce_text_field ) );
		
	// Number Field
	$woocommerce_number_field = $_POST['_number_field'];
	if( !empty( $woocommerce_number_field ) )
		update_post_meta( $post_id, '_number_field', esc_attr( $woocommerce_number_field ) );
		
	// Textarea
	$woocommerce_textarea = $_POST['_textarea'];
	if( !empty( $woocommerce_textarea ) )
		update_post_meta( $post_id, '_textarea', esc_html( $woocommerce_textarea ) );
		
	// Select
	$woocommerce_select = $_POST['_select'];
	if( !empty( $woocommerce_select ) )
		update_post_meta( $post_id, '_select', esc_attr( $woocommerce_select ) );
		
	// Checkbox
	$woocommerce_checkbox = isset( $_POST['_checkbox'] ) ? 'yes' : 'no';
	update_post_meta( $post_id, '_checkbox', $woocommerce_checkbox );
	
	// Custom Field
	$custom_field_type =  array( esc_attr( $_POST['_field_one'] ), esc_attr( $_POST['_field_two'] ) );
	update_post_meta( $post_id, '_custom_field_type', $custom_field_type );
	
	// Hidden Field
	$woocommerce_hidden_field = $_POST['_hidden_field'];
	if( !empty( $woocommerce_hidden_field ) )
		update_post_meta( $post_id, '_hidden_field', esc_attr( $woocommerce_hidden_field ) );
		
	// Product Field Type
	$product_field_type =  $_POST['product_field_type'];
	update_post_meta( $post_id, '_product_field_type_ids', $product_field_type );
	
}



//Front end product detail page
add_action( 'woocommerce_single_product_summary', 'ik_woo_product_detail', 5 );
function ik_woo_product_detail() {
    global $product;
	
		
		echo '<div>';
	    echo '<span> Text Field: ' . get_post_meta( $product->id, '_text_field', true ) . '</span>';
		echo '</div>';
        
        echo '<div>';
	    echo '<span> Number Field: ' . get_post_meta( $product->id, '_number_field', true ) . '</span>';
		echo '</div>';
        
        
        echo '<div>';
	    echo '<span> Text Area: ' . get_post_meta( $product->id, '_textarea', true ) . '</span>';
		echo '</div>';
        
         echo '<div>';
	    echo '<span> Select Field: ' . get_post_meta( $product->id, '_select', true ) . '</span>';
		echo '</div>';
        
         echo '<div>';
	    echo '<span> Checkbox Field: ' . get_post_meta( $product->id, '_checkbox', true ) . '</span>';
		echo '</div>';
        
        echo '<div><span> Custom Field: </span>';
	    print_r(get_post_meta( $product->id, '_custom_field_type', true ));
		echo '</div>';
        
        
        echo '<div><span> Product Field: </span>';
	    print_r(get_post_meta( $product->id, '_product_field_type_ids', true ));
		echo '</div>';
        
        
	}






?>