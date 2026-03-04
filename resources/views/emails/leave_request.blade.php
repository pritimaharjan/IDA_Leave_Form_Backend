<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Leave Application Request</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">

    <p>Dear Sir/Madam,</p>

    <p>
        I hope this email finds you well. A new leave application has been submitted with the following details:
    </p>

    <table style="border-collapse: collapse; width: 100%; max-width: 600px;">
        <tr>
            <td style="padding: 8px; font-weight: bold;">Employee Name:</td>
            <td style="padding: 8px;">{{ $employee_name }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; font-weight: bold;">Employee Email:</td>
            <td style="padding: 8px;">{{ $employee_email }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; font-weight: bold;">Leave Type:</td>
            <td style="padding: 8px;">{{ $leave_slug }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; font-weight: bold;">Leave Period:</td>
            <td style="padding: 8px;">{{ $from_date }} to {{ $to_date }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; font-weight: bold;">Reason:</td>
            <td style="padding: 8px;">{{ $reason }}</td>
        </tr>
    </table>

    <p style="margin-top: 20px;">
        Kindly log in to the system to review and take the necessary action regarding this request.
    </p>

    <p>
        Thank you.
    </p>

    <p>
        Best Regards,<br>
        {{ $employee_name }}
    </p>

</body>
</html>

