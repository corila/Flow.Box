jQuery(function($) {
	jQuery("#book-detail-form").validate({
		rules: {
			qty: {
				required: true,
				digits: true,
				range: [1, 100]
			}
		}
	});

	jQuery("#book-detail-form").submit(function(e){
		e.preventDefault();
	});
	jQuery('.add-to-cart').click(function(){
		var bookQty = 1 ;
		var addBook = jQuery(this).children('.book-id').val();
		var qty = jQuery('#qty');
		if (qty.length >= 1) {
			if (jQuery("#book-detail-form").valid()) {
				bookQty = qty.val();
			} else {
				return false;
			}
		}
		jQuery.ajax({
			type: 'GET',
			url: 'km/ajaxAddBookToCart',
			data: {
				book: addBook,
				quantity: bookQty
			},
		}).done(function(data){
			var shoppingCart = jQuery('#shopping_cart');
			var shoppingContent = shoppingCart.children();
			var checkOutBtn = jQuery('#cart-info .checkout');
			var countBooks = jQuery('#shopping_cart .num-in-cart .num');
			jQuery('.no-books-text').hide();
			countBooks.text(data);
			shoppingCart.append(shoppingContent);
			checkOutBtn.removeClass('hidden');
		});

		setTimeout(function() {
			jQuery('#alert_message').fadeIn('slow');
		}, 500);
		setTimeout(function() {
			jQuery('#alert_message').fadeOut('slow');
		}, 4000);
		jQuery(".show-cart .glyphicon-shopping-cart" ).animate({
				"left": "+=5px" },
			"800",
			function() {
				$( ".show-cart .glyphicon-shopping-cart" ).animate({
						"left": "-=7px" },
					"1000",
					function() {
						$( ".show-cart .glyphicon-shopping-cart" ).animate({
								"left": "+=2px"},
							"slow");
					});
			});
	});

	// Delete book from Cart
	delete_book();
	function delete_book(){
		jQuery('.icon-delete').click(function() {
			// remove from session
			jQuery.ajax({
				type: 'GET',
				url: 'km/ajaxRemoveBookFromList',
				data: {
					book: jQuery(this).siblings('.book-id').val()
				}
			}).done(function(){
				window.location.reload();
			});
		});
	};

	calTotal();
	jQuery(".quantity").change(function () {
		jQuery.ajax({
			type: 'GET',
			url: 'km/ajaxChangeBookInList',
			data: {
				book: jQuery(this).siblings('.book-id').val(),
				quantity: jQuery(this).val()
			}
		}).done(function(){
			window.location.reload();
		});
	});
	function calTotal(){
		var allTotal = 0;
		jQuery('#list_book tbody tr').each(function(){
			var eachVal = parseFloat(jQuery(this).children('.total-price').children('.num').text());
			allTotal = allTotal + eachVal;
		});
		jQuery('#all_total span').text(allTotal.toFixed(2));
	}

	// Scroll to Top
	jQuery('#go_to_top').click (function() {
		jQuery('html, body').animate({
			scrollTop: jQuery("body").offset().top
		}, 600);
	});
	jQuery('#shopping_cart').click(function() {
		var cartBox = jQuery('#shopping_cart #in_cart');
		if(jQuery(cartBox).hasClass('inShow')) {
			jQuery( "#list_book_in_cart").show('slow');

			jQuery(cartBox).removeClass('inShow');
			jQuery(cartBox).addClass('inHide');
		}else {
			jQuery( "#list_book_in_cart").hide('slow');

			jQuery(cartBox).removeClass('inHide');
			jQuery(cartBox).addClass('inShow');
		}
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


	// Disable scroll to top when window scroll
	jQuery(window).scroll(function(){
		var scroll = jQuery(window).scrollTop();
		var mainNavContainer = jQuery('.main-nav-container');
		var mainNav = jQuery('#main_menu');
		if (window.innerWidth >= 768) {
			if (scroll > 106) {
				mainNavContainer.show();
				mainNavContainer.height(mainNav.height())
				mainNav.addClass('sticky-navbar');
			} else {
				mainNav.removeClass('sticky-navbar');
				mainNavContainer.hide();
			}
		}

		if(scroll > 300){
			jQuery('#go_to_top').show('slow');

		}else {
			jQuery('#go_to_top').hide('slow');
		}
	});

	// Validate field of searching form
	jQuery('.search-form button[type="submit"]').click(function(){
		jQuery(".search-form").submit(function() {
			var author = jQuery( "#author" ).val();
			var category = jQuery( "#category" ).val();
			var publisher = jQuery( "#publisher" ).val();
			var title = jQuery( "#inputTitle" ).val();
			if(author === null && category === null && publisher === null && title === "" ){
				jQuery('.form-group .error').remove();
				jQuery('<p class="error">' + lang.search_validation + '</p>').insertBefore('.search-form button[type="submit"]');
				return false;
			}
		});
	});

	jQuery("#author").select2({
		tags: true,
		maximumSelectionLength: 1,
		placeholder: jQuery('#authorPlaceHolder').val()
	});
	jQuery("#category").select2({
		tags: true,
		maximumSelectionLength: 1,
		placeholder: jQuery('#categoryPlaceHolder').val()
	});
	jQuery("#publisher").select2({
		tags: true,
		maximumSelectionLength: 1,
		placeholder: jQuery('#publisherPlaceHolder').val()
	});
	jQuery("#contactForm").validate({});
	jQuery("#checkout").validate({
		rules : {
			customerPhone1 : {
				minlength : 9,
				maxlength : 10
			},
			customerPhone2 : {
				minlength : 9,
				maxlength : 10
			}
		},
		submitHandler: function (form) {
			$.ajax({
				type: 'POST',
				data: $('form').serialize(),
				url: 'km/ajaxGoogleRecaptcha',
				success: function (respone) {
					var result = jQuery.parseJSON(respone);
					var obj = jQuery.parseJSON(result);
					if (obj.success === true) {
						form.submit();
					} else {
						jQuery('#captcha-error').text(lang.captcha_validation);
					}
				}
			});
			return false;
		}
	});
}); // jQuery End