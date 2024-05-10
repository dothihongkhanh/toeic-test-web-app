const questionItems = document.querySelectorAll(".test-nav-item");

questionItems.forEach((item) => {
    item.addEventListener("click", () => {
        const questionId = item.getAttribute("data-question-id");

        const targetQuestion = document.getElementById(questionId);

        if (targetQuestion) {
            targetQuestion.scrollIntoView({ behavior: "smooth" });
        }
    });
});
// select answer
document.addEventListener("DOMContentLoaded", function () {
    const answerRadios = document.querySelectorAll('input[name^="answer["]');

    // Lặp qua từng nút radio
    answerRadios.forEach(function (radio) {
        // Thêm sự kiện click cho mỗi nút radio
        radio.addEventListener("click", function () {
            // Lấy giá trị của nút radio được chọn
            const selectedAnswerId = this.value;

            // Lấy ID của câu hỏi từ tên trường input radio
            const questionId = this.name.replace('answer[', '').replace(']', '');

            // Lưu trữ giá trị của nút radio được chọn vào localStorage
            localStorage.setItem("selectedAnswerId_" + questionId, selectedAnswerId);

            // Xác định phần tử test-nav-item tương ứng với câu hỏi được chọn
            const testNavItem = document.querySelector(
                '.test-nav-item[data-question-id="' + questionId + '"]'
            );

            // Thêm hoặc xóa lớp selected-answer tùy thuộc vào việc người dùng đã chọn đáp án hay không
            if (selectedAnswerId) {
                testNavItem.classList.add("selected-answer");
            } else {
                testNavItem.classList.remove("selected-answer");
            }
        });

        // Kiểm tra xem có giá trị được lưu trong localStorage hay không khi trang được tải lại
        const questionId = radio.name.replace('answer[', '').replace(']', '');
        const selectedAnswerId = localStorage.getItem("selectedAnswerId_" + questionId);
        if (selectedAnswerId && selectedAnswerId === radio.value) {
            // Nếu có, đánh dấu nút radio được chọn và thêm lớp selected-answer vào test-nav-item tương ứng
            radio.checked = true;
            const testNavItem = document.querySelector('.test-nav-item[data-question-id="' + questionId + '"]');
            testNavItem.classList.add("selected-answer");
        }
    });
});
//f5 lại trang
document.addEventListener("DOMContentLoaded", function() {
    var radios = document.querySelectorAll('input[type="radio"]');
    radios.forEach(function(radio) {
        radio.checked = false;
    });
});
//send time
// var minutes = 0;
// var seconds = 0;

// function updateTimer() {
//     seconds++;

//     if (seconds >= 60) {
//         seconds = 0;
//         minutes++;
//     }

//     var formattedTime =
//         ('0' + minutes).slice(-2) + ':' +
//         ('0' + seconds).slice(-2);

//     document.getElementById('timer').innerText = formattedTime;

//     document.getElementById('timeElapsed').value = formattedTime;
// }

// setInterval(updateTimer, 1000);

// document.getElementById('timeForm').addEventListener('submit', function(event) {
//     event.preventDefault();
//     var timeElapsed = document.getElementById('timeElapsed').value;
//     this.submit();
// });
