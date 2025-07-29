<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Browsershot Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options for Browsershot PDF generation.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Chrome Binary Path
    |--------------------------------------------------------------------------
    |
    | The path to the Chrome/Chromium binary. This is required for Browsershot
    | to work. You can install Chrome/Chromium and set the path here.
    |
    | For Windows: 'C:\Program Files\Google\Chrome\Application\chrome.exe'
    | For macOS: '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome'
    | For Linux: '/usr/bin/google-chrome' or '/usr/bin/chromium-browser'
    |
    */
    'chrome_path' => env('CHROME_PATH', null),

    /*
    |--------------------------------------------------------------------------
    | Node Binary Path
    |--------------------------------------------------------------------------
    |
    | The path to the Node.js binary. This is required for Browsershot to work.
    |
    */
    'node_path' => env('NODE_PATH', null),

    /*
    |--------------------------------------------------------------------------
    | NPM Binary Path
    |--------------------------------------------------------------------------
    |
    | The path to the NPM binary. This is required for Browsershot to work.
    |
    */
    'npm_path' => env('NPM_PATH', null),

    /*
    |--------------------------------------------------------------------------
    | Default PDF Options
    |--------------------------------------------------------------------------
    |
    | Default options for PDF generation.
    |
    */
    'default_pdf_options' => [
        'format' => 'A4',
        'landscape' => false,
        'margins' => [
            'top' => '10mm',
            'right' => '10mm',
            'bottom' => '10mm',
            'left' => '10mm'
        ],
        'preferCssPageSize' => true,
        'printBackground' => true,
        'timeout' => 30000, // 30 seconds
    ],

    /*
    |--------------------------------------------------------------------------
    | Temporary Directory
    |--------------------------------------------------------------------------
    |
    | Directory where temporary HTML and PDF files will be stored.
    |
    */
    'temp_directory' => storage_path('app/temp'),
]; 