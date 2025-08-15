<!DOCTYPE html>
<html>
<head>
    <title> Application - Bethany Memorial Park</title>
</head>
<body>
    <h1>New Application Submitted</h1>
    <p>A new application has been submitted and is marked as pending review.</p>

   <h2>Applicant Information</h2>
<p><strong>Name:</strong> {{ $application->applicant_name }}</p>
<p><strong>Address:</strong> {{ $application->address }}</p>
<p><strong>Cellphone No.:</strong> {{ $application->cellphone_no }}</p>
<p><strong>Email:</strong> {{ $application->email ?? 'Not provided' }}</p>
<p><strong>Facebook Messenger:</strong> {{ $application->facebook_messenger ?? 'Not provided' }}</p>
<p><strong>Next of Kin:</strong> {{ $application->next_of_kin }}</p>

<h2>Memorial Lot(s) Applied For</h2>
<table border="1" cellpadding="6" cellspacing="0">
    <thead>
        <tr>
            <th>Niche/Lot #</th>
            <th>Block/Level #</th>
            <th>Description</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
    @foreach($lots as $lot)
        <tr>
            <td>{{ $lot['niche_lot'] ?? '' }}</td>
            <td>{{ $lot['block_level'] ?? '' }}</td>
            <td>{{ $lot['desc'] ?? '' }}</td>
            <td>{{ $lot['price'] ?? '' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<h2>Additional Details</h2>
<p><strong>Terms:</strong> {{ $application->terms }}</p>
<p><strong>Remarks:</strong> {{ $application->remarks }}</p>

<h2>Signatures</h2>
<p><strong>Printed Name and Signature of Purchaser:</strong> {{ $application->purchaser_name }} ({{ $application->signature_agreement ? 'Agreed' : 'Not agreed' }})</p>
<p><strong>Name of Agent:</strong> {{ $application->agent_name }}</p>
<p><strong>Date:</strong> {{ $application->date }}</p>
<p><strong>Attached Document:</strong> {{ $application->file_path ? 'An uploaded document is attached.' : 'No document uploaded.' }}</p>

<p>Please log in to the admin dashboard to review and update the application status.</p>
</body>
</html>
