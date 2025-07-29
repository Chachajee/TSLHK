<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Browsershot\Browsershot;

class TestBrowsershot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'browsershot:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Browsershot PDF generation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Browsershot PDF generation...');

        try {
            // Create a simple test HTML
            $html = '
            <!DOCTYPE html>
            <html>
            <head>
                <title>Browsershot Test</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; }
                    h1 { color: #333; }
                    .test-content { background: #f5f5f5; padding: 15px; border-radius: 5px; }
                </style>
            </head>
            <body>
                <h1>Browsershot Test PDF</h1>
                <div class="test-content">
                    <p>This is a test PDF generated using Browsershot.</p>
                    <p>Generated at: ' . now()->format('Y-m-d H:i:s') . '</p>
                </div>
            </body>
            </html>';

            // Create temporary PDF file
            $tempPdfPath = storage_path('app/temp/test.pdf');
            
            // Ensure temp directory exists
            if (!file_exists(dirname($tempPdfPath))) {
                mkdir(dirname($tempPdfPath), 0755, true);
            }

            $this->info('Generating PDF...');

            // Configure Browsershot with HTML content directly
            $browsershot = Browsershot::html($html)
                ->format('A4')
                ->landscape(false)
                ->margins(10, 10, 10, 10)
                ->preferCssPageSize(true)
                ->printBackground(true)
                ->timeout(30000);

            // Set Chrome path if configured
            if (config('browsershot.chrome_path')) {
                $browsershot->setChromePath(config('browsershot.chrome_path'));
                $this->info('Using Chrome path: ' . config('browsershot.chrome_path'));
            }

            // Set Node path if configured
            if (config('browsershot.node_path')) {
                $browsershot->setNodeBinary(config('browsershot.node_path'));
                $this->info('Using Node path: ' . config('browsershot.node_path'));
            }

            // Set NPM path if configured
            if (config('browsershot.npm_path')) {
                $browsershot->setNpmBinary(config('browsershot.npm_path'));
                $this->info('Using NPM path: ' . config('browsershot.npm_path'));
            }

            // Save PDF to temporary file
            $browsershot->savePdf($tempPdfPath);

            // Check if PDF was created
            if (file_exists($tempPdfPath)) {
                $fileSize = filesize($tempPdfPath);
                $this->info('✅ PDF generated successfully!');
                $this->info("📄 File size: {$fileSize} bytes");
                $this->info("📁 Location: {$tempPdfPath}");
                
                // Clean up temporary file
                unlink($tempPdfPath);
                
                $this->info('🧹 Temporary files cleaned up.');
            } else {
                $this->error('❌ PDF file was not created.');
            }

        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            
            // Clean up temporary file if it exists
            if (isset($tempPdfPath) && file_exists($tempPdfPath)) {
                unlink($tempPdfPath);
            }
            
            return 1;
        }

        return 0;
    }
} 