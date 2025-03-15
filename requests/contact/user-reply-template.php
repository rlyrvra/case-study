<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }

        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            font-size: 20px;
        }

        p {
            font-size: 16px;
            line-height: 1.5;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class='email-container'>
        <h2>Thank you for reaching out!</h2>
        <p>Dear {name},</p>
        <p>Thank you for contacting us. We have received your message and will get back to you as soon as possible. Here’s a copy of your message:</p>

        <div class='contact-details'>
            <p><strong>Your Message:</strong></p>
            <p>{message}</p>
        </div>

        <div class='footer'>
            <p>Best regards,<br>Your Company Name</p>
        </div>
    </div>
</body>

</html>