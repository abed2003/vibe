<?php

// API routes are split by domain; each file is a plain route definition
// sharing the /api prefix and middleware configured in bootstrap/app.php.
require __DIR__.'/api/auth.php';
require __DIR__.'/api/videos.php';
require __DIR__.'/api/users.php';
