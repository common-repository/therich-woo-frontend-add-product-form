<?php
	/*
	Plugin Name: TheRich Woo Frontend Add Product Form
	Plugin URI: 
	Description: With the help of this plugin, user can upload the woocommerce products from frontend.
	Version: 2.0.0
	Author: Therichpost
	Author URI: https://therichpost.com/author/therichpost
	*/
	
	define( 'Theich_Woo_Products', '2.0.0' );
	define( 'Theich_Woo_Products_PLUGIN_DIR' , plugin_dir_path( __FILE__ ));
	require_once( Theich_Woo_Products_PLUGIN_DIR . 'functions.php' );
		
	
	function therich_woo_scripts_load() {
		///////////////////////////////////////
		/** Add styles and scripts **/
		wp_register_script('rich_bootstrap_js', plugins_url('dist/bootstrap.min.js', __FILE__), '', filemtime( plugin_dir_path( __FILE__ ) . 'dist/bootstrap.min.js' ));
		
		wp_register_style( 'rich_bootstrap_css', plugins_url('dist/bootstrap.min.css', __FILE__), '', filemtime( plugin_dir_path( __FILE__ ) . 'dist/bootstrap.min.css' ));
		wp_enqueue_style('rich_bootstrap_css');
		wp_enqueue_script('jquery'); //wp code jquery
		wp_enqueue_script('rich_bootstrap_js');
		
	}
	add_action( 'wp_enqueue_scripts', 'therich_woo_scripts_load' );
  ///////////////////////////////////////
			
		//Frontend Add Product Form //
		function therichaddproductform(){ 
		$html = '<div class="container formdiv">
				<div class="alert alert-success alert-dismissible" style="display:none;">
				  <strong>Success!</strong>Product added successfully. Admin will contact you soon.
				</div>
				  <h3 class="display-4 text-center">Add Product</h3>
				  <blockquote class="blockquote text-center">
				  <footer class="blockquote-footer">You can add your product from below form.</footer>
				  </blockquote>
					<form id="addproductform" method="post" action="" enctype="multipart/form-data">
					  <div class="form-group">
						<label for="formGroupExampleInput">Product Title</label>
						<input type="text" name="product-title" class="form-control" id="formGroupProductTitle" placeholder="Product Title">
					  </div>
					  <div class="form-group">
						<label for="formGroupExampleInput">SKU</label>
						<input type="text" name="product-sku" class="form-control" id="formGroupProductSKU" placeholder="Product Title"><small id="emailHelp" class="form-text text-muted">Stock keep unit.</small>
					  </div>
					  <div class="input-group mb-3">
						<div class="input-group-prepend">
						  <span class="input-group-text">Regular Price in $</span>
						</div>
						<input type="number" name="product-price" class="form-control" aria-label="Amount (to the nearest dollar)" id="formGroupProductPrice">
					  </div>
					  <div class="form-group">
						<label for="formGroupProductEmail">Email address</label>
						<input type="text" name="product-email" class="form-control" id="formGroupProductEmail" aria-describedby="emailHelp" placeholder="therichpostsgmail.com">
						<small id="emailHelp" class="form-text text-muted">Admin will contact you after approval of your product.</small>
					  </div>
					   <div class="form-group">
							<div class="form-check">
							<input name="product-aft" class="form-check-input" type="checkbox" id="gridCheck1">
							<label class="form-check-label" for="gridCheck1">
							Is External/Affiliate product?
							</label>
							</div>
					  </div>
					  <div class="externalP" style="display: none;">
					  <div class="input-group mb-3">
						<div class="input-group-prepend">
						  <span class="input-group-text" id="basic-addon3">External/Affiliate URL</span>
						</div>
						<input type="text" name="product-aft-url" class="form-control" id="basic-url" aria-describedby="basic-addon3">
					  </div>
					</div>
					  <div class="form-group">
						<label for="formGroupProductDesc">Product Desciption</label>
						<textarea class="form-control" name="product-desc" id="formGroupProductDesc" rows="6" placeholder="Product Short Desciption"></textarea>
					  </div>
					  <div class="input-group mb-3">
						<div class="input-group-prepend">
						  <span class="input-group-text">Upload Product Picture (jpg/png)</span>
						</div>
						<div class="custom-file">
						  <input type="file" name="product-image" class="custom-file-input" id="inputGroupFile01">
						  <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
						</div>
					  </div>
					  <img id="blah" src="#" class="rounded mx-auto" style="width:200px; height:200px; display:none!important;"/>
					  <button type="button" class="btn btn-primary" id="addproduct">Submit</button>
					</form>
				  </div>';
				  
				  $html .='<script type="text/javascript">
							jQuery(document).ready(function() {
							  jQuery("#gridCheck1").click(function(event) {
							  /* Act on the event */
							  if(jQuery(this).is(":checked")) {
								jQuery(".externalP").show();
							  }else {
								jQuery(".externalP").hide();
							  }
							});
							
							//show upload image
							function readURL(input) {
								if (input.files && input.files[0]) {
								var reader = new FileReader();

								reader.onload = function(e) {
								jQuery("#blah").attr("src", e.target.result);
								jQuery("#blah").css("display", "block").show();
								}

								reader.readAsDataURL(input.files[0]);
								}
								}

								jQuery("#inputGroupFile01").change(function() {
									var val = jQuery(this).val();
									switch(val.substring(val.lastIndexOf(".") + 1).toLowerCase()){
										case "jpeg": case "jpg": case "png":
										    readURL(this);
											break;
										default:
											jQuery(this).val("");
											// error message here
											alert("Only JPEG and PNG file types are allowed");
											break;
									}
								});
								
							});
						  </script>';
				  
				  return $html;
		}
		add_shortcode( 'ProductForm', 'therichaddproductform' );
		/** Happy Coding **/
		
		// Display Fields Wordpress Dashboard Product Page
		add_action('woocommerce_product_options_general_product_data', 'therich_product_custom_fields');

		function therich_product_custom_fields()
		{
			global $woocommerce, $post;
			echo '<div class="therich_product_custom_fields">';
			// Custom Product Text Field
			woocommerce_wp_text_input(
				array(
					'id' => '_product_added_user_email',
					'placeholder' => 'Product Added User Email',
					'label' => __('Product Added User Email', 'woocommerce'),
					'desc_tip' => 'true'
				)
			);
			echo '</div>';
		}