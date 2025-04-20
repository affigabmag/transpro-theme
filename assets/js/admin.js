/**
 * TransPro Theme Admin JavaScript
 */

(function($) {
    'use strict';
    
    // Document ready
    $(document).ready(function() {
        // Handle the text direction option change
        $('input[name="transpro_text_direction"]').on('change', function() {
            const direction = $(this).val();
            
            // Show a warning about refreshing after saving
            if ($('#transpro-direction-notice').length === 0) {
                const $notice = $('<div id="transpro-direction-notice" class="notice notice-warning inline"><p>' + 
                                  'Please save changes and refresh the page to see the text direction change in effect.' +
                                  '</p></div>');
                
                $(this).closest('form').prepend($notice);
            }
        });
        
        // Initialize color pickers if available
        if (typeof $.fn.wpColorPicker !== 'undefined') {
            $('.color-picker').wpColorPicker();
        }
        
        // Handle TransPro menu items
        $('#menu-to-edit').on('change', function() {
            const menuId = $(this).closest('form').find('input[name="menu"]').val();
            const menuName = $(this).closest('form').find('input[name="menu-name"]').val();
            
            // Check if this is the TransPro menu
            if (menuName === 'TransPro') {
                if ($('#transpro-menu-notice').length === 0) {
                    const $notice = $('<div id="transpro-menu-notice" class="notice notice-info inline"><p>' + 
                                      'This menu will appear in the sidebar for logged-in users. Any changes you make will be automatically reflected in the sidebar.' +
                                      '</p></div>');
                    
                    $('#menu-management').prepend($notice);
                }
            } else {
                $('#transpro-menu-notice').remove();
            }
        });
        
        // Trigger the change event on page load to initialize notices
        $('#menu-to-edit').trigger('change');
    });
    
})(jQuery);