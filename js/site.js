window.reset = window.reset || {};

(function (_) {
	
	if (_.Site) return;
	
	/***************************************************************************
	Site Class
	***************************************************************************/
	
	_.Site = new function () {
		return {
			html: $('html'),
			body: $('body'),
			init: function () {
				
				this.setMobile();

				$('a[href="#"]').on('click',function(e){e.preventDefault()});
			},
			setMobile: function () {
				if ( $('html').hasClass('mobile') ) {
					
					// scroll below address bar on iphone
					setTimeout(function(){
						window.scrollTo(0, 1);
					}, 0);
					
					// viewport bug fix for ipad/iphone
					var addEvent = 'addEventListener',
					    type = 'gesturestart',
					    qsa = 'querySelectorAll',
					    scales = [1, 1],
					    meta = qsa in document ? document[qsa]('meta[name=viewport]') : [];

					function fix() {
						meta.content = 'width=device-width,minimum-scale=' + scales[0] + ',maximum-scale=' + scales[1];
						document.removeEventListener(type, fix, true);
					}

					if ((meta = meta[meta.length - 1]) && addEvent in document) {
						fix();
						scales = [.25, 1.6];
						document[addEvent](type, fix, true);
					}

					// run function on orientation change
					window.onorientationchange = function() {
						
					};
				}
			}
		}
	}
	
	/******************************************************************************/

})(reset)