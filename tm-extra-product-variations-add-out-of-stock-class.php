<?php 
/**
* TM Extra Product Options
* Adds a class to out of stock variations 
* functions.php
*/

add_action( 'woocommerce_before_single_product_summary', function() {
  global $product;
  
  if($product->get_type() === 'variable'){
    foreach( $product->get_available_variations() as $variation ) {
      $product_variation = new WC_Product_Variation($variation['variation_id']);
?>
      <script>
        jQuery(document).ready(function($) {

          <?php 
          if($product_variation->get_stock_quantity() === 0){
            $prodimg = str_replace('.jpg', '', $variation['image']['url']);
          ?>

          var tmpString = '<?php echo $prodimg; ?>';
          var tmpAlt = '<?php echo $product_variation->name; ?>';

          
          $('ul.tm-extra-product-options-variations li img').each(function(){
            // check if img src or img alt are the same
            if($(this).attr('data-original').indexOf(tmpString) !== -1 || tmpAlt.indexOf($(this).attr('alt')) !== -1){
              // if so add class (custom-stock-0) to the parent (label)  
              $(this).parent().addClass('custom-stock-<?php echo $product_variation->get_stock_quantity(); ?>');
            }
          });

          <?php } ?>
        });
      </script>
<?php
       }
     }
});
