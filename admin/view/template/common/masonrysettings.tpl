<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
    
  <?php if ($success) { ?>
  <!--<div class="success"><?php echo $success; ?></div>-->
  <div class="success"><a target="_blank" href="http://socimagestion.com/Movil/Sistema.php"><?php echo "Recuerde actualizar los datos para el sistema Movil"; ?></div>
  <?php } ?>
    
  <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
    
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
    <div id="masonry_search_page" class="box masonry_setting_box">
      <div class="heading">
	<h1><img src="view/image/masonry_settings/search.png" alt="" /> <?php echo $text_search_page; ?></h1>
      </div>
      <div class="content">
	  <div class="masonry_setting_list">
	      <table class="form nomargin">
		  <tr>
		    <td><?php echo $text_theme; ?></td>
		    <td>
			<input type="checkbox" value="1" id="selectSearchTheme" class="selectTheme" name="masonry_search_theme" checked="" />
		    </td>
		  </tr>
	      </table>
	      <div class="show_masonry_options">
		<table class="form">
		    <tr>
		      <td><?php echo $text_sort_option; ?></td>
		      <td>
			  <input type="checkbox" value="1" id="masonry_search_sort_option" class="selectSort" name="masonry_search_sort_option" checked="" />
		      </td>
		    </tr>
		    
		    <tr>
		      <td><?php echo $text_limit_option; ?></td>
		      <td>
			  <input type="checkbox" value="1" id="masonry_search_limit_option" class="selectLimit" name="masonry_search_limit_option" checked="" />
		      </td>
		    </tr>
		    
		    <tr>
		      <td><?php echo $text_image_size; ?></td>
		      <td class="imageSize">
			  <input type="text" size="3" class="selectSizeWidth" name="masonry_search_size_width" placeholder="125" value="<?php echo $masonry_search_size_width; ?>" />
			  <!--X
			  <input type="text" size="3" class="selectSizeHeight" name="masonry_search_size_height" placeholder="125" value="<?php echo $masonry_search_size_height; ?>" />-->
			  <?php if (isset($masonry_search_image_size_error)) { ?>
			    <span class="error"><?php echo $masonry_search_image_size_error; ?></span>
			  <?php } ?>
		      </td>
		    </tr>
		    
		    <tr>
		      <td><?php echo $text_price_option; ?></td>
		      <td>
			  <input type="checkbox" value="1" id="masonry_search_price_option" class="selectPrice" name="masonry_search_price_option" checked="" />
		      </td>
		    </tr>
		    
		    <tr>
		      <td><?php echo $text_add_wishlist; ?></td>
		      <td>
			  <input type="checkbox" value="1" id="masonry_search_add_wishlist" class="selectWishlist" name="masonry_search_add_wishlist" checked="" />
		      </td>
		    </tr>
		    
		    <tr>
		      <td><?php echo $text_add_compare; ?></td>
		      <td>
			  <input type="checkbox" value="1" id="masonry_search_add_compare" class="selectCompare" name="masonry_search_add_compare" checked="" />
		      </td>
		    </tr>
		</table>
	      </div>
	  </div>
      </div>
    </div>

    <div id="masonry_category_page" class="box masonry_setting_box">
      <div class="heading">
	<h1><img src="view/image/masonry_settings/category.png" alt="" /> <?php echo $text_category_page; ?></h1>
      </div>
      <div class="content">
	  <div class="masonry_setting_list">
	      <table class="form nomargin">
		  <tr>
		    <td><?php echo $text_theme; ?></td>
		    <td>
			<input type="checkbox" value="1" id="selectCategoryTheme" class="selectTheme" name="masonry_category_theme" checked="" />
		    </td>
		  <tr>
	      </table>
	      <div class="show_masonry_options">
		<table class="form">
		    <tr>
		      <td><?php echo $text_sort_option; ?></td>
		      <td>
			  <input type="checkbox" value="1" id="masonry_category_sort_option" class="selectSort" name="masonry_category_sort_option" checked="" />
		      </td>
		    </tr>
		    
		    <tr>
		      <td><?php echo $text_limit_option; ?></td>
		      <td>
			  <input type="checkbox" value="1" id="masonry_category_limit_option" class="selectLimit" name="masonry_category_limit_option" checked="" />
		      </td>
		    </tr>
		    
		    <tr>
		      <td><?php echo $text_image_size; ?></td>
		      <td class="imageSize">
			  <input type="text" size="3" id="masonry_category_size_width" class="selectSizeWidth" name="masonry_category_size_width" placeholder="125" value="<?php echo $masonry_category_size_width; ?>" />
			  <!--X
			  <input type="text" size="3" id="masonry_category_size_height" class="selectSizeHeight" name="masonry_category_size_height" placeholder="125" value="<?php echo $masonry_category_size_height; ?>" />-->
			  <?php if (isset($masonry_category_image_size_error)) { ?>
			    <span class="error"><?php echo $masonry_category_image_size_error; ?></span>
			  <?php } ?>
		      </td>
		    </tr>
		    
		    <tr>
		      <td><?php echo $text_price_option; ?></td>
		      <td>
			  <input type="checkbox" value="1" id="masonry_category_price_option" class="selectPrice" name="masonry_category_price_option" checked="" />
		      </td>
		    </tr>
		    
		    <tr>
		      <td><?php echo $text_add_wishlist; ?></td>
		      <td>
			  <input type="checkbox" value="1" id="masonry_category_add_wishlist" class="selectWishlist" name="masonry_category_add_wishlist" checked="" />
		      </td>
		    </tr>
		    
		    <tr>
		      <td><?php echo $text_add_compare; ?></td>
		      <td>
			  <input type="checkbox" value="1" id="masonry_category_add_compare" class="selectCompare" name="masonry_category_add_compare" checked="" />
		      </td>
		    </tr>
		</table>
	      </div>
	  </div>
      </div>
    </div>
      
    <div id="formAction">
	
	<button type="submit" id="masonry_submit_button"><?php echo $button_masonry_settings; ?></button>
	
    </div>
      
  </form>
    
