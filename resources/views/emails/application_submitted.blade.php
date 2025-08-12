<!DOCTYPE html>
<html>
<head>
    <title>New Burial Service Application</title>
</head>
<body>
    <h1>New Application Submitted</h1>
    <p>A new burial service application has been submitted and is marked as pending.</p>
    <p><strong>Applicant Name:</strong> {{ $application->applicant_name }}</p>
    <p><strong>Applicant Email:</strong> {{ $application->applicant_email }}</p>
    <p><strong>Applicant Phone:</strong> {{ $application->applicant_phone }}</p>
    <p><strong>Deceased Name:</strong> {{ $application->deceased_name }}</p>
    <p><strong>File:</strong> <a href="{{ Storage::url($application->file_path) }}">View Document</a></p>
    <p>Please log in to the admin dashboard to review and update the status.</p>
</body>
</html>