/* Responsive Nav Menu */

var showResponsiveMenu = function() {
	var topPosition = jQuery(window).scrollTop();
	var leftPosition = jQuery('#top').css('left');

	if( leftPosition == '260px' ) {
		var scrollPosition = parseInt(jQuery('#top').css('top')) * -1;
		jQuery('#top').css('top','auto');
		jQuery('#top').css('position','relative');
		jQuery('#top').animate({ left: '0' }, 500, 'easeOutExpo');
		jQuery('#responsive-menu-switch').animate({ left: '0' }, 500, 'easeOutExpo');
		setTimeout(function(){
			jQuery('#htmlkombinat-responsive-menu-container').css('display', 'none');
		}, 500 );
		
	} else {
		jQuery('#top').css('top','-'+topPosition+'px');
		jQuery('#top').css('position','fixed');
		jQuery('#top').css('z-index','9900');
		jQuery('#top').animate({ left: '260px' }, 500, 'easeOutExpo');
		jQuery('#responsive-menu-switch').animate({ left: '260px' }, 500, 'easeOutExpo');
		jQuery('#htmlkombinat-responsive-menu-container').css('display', 'block');
		var scrollPosition = 0;
	}
	jQuery('html, body').animate({scrollTop:scrollPosition}, 0);
}

var showResponsiveSidebar = function() {
	var topPosition = jQuery(window).scrollTop();
	var leftPosition = jQuery('#top').css('left');

	if( leftPosition == '-260px' ) {
		var scrollPosition = parseInt(jQuery('#top').css('top')) * -1;
		jQuery('#top').css('top','auto');
		jQuery('#top').css('position','relative');
		jQuery('#top').animate({ left: '0' }, 500, 'easeOutExpo');
		jQuery('#responsive-menu-switch').animate({ left: '0' }, 500, 'easeOutExpo');
		setTimeout(function(){
			jQuery('#htmlkombinat-responsive-sidebar-container').css('display', 'none');
		}, 500 );
		
	} else {
		jQuery('#top').css('top','-'+topPosition+'px');
		jQuery('#top').css('position','fixed');
		jQuery('#top').css('z-index','9900');
		jQuery('#top').animate({ left: '-260px' }, 500, 'easeOutExpo');
		jQuery('#responsive-menu-switch').animate({ left: '-260px' }, 500, 'easeOutExpo');
		jQuery('#htmlkombinat-responsive-sidebar-container').css('display', 'block');
		jQuery('#htmlkombinat-responsive-sidebar-container').children().css('display', 'block');
		var scrollPosition = 0;
	}
	jQuery('html, body').animate({scrollTop:scrollPosition}, 0);
}

/* Use */
var responsiveLayout = function() {
	var windowWidth = jQuery(window).innerWidth();
	if( windowWidth <= 1024 ) {
		if( jQuery('#htmlkombinat-responsive-menu-container').children().size() == 0) {
			// Dark body
			jQuery('body').css('background', '#28292e');
			// Navigation Container
			var element = jQuery('#header-search').detach();
			jQuery('#htmlkombinat-responsive-menu-container').append(element);
			var element = jQuery('#main-navigation').detach();
			jQuery('#htmlkombinat-responsive-menu-container').append(element);
			var element = jQuery('#secondary-navigation').detach();
			jQuery('#htmlkombinat-responsive-menu-container').append(element);
		}
		if( jQuery('#htmlkombinat-responsive-sidebar-container').children().size() == 0) {
			// Sidebar Container
			var element = jQuery('#sidebar').detach();
			jQuery('#htmlkombinat-responsive-sidebar-container').append(element);
		}

	} else {
		if( jQuery('#htmlkombinat-responsive-menu-container').children().size() > 0) {
			// Standard Background
			var backgroundimage;
			if( custom_background_image != '' ) {
				backgroundimage = ' url('+custom_background_image+')';
			}
			jQuery('body').css('background', '#'+custom_background_color+backgroundimage);
			// Navigation Container
			var element = jQuery('#header-search').detach();
			jQuery('#header-search-wrapper').append(element);
			var element = jQuery('#secondary-navigation').detach();
			jQuery('#secondary-navigation-wrapper').append(element);
			var element = jQuery('#main-navigation').detach();
			jQuery('#main-navigation-wrapper').append(element);
		}
		if( jQuery('#htmlkombinat-responsive-sidebar-container').children().size() > 0) {
			// Sidebar Container
			var element = jQuery('#sidebar').detach();
			jQuery('#page-content').append(element);
			var element = jQuery('#content-clear').detach();
			jQuery('#page-content').append(element);
		}
	}
}

jQuery(window).resize(function(){
	responsiveLayout();
});



jQuery(document).ready(function($) {
	$('#menu-toggle-button').click(function(e) {
		e.preventDefault();
		showResponsiveMenu();
	});
});


jQuery(document).ready(function($) {
	$('#sidebar-toggle-button').click(function(e) {
		e.preventDefault();
		showResponsiveSidebar();
	});
});

// Initialize Responsive Layout
jQuery(document).ready(function() {
	responsiveLayout();
});

// Scroll to top when page is loaded (looks better on the iPhone)
jQuery(document).ready(function($) {
	$('html, body').animate({scrollTop:0}, 0);
});