<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Summary #{{ $appointment->id }} - Genesis Goodhope</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            margin: 40px;
            font-size: 14px;
            line-height: 1.5;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            border: 1px solid #eee;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
        }
        .header-table {
            width: 100%;
            margin-bottom: 40px;
        }
        .header-table td {
            vertical-align: top;
        }
        .logo {
            font-size: 24px;
            font-weight: 900;
            color: #0d9488;
            text-transform: uppercase;
        }
        .company-info {
            text-align: right;
            font-size: 12px;
            color: #666;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        .details-table th, .details-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .details-table th {
            background-color: #f9f9f9;
            font-weight: bold;
        }
        .totals-table {
            width: 100%;
            margin-top: 20px;
        }
        .totals-table td {
            padding: 5px 10px;
        }
        .totals-table .amount {
            text-align: right;
            font-weight: bold;
            font-size: 16px;
            color: #0d9488;
        }
        .footer {
            margin-top: 50px;
            border-top: 1px dashed #eee;
            padding-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
        .btn-print {
            display: block;
            width: 120px;
            margin: 20px auto;
            padding: 10px;
            background-color: #0d9488;
            color: white;
            border: none;
            border-radius: 20px;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
        }
        @media print {
            .btn-print {
                display: none;
            }
            body {
                margin: 0;
            }
            .invoice-box {
                border: none;
                box-shadow: none;
                padding: 0;
            }
        }
    </style>
</head>
<body>

    <button onclick="window.print()" class="btn-print">Print Document</button>

    <div class="invoice-box">
        <table class="header-table">
            <tr>
                <td>
                    <div class="logo">Genesis Goodhope</div>
                    <div style="font-size: 12px; color: #666; margin-top: 5px;">Population Health & Wellness</div>
                </td>
                <td class="company-info">
                    <strong>Genesis Goodhope Population Health</strong><br>
                    Harare, Zimbabwe<br>
                    Phone: 071 216 2369<br>
                    Email: info@genesis.org.zw
                </td>
            </tr>
        </table>

        <div style="margin-bottom: 30px;">
            <h2 style="border-bottom: 2px solid #0d9488; padding-bottom: 8px; margin-bottom: 15px;">Appointment Invoice & Summary</h2>
            <table style="width: 100%; font-size: 13px;">
                <tr>
                    <td style="width: 50%; vertical-align: top;">
                        <strong>PATIENT DETAILS:</strong><br>
                        {{ $appointment->patient->user->name ?? 'N/A' }}<br>
                        Email: {{ $appointment->patient->user->email ?? 'N/A' }}<br>
                        Phone: {{ $appointment->patient->phone ?? 'N/A' }}<br>
                        Address: {{ $appointment->patient->address ?? 'N/A' }}
                    </td>
                    <td style="width: 50%; vertical-align: top; text-align: right;">
                        <strong>INVOICE INFO:</strong><br>
                        Booking Ref: GGH-{{ str_pad($appointment->id, 5, '0', STR_PAD_LEFT) }}<br>
                        Date Booked: {{ $appointment->created_at ? $appointment->created_at->format('Y-m-d') : 'N/A' }}<br>
                        Status: <strong>{{ strtoupper($appointment->status) }}</strong>
                    </td>
                </tr>
            </table>
        </div>

        <table class="details-table">
            <thead>
                <tr>
                    <th>Service Description</th>
                    <th>Duration</th>
                    <th style="text-align: right;">Cost Rate</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>{{ $appointment->service->name ?? 'N/A' }}</strong><br>
                        <span style="font-size: 12px; color: #666;">
                            Scheduled for: {{ $appointment->appointment_date ? $appointment->appointment_date->format('l, F j, Y') : 'N/A' }} at {{ $appointment->appointment_time }}
                        </span>
                    </td>
                    <td>{{ $appointment->service->duration ?? 0 }} minutes</td>
                    <td style="text-align: right;">${{ number_format($appointment->service->price ?? 0, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <table class="totals-table" style="width: 100%; border-top: 2px solid #eee;">
            <tr>
                <td style="text-align: right; width: 80%;"><strong>Subtotal:</strong></td>
                <td style="text-align: right;">${{ number_format($appointment->service->price ?? 0, 2) }}</td>
            </tr>
            <tr>
                <td style="text-align: right; width: 80%;"><strong>VAT (0%):</strong></td>
                <td style="text-align: right;">$0.00</td>
            </tr>
            <tr>
                <td style="text-align: right; width: 80%; font-size: 15px;"><strong>Grand Total:</strong></td>
                <td class="amount">${{ number_format($appointment->service->price ?? 0, 2) }}</td>
            </tr>
        </table>

        @if($appointment->notes)
            <div style="margin-top: 30px; background-color: #fcfcfc; padding: 15px; border-radius: 5px; border: 1px solid #f0f0f0;">
                <h4 style="margin: 0 0 5px 0; font-size: 12px; color: #666;">PATIENT SYMPTOMS / NOTES:</h4>
                <p style="margin: 0; font-style: italic; font-size: 13px;">"{{ $appointment->notes }}"</p>
            </div>
        @endif

        @if($appointment->staff_notes)
            <div style="margin-top: 20px; background-color: #f0fdfa; padding: 15px; border-radius: 5px; border: 1px solid #ccfbf1;">
                <h4 style="margin: 0 0 5px 0; font-size: 12px; color: #0d9488;">DOCTOR FINDINGS & FEEDBACK:</h4>
                <p style="margin: 0; font-size: 13px;">{{ $appointment->staff_notes }}</p>
            </div>
        @endif

        <div class="footer">
            Thank you for choosing Genesis Goodhope Population Health.<br>
            <em>"Your Wellness is Our Genesis"</em>
        </div>
    </div>

</body>
</html>
