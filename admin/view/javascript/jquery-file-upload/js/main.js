/*
 * jQuery File Upload Plugin JS Example 7.0
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/*jslint nomen: true, unparam: true, regexp: true */
/*global $, window, document */

$(function () {
    'use strict';

    // Get the product id form the URL 
    var product_id = getParameterByName('product_id');

    // Initialize the jQuery File Upload widget:
    $('#form').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        
        // Use product_id to store the photos in the directory with that name
       // url: 'image/data/uploader'
       url: 'view/javascript/jquery-file-upload/server/php/?product_id=' + product_id
    });

    // Enable iframe cross-domain access via redirect option:
    $('#form').fileupload(
        'option', {
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
        },
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    if (window.location.hostname === 'blueimp.github.com') {
        // Demo settings:
        $('#form').fileupload('option', {
            url: '//jquery-file-upload.appspot.com/',
            maxFileSize: 5000000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            process: [
                {
                    action: 'load',
                    fileTypes: /^image\/(gif|jpeg|png)$/,
                    maxFileSize: 20000000 // 20MB
                },
                {
                    action: 'resize',
                    maxWidth: 1440,
                    maxHeight: 900
                },
                {
                    action: 'save'
                }
            ]
        });
        // Upload server status check for browsers with CORS support:
        if ($.support.cors) {
            $.ajax({
                url: '//jquery-file-upload.appspot.com/',
                type: 'HEAD'
            }).fail(function () {
                $('<span class="alert alert-error"/>')
                    .text('Upload server currently unavailable - ' +
                            new Date())
                    .appendTo('#form');
            });
        }
    } else {
        // Load existing files:
        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: $('#form').fileupload('option', 'url'),
            dataType: 'json',
            context: $('#form')[0]
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, null, {result: result});
        });
    }

    // Indentifing if we are adding to or creating a new list of images
    var fileListIndex = $('input[name^=product_image]').filter('[type=hidden]').filter('[id^=image]').size();
    var sortOrder = parseInt(fileListIndex, 10)+1;
    // Immitating the native uploader of OpenCart
    // Add the hidden form field(s) after the upload is done
    $('#form').bind('fileuploadcompleted', function (e, data) {
        // Adding the hidden fieled with the image name, so the image can be processed by the openCart (model/product - addProduct editProduct methods)
        //$('#form').append('<input type="hidden" name="product_image[' + fileListIndex + '][image]" value="data/product-' + product_id + '/' + data.files[0].name +'" id="image' + fileListIndex + '">');
        // Adding the hidden field with the image sort order
        //$('#form').append('<input type="hidden" name="product_image[' + fileListIndex + '][sort_order]" value="' + sortOrder + '">');
        fileListIndex++;
        sortOrder++;
        setOrderOfProductPhotos();
    });
    $('#form').bind('fileuploaddestroy', function (e, data) {

        var row_index = $(data.context[0]).index();

        console.log($('#image-row' + row_index));

        var file = data.context[0].children[1].innerText;
        var delete_url = data.url + '&product_id=' + product_id;

        $.ajax({
            url: delete_url,
            type: data.type,
            success: function() {
                $(data.context).remove();
                $('#image-row' + row_index).remove();
                setOrderOfProductPhotos();
            }
        });
        // data.context: download row,
        // data.url: deletion url,
        // data.type: deletion request type, e.g. "DELETE",
        // data.dataType: deletion response type, e.g. "json"
    });

    //coockie name
     var LI_POSITION = 'li_position';
       $('tbody.files').sortable({
             start: function(event, ui) {
                var start_pos = ui.item.index();
                ui.item.data('start_pos', start_pos);
            },
            update: function(event, ui) {
                var start_pos = ui.item.data('start_pos');
                var end_pos = $(ui.item).index();

                start_pos = parseInt(start_pos, 10) + 1;
                end_pos = parseInt(end_pos, 10) + 1;
                
                setOrderOfProductPhotos();
            }
        });

    /**
     * Set the order of the photos
     */
    function setOrderOfProductPhotos() {

        $('tbody.files tr').each(function(){

            var sort_order = $(this).index();
            var file_name = $(this).find('.name')[0].textContent; 
            // Trim the leading whitespaces
            file_name = file_name.replace(/^\s+/g, '');
            // And now trim the following whitespaces
            file_name = file_name.replace(/\s+$/g, '');

             $.ajax({
                url: 'view/javascript/jquery-file-upload/server/php/order.php',
                type: 'POST',
                data: {'sort_order': sort_order, 'file_name': file_name, 'product_id': product_id},
                success: function(data) {
                }
            });
        });

        
    }

});

function getParameterByName(name)
{
  name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
  var regexS = "[\\?&]" + name + "=([^&#]*)";
  var regex = new RegExp(regexS);
  var results = regex.exec(window.location.search);
  if(results == null)
    return "";
  else
    return decodeURIComponent(results[1].replace(/\+/g, " "));
}
