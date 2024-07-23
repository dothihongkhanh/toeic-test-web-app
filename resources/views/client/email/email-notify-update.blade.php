<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo cập nhật câu hỏi</title>
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
        <h2>Thông báo cập nhật câu hỏi</h2>
        <p>Dear <b>{{ $user->name }},</b></p>
        <p>Chúng tôi đã có sự cập nhật lại câu hỏi số <i>{{ $child->question_number }}</i> trong đề thi <b>{{ $exam->name_exam }}</b>.</p>
        <p>Bạn kiểm tra lại nhé!</p>
        <i><a href="http://127.0.0.1:8000/">Click để đến trang luyện tập</a></i>
    </div>
</body>

</html>