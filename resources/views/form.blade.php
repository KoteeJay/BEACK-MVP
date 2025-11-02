<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Test</title>
</head>
<body>
    <form action="{{ route('form.submit') }}" method="POST">
        @csrf
        <input type="text" name="example_input" placeholder="Enter something">
        <button type="submit">Submit</button>
    </form>
</body>
</html>
