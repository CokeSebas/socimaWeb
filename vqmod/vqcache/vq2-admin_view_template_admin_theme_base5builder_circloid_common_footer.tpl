
	<?php

		if ($logged) { // Only displays when a user is logged in
	?>
				<div class="footer-text">Implementado Odril</div>
			</div> <!-- End of right-column -->
		</div> <!-- End of main-body -->
	<?php } ?>
</div> <!-- End of fluid-container -->

<?php


if(isset($this->request->get['route'])){
	$current_location = explode("/", $this->request->get['route']);
	if($current_location[0] == "common"){
		$is_homepage = TRUE;
	}else{
		$is_homepage = FALSE;
	}
}else{
	$is_homepage = FALSE;
}

if(isset($this->request->get['route'])){
	if($this->request->get['route'] == "common/login"){
		$is_custom_page = FALSE;
	}
}
if(!isset($this->request->get['route'])){
	$is_custom_page = FALSE;
}

?>
	<!-- Le javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script type="text/javascript" src="view/javascript/admin_theme/base5builder_circloid/bootstrap/bootstrap-min.js"></script>
	<script type="text/javascript" src="view/javascript/admin_theme/base5builder_circloid/circloid-menu-functions.js"></script>
	<script type="text/javascript" src="view/javascript/admin_theme/base5builder_circloid/misc/bootstrap-datepicker.js"></script>
	
	<?php if($this->user->getUserName()){ ?>
		<script type="text/javascript" src="view/javascript/admin_theme/base5builder_circloid/misc/scriptbreaker-multiple-accordion-1.0-min.js"></script>

		<?php if($is_homepage){ ?>
			<script type="text/javascript" src="view/javascript/admin_theme/base5builder_circloid/color_picker/spectrum-min.js"></script>
		<?php } ?>
		<?php
		if(!$is_custom_page){
			?>
			<script type="text/javascript" src="view/javascript/admin_theme/base5builder_circloid/script.js"></script>
			<?php
		}else{ 
			if($logged){
				?>
				<script type="text/javascript" src="view/javascript/admin_theme/base5builder_circloid/script-custom-page.js"></script>
				<?php
			}else{
				?>
				<script type="text/javascript" src="view/javascript/admin_theme/base5builder_circloid/script.js"></script>
				<?php
			}
		}
		?>

		<?php if($is_homepage){ ?>
			<script type="text/javascript" src="view/javascript/admin_theme/base5builder_circloid/misc/serialize.js"></script>
			<script type="text/javascript" src="view/javascript/admin_theme/base5builder_circloid/script-dashboard-widgets.js"></script>
			<script type="text/javascript" src="view/javascript/admin_theme/base5builder_circloid/script-dashboard-editor.js"></script>
			<script type="text/javascript" src="view/javascript/admin_theme/base5builder_circloid/color_picker/spectrum.js"></script>
		<?php } ?>
	<?php }
		if(!$logged){
		?>
		<script type="text/javascript" src="view/javascript/admin_theme/base5builder_circloid/script-logged-out.js"></script>
		<?php
	} ?>
	<script type="text/javascript" src="view/javascript/admin_theme/base5builder_circloid/misc/retina-1.1.0.min.js"></script>

        
 <?php if ($this->request->get): ?>
<?php if ($this->request->get['route'] === 'catalog/product/update' || $this->request->get['route'] === 'catalog/product/insert'): ?>

<!-- TODO: Compress JS -->

