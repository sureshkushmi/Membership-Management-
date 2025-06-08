<!DOCTYPE html>
<html>
<head>
    <title>Membership Rejection</title>
</head>
<body>
    <h1>Hello {{ $user->name }},</h1>
    <p>We regret to inform you that your membership application has been rejected.</p>

    <p><strong>Reason:</strong> {{ $reason }}</p>

    <p>If you have any questions, feel free to contact us.</p>

    <p>Thank you,<br>Team</p>
</body>
</html>
