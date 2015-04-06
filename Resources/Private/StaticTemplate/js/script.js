/* 
	author: istockphp.com
*/
jQuery(function($) {
    var i =0;
    jQuery('#list_book_in_cart').append('<p>There is no book in cart.</p>');
    
    jQuery('.add-to-cart').click(function(){
        if(i<1){
            var htmlElement = '<table id="list_book" class="table table-hover">\n\
                            <thead>\n\
                                <tr>\n\
                                    <th>Image</th>\n\
                                    <th>Book Name</th>\n\
                                    <th>Quantity</th>\n\
                                </tr>\n\
                        </thead><tbody>';
        }
        i++;
        jQuery('.num-in-cart .num').text(i);
        jQuery('#list_book_in_cart').children('p').remove();
        
        setTimeout(function() {
            jQuery('#alert_message').fadeIn('slow');
        }, 500);
        setTimeout(function() {
            jQuery('#alert_message').fadeOut('slow');
        }, 4000);

        // List books into cart
        var thisId = jQuery(this).attr('id');
        var thisBookTitle = jQuery(this).parent().parent().children('.title').text();
        var thisBookImg = jQuery(this).parent().parent().parent().children().children().children('img').attr('src');
        var hasChild = true;
            if(jQuery('#list_book_in_cart').children('.book-lists').children().children().children().hasClass('item-book')){
                jQuery('#list_book_in_cart .item-book').each(function(){
                   if(jQuery(this).attr('data-bind') === thisId){
                       var quantity = parseInt(jQuery(this).children('.quantity').children('span').text());
                       quantity++;
                       hasChild = false;
                       jQuery(this).children('.quantity').children('span').text(quantity);
                   }
                });
                if(hasChild === true){
                    htmlElement += '<tr class="item-book" data-bind="'+thisId+'">\n\
                                        <td><img src="'+thisBookImg+'"/></td>\n\
                                        <td><a href="#">'+thisBookTitle+'</a></td>\n\
                                        <td class="quantity"><span>1</span></td>\n\
                                   </tr>';
                    jQuery('#list_book_in_cart table tbody').append(htmlElement);
                }
            }else {
                htmlElement += '<tr class="item-book" data-bind="'+thisId+'">\n\
                                        <td><img src="'+thisBookImg+'"/></td>\n\
                                        <td><a href="#">'+thisBookTitle+'</a></td>\n\
                                        <td class="quantity"><span>1</span></td>\n\
                                   </tr>';
            }
       if(i<=1){
           htmlElement += '</tbody></table>';
           jQuery('#list_book_in_cart .book-lists').append(htmlElement);
           
       }
       jQuery('#shopping_cart .checkout').css('display', 'block');
       delet_book();
    });
    
    // Delete book from Cart
    delet_book();
    function delet_book(){
        jQuery('.icon-delete').click(function() {
           	var thisId = jQuery(this).attr('data-bind');
		jQuery('#list_book tbody tr').each(function(){
		    var parentId = jQuery(this).attr('data-bind');
		    if(thisId == parentId) {
			jQuery(this).remove();
		    }
		});
		calTotal();
        });
    };
    
    calTotal();
    jQuery(".quantity").change(function () {
        allTotal = 0;
        var quantity = parseInt(this.value);
        var unitPrice = parseInt(jQuery(this).parent().siblings('.unit-price').children('.num').text());
        jQuery(this).parent().siblings('.total-price').children('.num').text(unitPrice*quantity);
        calTotal();
    });
    function calTotal(){
        var allTotal = 0;
        jQuery('#list_book tbody tr').each(function(){
                var eachVal = parseInt(jQuery(this).children('.total-price').children('.num').text());
                allTotal = allTotal+eachVal;
            });
        jQuery('#all_total span').text(allTotal);
    }
    
    // Scroll to Top
    jQuery('#go_to_top').click (function() {
        jQuery('html, body').animate({
            scrollTop: $("body").offset().top
        }, 600);
    });
    jQuery('#shopping_cart .show-cart').click(function() {
        jQuery( "#list_book_in_cart" ).toggle( "slide" );
    });
    jQuery( '.navbar-nav > li' ).hover( function (){
        jQuery( this ).animate({
            'border-bottom': "3px solid"
        }, 'fast' );
    }, function (){
        jQuery( this ).animate({
            borderBottomWidth: "0px"
        }, 'fast' );
    });
    
    
    // Disable scrol to top when window scroll
    jQuery(window).scroll(function(){
        var scroll = $(window).scrollTop();
        if(scroll > 300){
            jQuery('#go_to_top').show('slow');
            
        }else {
            jQuery('#go_to_top').hide('slow');
        }
    });
}); // jQuery End
