<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Trust Capital Limited - Client Information Sheet</title>
    <style>
        /* CIS PDF Styles */
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .letterhead {
            border-bottom: 3px solid #2c3e50;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        
        .letterhead h1 {
            color: #2c3e50;
            margin: 0;
            font-size: 24px;
        }
        
        .letterhead .subtitle {
            color: #7f8c8d;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .header-info {
            text-align: right;
            margin-bottom: 20px;
        }
        
        .cis-title {
            background-color: #2c3e50;
            color: white;
            padding: 10px 15px;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        
        .section-title {
            background-color: #ecf0f1;
            padding: 8px 12px;
            font-weight: bold;
            color: #2c3e50;
            border-left: 4px solid #3498db;
            margin-bottom: 15px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .info-item {
            margin-bottom: 12px;
        }
        
        .info-label {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 3px;
            font-size: 11px;
            text-transform: uppercase;
        }
        
        .info-value {
            padding: 8px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            min-height: 30px;
            display: flex;
            align-items: center;
        }
        
        .signature-section {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #dee2e6;
        }
        
        .signature-line {
            width: 300px;
            border-top: 1px solid #333;
            margin-top: 40px;
            margin-bottom: 5px;
        }
        
        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
        }
        
        .watermark {
            position: absolute;
            opacity: 0.1;
            font-size: 80px;
            color: #2c3e50;
            transform: rotate(-45deg);
            top: 40%;
            left: 10%;
            z-index: -1;
        }
        
        /* Print specific styles */
        @media print {
            .no-print {
                display: none;
            }
            body {
                padding: 0;
            }
        }
        
        .full-width {
            grid-column: 1 / -1;
        }
    </style>
</head>
<body>
    <!-- Watermark -->
    <div class="watermark">TRUST CAPITAL</div>
    
    <!-- Letterhead -->
    <div class="letterhead">
        <h1>TRUST CAPITAL LIMITED</h1>
        <div class="subtitle">Equity Investment & Project Funding</div>
        <div class="header-info">
            <div><strong>CIS Number:</strong> {{ $cis_number }}</div>
            <div><strong>Date Generated:</strong> {{ $generation_date }}</div>
        </div>
    </div>
    
    <!-- CIS Title -->
    <div class="cis-title">
        CLIENT INFORMATION SHEET (CIS)
    </div>
    
    <!-- Section 1: Personal Information -->
    <div class="section">
        <div class="section-title">I. PERSONAL INFORMATION</div>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Client's Full Name</div>
                <div class="info-value">{{ $client_name }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Nationality</div>
                <div class="info-value">{{ $nationality }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Issuing Country</div>
                <div class="info-value">{{ $issuing_country }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Date of Birth</div>
                <div class="info-value">{{ $date_of_birth }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Place of Birth</div>
                <div class="info-value">{{ $place_of_birth }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Mobile Telephone</div>
                <div class="info-value">{{ $mobile_number }}</div>
            </div>
            <div class="info-item full-width">
                <div class="info-label">Private Email Address</div>
                <div class="info-value">{{ $email }}</div>
            </div>
        </div>
    </div>
    
    <!-- Section 2: Business Information -->
    <div class="section">
        <div class="section-title">II. BUSINESS INFORMATION</div>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Business Name</div>
                <div class="info-value">{{ $business_name }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Position / Title</div>
                <div class="info-value">{{ $position_title }}</div>
            </div>
            <div class="info-item full-width">
                <div class="info-label">Business Address</div>
                <div class="info-value">{{ $business_address }}</div>
            </div>
            <div class="info-item full-width">
                <div class="info-label">Registered Address</div>
                <div class="info-value">{{ $registered_address }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Years in Business</div>
                <div class="info-value">{{ $years_in_business }} years</div>
            </div>
            <div class="info-item">
                <div class="info-label">Date Incorporated</div>
                <div class="info-value">{{ $date_incorporated }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Place of Incorporation</div>
                <div class="info-value">{{ $place_of_incorporation }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Business Telephone</div>
                <div class="info-value">{{ $business_phone }}</div>
            </div>
        </div>
    </div>
    
    <!-- Section 3: Additional Information -->
    <div class="section">
        <div class="section-title">III. ADDITIONAL INFORMATION</div>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Entity Type</div>
                <div class="info-value">Private Limited Company</div>
            </div>
            <div class="info-item">
                <div class="info-label">Industry</div>
                <div class="info-value">Financial Services / Equity Investment</div>
            </div>
            <div class="info-item">
                <div class="info-label">Business Type</div>
                <div class="info-value">Equity-based Project Funding</div>
            </div>
            <div class="info-item">
                <div class="info-label">Tax Residence</div>
                <div class="info-value">Taiwan / Slovenia</div>
            </div>
        </div>
    </div>
    
    <!-- Section 4: Declaration -->
    <div class="section">
        <div class="section-title">IV. DECLARATION & AUTHORIZATION</div>
        <div style="margin-bottom: 20px;">
            <p>I, <strong>{{ $client_name }}</strong>, hereby declare that the information provided in this Client Information Sheet is true, accurate, and complete to the best of my knowledge.</p>
            <p>I authorize Trust Capital Limited to use this information for the purposes of client identification, due diligence, and regulatory compliance as required by applicable laws and regulations.</p>
        </div>
        
        <div class="signature-section">
            <div style="margin-bottom: 20px;">
                <strong>Date:</strong> ___________________________
            </div>
            
            <div>
                <div class="signature-line"></div>
                <div style="text-align: center;">
                    <strong>Signature</strong>
                </div>
            </div>
            
            <div style="margin-top: 30px;">
                <div class="signature-line"></div>
                <div style="text-align: center;">
                    <strong>Full Name: {{ $client_name }}</strong>
                </div>
            </div>
            
            <div style="margin-top: 30px;">
                <div class="signature-line"></div>
                <div style="text-align: center;">
                    <strong>Position: {{ $position_title }}</strong>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <div class="footer">
        <strong>TRUST CAPITAL LIMITED</strong> | {{ $business_address }} | Tel: {{ $business_phone }}<br>
        This document is confidential and intended for authorized use only. Generated on {{ $generation_date }}
    </div>
</body>
</html>