<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="view/javascript/jquery-file-upload/js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="view/javascript/jquery-file-upload/js/vendor/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="view/javascript/jquery-file-upload/js/vendor/load-image.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="view/javascript/jquery-file-upload/js/vendor/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS and Bootstrap Image Gallery are not required, but included for the demo -->
<script src="view/javascript/jquery-file-upload/js/vendor/bootstrap.min.js"></script>
<script src="view/javascript/jquery-file-upload/js/vendor/bootstrap-image-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="view/javascript/jquery-file-upload/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="view/javascript/jquery-file-upload/js/jquery.fileupload.js"></script>
<!-- The File Upload file processing plugin -->
<script src="view/javascript/jquery-file-upload/js/jquery.fileupload-fp.js"></script>
<!-- The File Upload user interface plugin -->
<script src="view/javascript/jquery-file-upload/js/jquery.fileupload-ui.js"></script>
<!-- The Jquery Punch Plugin -->
<script src="view/javascript/jquery-ui-punch/jquery.ui.touch-punch.min.js"></script>
<!-- The main application script -->
<script src="view/javascript/jquery-file-upload/js/main.js"></script>

        <script>
                    $(document).ready(function(){

                        /**
                         * Fill in the Product titles for each language + model.
                         *
                         */
                        function fillInProductTitleAndModel() {
                            var placeHolder = 'product-' + new Date().getTime();

                            // For different translations we genereate here 10 possible product titles
                            for (var i = 1; i<=10; i++) {
                                $('input[name="product_description[' + i +'][name]"]').val(placeHolder);
                            }
                            

                            // Model
                            $('input[name="model"]').val(placeHolder);

                        }

                        /**
                        * Sets product status by checking the select option in the product form
                        * status int 1|0
                        */
                        function setProductStatus(status) {
                            $('select[name="status"]').val(status);
                        }

                        /**
                         * Autosubmit the Product Insert form, so we would be redirected to
                         * product update, where we can add images and do other interesiting stuff,
                         * since by that time we would have the product ID.
                         */
                        function autosubmitProductInsertForm() {
                            $('#form').submit();
                        }

                        /**
                         * Transliterator RU -> EN
                         */
                        var ru2en = {
                              ru_str : "АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюя",
                              en_str : ['A','B','V','G','D','E','JO','ZH','Z','I','J','K','L','M','N','O','P','R','S','T',
                                'U','F','H','C','CH','SH','SHH',String.fromCharCode(35),'I',String.fromCharCode(39),'JE','JU',
                                'JA','a','b','v','g','d','e','jo','zh','z','i','j','k','l','m','n','o','p','r','s','t','u','f',
                                'h','c','ch','sh','shh',String.fromCharCode(35),'i',String.fromCharCode(39),'je','ju','ja'],
                              translit : function(org_str) {
                                var tmp_str = "";
                                for(var i = 0, l = org_str.length; i < l; i++) {
                                  var s = org_str.charAt(i), n = this.ru_str.indexOf(s);
                                  if(n >= 0) { tmp_str += this.en_str[n]; }
                                  else { tmp_str += s; }
                                }
                                return tmp_str;
                              },
                              tr : function(org_str) {
                                var tmp_str = [];
                                for(var i = 0, l = org_str.length; i < l; i++) {
                                  var s = org_str.charAt(i), n = this.ru_str.indexOf(s);
                                  if(n >= 0) { tmp_str[tmp_str.length] = this.en_str[n]; }
                                  else { tmp_str[tmp_str.length] = s; }
                                }
                                return tmp_str.join("");
                              },
                              t : function (inp){
                                return inp.replace(/(.)/g,function(a) { return ru2en.ru2en[a] });
                              },
                              t1 : function (inp) {
                                var a = inp.split("");
                                for (var i=0,aL=a.length;i<aL;i++) {a[i] = ru2en.ru2en[a[i]]}
                                return a.join("");
                              },
                              ttt : function (inp){
                                var reg;
                                for (var a in ru2en.ru2en) {
                                  reg = new RegExp(a, "g");
                                  inp = inp.replace(reg, ru2en.ru2en[a]);
                                }
                                return inp;
                              }
                        }

                        /**
                         * Takes the russian product name and trnasliterates it into english product name.
                         * On the fly.
                         *
                         */
                        function translateRussianTitleToEnglish() {
                            $('input[name="product_description[2][name]"]').on('input', function(){
                                var russianInput = $(this).val();
                                $('input[name="product_description[1][name]"]').val(ru2en.translit(russianInput));
                            });
                        }

                        /**
                         * After the redirect the product name is filled with the pregenerated value.
                         * That must be emptied - so we've got the form validation again.
                         * 
                         */
                        function emptyPregeneratedProductName() {
                             // Empty product pregenerated Name - for all the languages
                            for (i=0;i<=10;i++) {
                                var text = $('input[name="product_description[' + i  + '][name]"]').val();
                                var pregeneratedPattern = /product-\d+/;
                                var match = pregeneratedPattern.exec(text);
                                if (match != null) {                                    
                                    $('input[name="product_description[' + i + '][name]"]').val('');
                                } 
                                
                                // And focus on the product name field
                                $('input[name="product_description[1][name]"]').focus();
                            }
                        }

                         /**
                         * After the redirect the model name is filled with the pregenerated value.
                         * That must be emptied - so we've got the form validation again.
                         * 
                         */
                        function emptyPregeneratedProductModel() {

                            // Empty product pregenerated Model
                            var text = $('input[name="model"]').val();
                            var pregeneratedPattern = /product-\d+/;
                            var match = pregeneratedPattern.exec(text);
                            if (match != null) {
                                $('input[name="model"]').val('');
                            } 
                        }

                        /**
                         * Load scripts for needed page
                         */
                        function loadScriptsForNeededPage() {

                            // Product Insert Page
                            if (document.URL.indexOf('catalog/product/insert') !== -1) {
                                fillInProductTitleAndModel();
                                setProductStatus(0);  
                                autosubmitProductInsertForm();
                            }

                            // Product Update Page
                            if (document.URL.indexOf('catalog/product/update') !== -1) {
                                translateRussianTitleToEnglish();
                                emptyPregeneratedProductName();
                                emptyPregeneratedProductModel();
                                setProductStatus(1);
                            }

                        }
                        // TODO: closure here
                        loadScriptsForNeededPage();
                    });
        </script>
		
		<?php endif; ?>
        <?php endif; ?>
        
      
</body></html>
