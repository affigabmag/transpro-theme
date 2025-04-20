<?php
/**
 * Debug helper for TransPro theme
 * Place this at the very top of your functions.php for testing
 */

// Enable error reporting for troubleshooting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check for unclosed PHP tags in the theme folder
function transpro_debug_check_files() {
    $theme_dir = get_template_directory();
    $result = array();
    
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($theme_dir)
    );
    
    foreach ($files as $file) {
        if ($file->isFile() && pathinfo($file->getFilename(), PATHINFO_EXTENSION) === 'php') {
            $content = file_get_contents($file->getPathname());
            $php_open_tags = substr_count($content, '<?php');
            $php_close_tags = substr_count($content, '?>');
            
            if ($php_open_tags !== $php_close_tags) {
                $result[] = array(
                    'file' => str_replace($theme_dir, '', $file->getPathname()),
                    'open_tags' => $php_open_tags,
                    'close_tags' => $php_close_tags
                );
            }
        }
    }
    
    return $result;
}

// Only run this check when the 'transpro_debug' parameter is in the URL
if (isset($_GET['transpro_debug'])) {
    add_action('admin_notices', function() {
        $problems = transpro_debug_check_files();
        if (!empty($problems)) {
            echo '<div class="notice notice-error">';
            echo '<h3>TransPro Debug: Possible PHP tag issues found</h3>';
            echo '<ul>';
            foreach ($problems as $problem) {
                echo '<li>File: ' . esc_html($problem['file']) . ' - ';
                echo 'PHP open tags: ' . esc_html($problem['open_tags']) . ', ';
                echo 'PHP close tags: ' . esc_html($problem['close_tags']) . '</li>';
            }
            echo '</ul>';
            echo '</div>';
        } else {
            echo '<div class="notice notice-success">';
            echo '<p>TransPro Debug: No PHP tag issues found.</p>';
            echo '</div>';
        }
    });
}