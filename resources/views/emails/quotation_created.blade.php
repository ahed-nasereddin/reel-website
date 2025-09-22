<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quotation Request Received</title>
            <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>
<body style="font-family: 'Helvetica', Arial, sans-serif; background-color: #f9fafb; margin: 0; padding: 0;">

    <div style="max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); overflow: hidden;">

        <!-- Header -->
        <div style="background-color: #10b981; color: white; padding: 20px 30px; text-align: center;">
            <h1 style="font-size: 24px; font-weight: bold; margin: 0;">Thank You!</h1>
        </div>

        <!-- Body -->
        <div style="padding: 30px; color: #111827;">

            <p style="margin-bottom: 12px; font-size: 16px;">Dear <strong>{{ $quotation->name }}</strong>,</p>

            <p style="margin-bottom: 12px; font-size: 16px;">Thank you for your quotation request. Here are the details you submitted:</p>

            <p style="margin-bottom: 12px; font-size: 16px;"><strong>Company:</strong> {{ $quotation->company_name }}</p>
            <p style="margin-bottom: 12px; font-size: 16px;"><strong>Number of Days:</strong> {{ $quotation->no_days }}</p>
            <p style="margin-bottom: 12px; font-size: 16px;"><strong>Pickup Date:</strong> {{ $quotation->pickup_date }}</p>
            <p style="margin-bottom: 12px; font-size: 16px;"><strong>Location:</strong> {{ $quotation->location }}</p>

            <p style="margin-top: 20px; margin-bottom: 12px; font-size: 16px;">
                We will review your request and contact you soon.
            </p>

            <hr style="border-color: #e5e7eb; margin: 20px 0;">

            <p style="font-size: 14px; color: #6b7280;">If you have any questions, feel free to reply to this email.</p>

        </div>

        <!-- Footer -->
        <div style="background-color: #f3f4f6; color: #6b7280; text-align: center; padding: 15px 20px; font-size: 12px;">
            &copy; {{ date('Y') }} Your Company Name. All rights reserved.
        </div>

    </div>

</body>
</html>
