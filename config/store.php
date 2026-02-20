<?php

return [
    'download_expiry_hours' => (int) env('DOWNLOAD_EXPIRY_HOURS', 24),
    'download_limit' => (int) env('DOWNLOAD_LIMIT', 20),
    'support_email' => env('SUPPORT_EMAIL', 'support@glowthstore.test'),
    'product_files_disk' => env('PRODUCT_FILES_DISK', 'local'),
    'license_summary' => 'Single standard license for one buyer account. You may use assets in commercial client work, but redistribution/resale of source files is not allowed.',
];
