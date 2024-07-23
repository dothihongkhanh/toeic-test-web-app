<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification practice time</title>
    <style>
        .container {
            max-width: 600px;
            text-align: center;
        }

        h1 {
            color: #51be78;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>ToeicStudy</h1>
        <p>Hi, đến giờ luyện tập rồi <b>{{ $user->name }}</b> ơi.</p>
        <p>Hãy vào luyện tập nhé!!!</p>
        <i><a href="http://127.0.0.1:8000/">Click để đến trang luyện tập</a></i>
    </div>
</body>

</html>