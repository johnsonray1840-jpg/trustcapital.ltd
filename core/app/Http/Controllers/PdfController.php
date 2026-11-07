<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function generateCis()
    {
        // Client data
        $data = [
            'client_name' => 'Dora Nikolaus',
            'nationality' => 'Slovenia',
            'issuing_country' => 'Slovenia',
            'date_of_birth' => 'March 20, 1995',
            'place_of_birth' => 'Celje, Slovenia',
            'mobile_number' => '+386 70 501 087',
            'email' => 'doranikolaus78@gmail.com',
            'business_name' => 'Trust Capital Limited',
            'position_title' => 'Co-owner / Managing Director',
            'business_address' => 'No. 43, Kung 3rd Lane, Kaohsiung Hsien',
            'registered_address' => 'No. 43, Kung 3rd Lane, Kaohsiung Hsien',
            'years_in_business' => '10',
            'date_incorporated' => 'March 27, 2016',
            'place_of_incorporation' => 'Republic of Taiwan',
            'business_phone' => '+886 7 371 4215',
            'cis_number' => 'CIS-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
            'generation_date' => date('F j, Y'),
        ];

        $pdf = Pdf::loadView('pdf.cis', $data);
        
        // Download PDF
        return $pdf->download('Trust-Capital-CIS-' . date('Y-m-d') . '.pdf');
        
        // OR Display in browser
        // return $pdf->stream('Trust-Capital-CIS.pdf');
    }
}