<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>
    <h2>Congratulations: you've been invited to BYS project as Assistant</h2>
    <h3>Your credentials:</h3>
    <p>Email: {{ $data['email'] }}</p>
    <p>Password: {{ $data['password'] }}</p>

    <p>
        <b>{{ $data['message'] }}</b>
    </p>
</div>

</body>
</html>
