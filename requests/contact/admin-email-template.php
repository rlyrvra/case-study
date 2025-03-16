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

        .contact-details {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 6px;
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
        <h2>New Contact Form Submission</h2>
        <p>You have received a new message from your contact form:</p>

        <div class='contact-details'>
            <p><strong>Name:</strong> {name}</p>
            <p><strong>Email:</strong> {email}</p>
            <p><strong>Message:</strong></p>
            <p>{message}</p>
        </div>

        <div class='footer'>
            <p>Thank you for using our contact form!</p>
        </div>
    </div>
</body>

</html>