<!-- /**
    * Debug Kit (Borders)
    * This section conditionally includes styles for debugging purposes.
    */
    /*
    * If the DEBUG_MODE environment variable is set to 'true', it applies a green outline to all elements.
 -->

<?php
$debug_mode = ($_ENV['DEBUG_MODE'] === 'true');

if ($debug_mode):
    ?>
    <style>
        * {
            outline: 1px solid rgba(0, 255, 0, 0.05);
        }
    </style>
<?php endif; ?>