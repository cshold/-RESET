window.redskins = window.redskins || {};

(function (_) {
	
	if (_.App) return;
	
	/***************************************************************************
	App Class
	***************************************************************************/
	
	_.App = new function () {
		return {
			options: null,
			html: $('html'),
			bod: $('body'),
			init: function ($options) {
				// store the options defined in index.php
				this.options = new _.Options($options || {});
				
				this.iframeCheck();
				
				// setup tracking
				if (this.html.hasClass('mobile')) _gaq.push(['_trackPageview', 'Mobile Pageload']);
				this.tracking();
				
				// validate UPC
				this.validateUPC();
				
				// validate entry form
				$('#form-submit').on('click', $.proxy(this.submitForm, this));
			},
			validateUPC: function () {
				var o = this;
				
				// This function should run some validation on the UPC code.
				// If successful, prompt the user to authorize with o.authorize();
				
				// for now, let's pretend this button is validates the UPC
				$('a.validate-upc').on('click', function(e){
					e.preventDefault();
					o.authorize();
				});
			},
			authorize: function () {
				var redirect = this.options.tabUrl;
				
				FB.login(function(response) {
					if (response.authResponse) {
						// user is logged in, reload page
						top.location.href = redirect;
					} else {
						// user is not logged in
					}
				}, {scope:'email'});
			},
			iframeCheck: function () {
				if (window.location == window.parent.location) {
					this.html.css('overflow', 'auto').addClass('window');
					$('body').css('overflow', 'auto');
				}
			},
			submitForm: function (e) {
				var o = this;
				reqAll = $('input.required');
				reqInputs = $('input[type="text"].required');
				reqCheckbox = $('input[type="checkbox"].required');
				postalCode = $('input[name="pcode"]');
				phoneNumber = $('input[name="phone"]');
				email = $('input[name="email"]');
				emailConf = $('input[name="email-conf"]');
				errors = 0;
				
				// validate text and select fields
				reqInputs.each(function(){
					var input = $(this);
					var container = input.parent();
					
					if ( !input.val() || input.val() == 'Select your province') {
						container.addClass('error');
						errors++;
					}
				});
				
				reqCheckbox.each(function(){
					var input = $(this);
					var container = input.parent();
					
					if ( !input.is(':checked') ) {
						container.addClass('error');
						errors++;
					}
				});
				
				// validate postal code
				if ( !postalCode.val().match(/(^\d{5}(-\d{4})?$)|(^[ABCEGHJKLMNPRSTVXYabceghjklmnpstvxy]{1}\d{1}[A-Za-z]{1} ?\d{1}[A-Za-z]{1}\d{1})$/) ) {
					postalCode.parent().addClass('error');
					errors++;
				}
				
				// validate phone number
				if ( !phoneNumber.val().match(/^(\d+-?)+\d+$/) || phoneNumber.val().length < 10 || phoneNumber.val().length > 14 ) {
					phoneNumber.parent().addClass('error');
					errors++;
				}
				
				// validate email
				if ( !email.val().match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/) ) {
					email.parent().addClass('error');
					errors++;
				}
				
				// confirm email
				if ( email.val() != emailConf.val() ) {
					emailConf.parent().addClass('error');
					errors++;
				}
				
				// remove input error class on click
				reqAll.parent().on('click change', function(){
					$(this).removeClass('error');
				});
				
				// if we have errors, don't submit
				if (errors >= 1) return false;
				
				if (errors == 0) {
					
					// collect input data
					id = this.options.userId;
					fname = $('input[name="fname"]').val();
					lname = $('input[name="lname"]').val();
					address = $('input[name="address"]').val();
					city = $('input[name="city"]').val();
					prov = $('select[name="prov"]').val();
					pcode = postalCode.val();
					phone = phoneNumber.val();
					email = email.val();
					newsletter = ( $('input[name="check-newsletter"]').is(':checked') ) ? 1 : 0;
					
					$.ajax({
						url: 'services/contest-entry.php',
						type: 'POST',
						data: {
							id: id,
							fname: fname,
							lname: lname,
							address: address,
							city: city,
							prov: prov,
							pcode: pcode,
							phone: phone,
							email: email,
							newsletter: newsletter
						},
						success: function (data) {
							if (data) {
								// successful registration
								
								// This is where you should add a class to the <html> tag
								// that switches from the form to the spin container (via css)
								o.html.addClass('returning');
								
							}
						}
					});
				}
				
			},
			tracking: function (track) {
				
				$('.analytics').on('click', function(){
					track = $(this).attr('data-tracking');
					
					_gaq.push(['_trackEvent', 'Click', track]);
				});
				
			}
			
		}
	}
	
	/*******************************************************************************
	Options Class
	*******************************************************************************/

	_.Options = function ($options) {
		// defaults
		this.returning				= false;
		this.signedRequest			= null;
		this.accessToken			= null;
		this.tabUrl					= null;
		this.userId					= null;

		// overwrite default options
		if ($options) {
			for (var p in $options) {
				if (this.hasOwnProperty(p)) {
					this[p] = $options[p];
				}
			}
		}
	}
	
	/******************************************************************************/

})(redskins)