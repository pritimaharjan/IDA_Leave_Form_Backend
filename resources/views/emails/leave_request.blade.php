<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Leave Application</title>
</head>
<body>
    <h2>New Leave Application</h2>

    <p><strong>Employee:</strong> {{ $employee_name }}</p>
    <p><strong>Email:</strong> {{ $employee_email }}</p>
    <p><strong>Leave Type:</strong> {{ $leave_slug }}</p>
    <p><strong>From:</strong> {{ $from_date }}</p>
    <p><strong>To:</strong> {{ $to_date }}</p>
    <p><strong>Reason:</strong> {{ $reason }}</p>

    <p>Please log in to the system to review and approve this request.</p>
</body>
</html>