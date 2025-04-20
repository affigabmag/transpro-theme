/**
 * TransPro Theme Main JavaScript
 */

(function($) {
    'use strict';
    
    // Document ready
    $(document).ready(function() {
        // Mobile menu toggle
        $('.menu-toggle').on('click', function() {
            $('.main-navigation').toggleClass('toggled');
        });
        
        // Mobile sidebar toggle
        $('.sidebar-toggle').on('click', function() {
            $('body').toggleClass('sidebar-open');
        });
        
        // Close sidebar when clicking outside
        $(document).on('click', function(event) {
            if ($(window).width() <= 576) {
                if (!$(event.target).closest('.transpro-sidebar').length && 
                    !$(event.target).closest('.sidebar-toggle').length && 
                    $('body').hasClass('sidebar-open')) {
                    $('body').removeClass('sidebar-open');
                }
            }
        });
        
        // Add sidebar toggle button for mobile if necessary
        if ($('.transpro-sidebar').length && $('.sidebar-toggle').length === 0) {
            const $toggleButton = $('<button class="sidebar-toggle" aria-label="Toggle Sidebar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></button>');
            $('body').append($toggleButton);
        }
        
        // Handle RTL specific behaviors if needed
        if (transproData.is_rtl) {
            // Any RTL specific JavaScript can go here
        }
        
        // Adding active class to the current menu item
        const currentUrl = window.location.href;
        $('.sidebar-nav a').each(function() {
            if (this.href === currentUrl) {
                $(this).closest('li').addClass('current-menu-item');
            }
        });
    });
    
    // Window resize event to handle sidebar visibility
    $(window).on('resize', function() {
        if ($(window).width() > 576 && $('body').hasClass('sidebar-open')) {
            $('body').removeClass('sidebar-open');
        }
    });
    
})(jQuery);