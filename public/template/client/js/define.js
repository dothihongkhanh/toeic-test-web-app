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

    // Lắng nghe sự kiện click của input radio
    answerRadios.forEach(function (radio) {
        radio.addEventListener("click", function () {
            const selectedAnswerId = this.value;
            const questionId = getQuestionIdFromRadioName(this.name);

            // Lưu trạng thái đã chọn vào localStorage
            localStorage.setItem(
                getLocalStorageKey(questionId),
                selectedAnswerId
            );

            markSelectedAnswer(questionId);
        });
    });

    // Đánh dấu câu hỏi đã chọn đáp án
    function markSelectedAnswer(questionId) {
        const testNavItem = document.querySelector(
            '.test-nav-item[data-question-id="' + questionId + '"]'
        );
        const selectedAnswerId = localStorage.getItem(
            getLocalStorageKey(questionId)
        );
        if (selectedAnswerId) {
            testNavItem.classList.add("selected-answer");
        } else {
            testNavItem.classList.remove("selected-answer");
        }
    }

    // Lấy id của câu hỏi từ tên của input radio
    function getQuestionIdFromRadioName(name) {
        return name.replace("answer[", "").replace("]", "");
    }

    // Tạo key cho localStorage từ id của câu hỏi
    function getLocalStorageKey(questionId) {
        return "selectedAnswerId_" + questionId;
    }

    // Xóa dữ liệu trong localStorage trước khi trang được tải lại
    window.addEventListener("beforeunload", function () {
        localStorage.clear();
    });
});

//f5 lại trang
document.addEventListener("DOMContentLoaded", function () {
    var radios = document.querySelectorAll('input[type="radio"]');
    radios.forEach(function (radio) {
        radio.checked = false;
    });
});
//send time
var minutes = 0;
var seconds = 0;

function updateTimer() {
    seconds++;

    if (seconds >= 60) {
        seconds = 0;
        minutes++;
    }

    var formattedTime =
        ("0" + minutes).slice(-2) + ":" + ("0" + seconds).slice(-2);

    document.getElementById("timer").innerText = formattedTime;

    document.getElementById("timeElapsed").value = formattedTime;
}

setInterval(updateTimer, 1000);

document
    .getElementById("timeForm")
    .addEventListener("submit", function (event) {
        event.preventDefault();
        var timeElapsed = document.getElementById("timeElapsed").value;
        this.submit();
    });
