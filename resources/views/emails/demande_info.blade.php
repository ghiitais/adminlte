<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirmation de l'envoie de votre demande</title>
</head>
<body>
<p>
    Thank you {{ ucfirst($user->name) }} for contacting our support team. A support ticket has been opened for you. You will be notified when a response is made by email. The details of your ticket are shown below:
</p>

<p>Title: {{ $demande->type }}</p>
<p>Priority: {{ $demande->priority }}</p>
<p>Status: {{ $demande->status }}</p>


</body>
</html>