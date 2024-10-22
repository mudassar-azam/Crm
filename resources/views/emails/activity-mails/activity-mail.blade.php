<!DOCTYPE html>
<html>
<head>
    <title>Activity Mail</title>
</head>
<body>
    <h1>Hello,</h1>
    <p>Email: {{ $data['email'] }}</p>
    <p>Location: {{ $data['location'] }}</p>
    <p>Email Body: {{ $data['email_body'] }}</p>
    <p>Subject: {{ $data['subject'] }}</p>
    <p>Express: {{ $data['express'] }}</p>
    <p>Note: {{ $data['email_note'] }}</p>
</body>
</html>