</div>

<script type="text/javascript"><!--
var switchButtonOptions = {width: 80, height: 25,button_width: 40,labels_placement: "right"};
var switchButtonYesNoLabels = {on_label: 'Yes', off_label: 'No'};

var selectSearchTheme = <?php echo $masonry_search_theme; ?>;
var selectSearchSortOption = <?php echo $masonry_search_sort_option; ?>;
var selectSearchLimitOption = <?php echo $masonry_search_limit_option; ?>;
var selectSearchPriceOption = <?php echo $masonry_search_price_option; ?>;
var selectSearchWishlistOption = <?php echo $masonry_search_add_wishlist; ?>;
var selectSearchCompareOption = <?php echo $masonry_search_add_compare; ?>;

var checkedSearchTheme = checkedSearchSortOption = checkedSearchLimitOption = checkedSearchPriceOption = checkedSearchWishlistOption = checkedSearchCompareOption = false;

if(selectSearchTheme == 1) checkedSearchTheme = true;
if(selectSearchSortOption == 1) checkedSearchSortOption = true;
if(selectSearchLimitOption == 1) checkedSearchLimitOption = true;
if(selectSearchPriceOption == 1) checkedSearchPriceOption = true;
if(selectSearchWishlistOption == 1) checkedSearchWishlistOption = true;
if(selectSearchCompareOption == 1) checkedSearchCompareOption = true;

$("#selectSearchTheme").switchButton({
    on_label: 'Masonry',
    off_label: 'Default',
    checked: checkedSearchTheme,
    on_callback: function(){
	$("#selectSearchTheme").parents('.masonry_setting_list').find('.show_masonry_options').show();
    }
},switchButtonOptions).change(function(){
    $(this).parents('.masonry_setting_list').find('.show_masonry_options').toggle();
});

$("#masonry_search_sort_option").switchButton({checked: checkedSearchSortOption},switchButtonYesNoLabels,switchButtonOptions);
$("#masonry_search_limit_option").switchButton({checked: checkedSearchLimitOption},switchButtonYesNoLabels,switchButtonOptions);
$("#masonry_search_price_option").switchButton({checked: checkedSearchPriceOption},switchButtonYesNoLabels,switchButtonOptions);
$("#masonry_search_add_wishlist").switchButton({checked: checkedSearchWishlistOption},switchButtonYesNoLabels,switchButtonOptions);
$("#masonry_search_add_compare").switchButton({checked: checkedSearchCompareOption},switchButtonYesNoLabels,switchButtonOptions);

var selectCategoryTheme = <?php echo $masonry_category_theme; ?>;
var selectCategorySortOption = <?php echo $masonry_category_sort_option; ?>;
var selectCategoryLimitOption = <?php echo $masonry_category_limit_option; ?>;
var selectCategoryPriceOption = <?php echo $masonry_category_price_option; ?>;
var selectCategoryWishlistOption = <?php echo $masonry_category_add_wishlist; ?>;
var selectCategoryCompareOption = <?php echo $masonry_category_add_compare; ?>;

var checkedCategoryTheme = checkedCategorySortOption = checkedCategoryLimitOption = checkedCategoryPriceOption = checkedCategoryWishlistOption = checkedCategoryCompareOption = false;

if(selectCategoryTheme == 1) checkedCategoryTheme = true;
if(selectCategorySortOption == 1) checkedCategorySortOption = true;
if(selectCategoryLimitOption == 1) checkedCategoryLimitOption = true;
if(selectCategoryPriceOption == 1) checkedCategoryPriceOption = true;
if(selectCategoryWishlistOption == 1) checkedCategoryWishlistOption = true;
if(selectCategoryCompareOption == 1) checkedCategoryCompareOption = true;

$("#selectCategoryTheme").switchButton({
    on_label: 'Masonry',
    off_label: 'Default',
    checked: checkedCategoryTheme,
    on_callback: function(){
	$("#selectCategoryTheme").parents('.masonry_setting_list').find('.show_masonry_options').show();
    }
},switchButtonOptions).change(function(){
    $(this).parents('.masonry_setting_list').find('.show_masonry_options').toggle();
});

$("#masonry_category_sort_option").switchButton({checked: checkedCategorySortOption},switchButtonYesNoLabels,switchButtonOptions);
$("#masonry_category_limit_option").switchButton({checked: checkedCategoryLimitOption},switchButtonYesNoLabels,switchButtonOptions);
$("#masonry_category_price_option").switchButton({checked: checkedCategoryPriceOption},switchButtonYesNoLabels,switchButtonOptions);
$("#masonry_category_add_wishlist").switchButton({checked: checkedCategoryWishlistOption},switchButtonYesNoLabels,switchButtonOptions);
$("#masonry_category_add_compare").switchButton({checked: checkedCategoryCompareOption},switchButtonYesNoLabels,switchButtonOptions);

//--></script>

<?php echo $footer; ?>