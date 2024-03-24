<?php
// app/Services/PrintService.php

namespace App\Services;

use Log;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

class PrintService
{
    public function printInvoice($invoiceContent)
    {
        try {
            // Create a network connector (adjust IP and port accordingly)
            $connector = new NetworkPrintConnector("192.168.1.100", 9100);

            // Create a printer
            $printer = new Printer($connector);

            // Print your invoice content
            $printer->text($invoiceContent);

            // Cut the paper (if applicable)
            $printer->cut();

            // Close the printer
            $printer->close();

            return true;
        } catch (\Exception $e) {
            // Handle any exceptions (printer not available, etc.)
            Log::error('Printing error: ' . $e->getMessage());
            return false;
        }
    }
}
