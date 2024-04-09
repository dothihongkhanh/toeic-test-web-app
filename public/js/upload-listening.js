document.getElementById('imageUpload').addEventListener('change', function(event) {
    var files = event.target.files;
    var imagePaths = [];

    for (var i = 0; i < files.length; i++) {
        // Lấy đường dẫn của từng file được chọn và thêm vào mảng imagePaths
        var imagePath = URL.createObjectURL(files[i]);
        imagePaths.push(imagePath);
    }

    // Gửi mảng imagePaths đến máy chủ hoặc thực hiện xử lý khác theo nhu cầu của bạn
    console.log(imagePaths);
});

document.getElementById('audioUpload').addEventListener('change', function(event) {
    var files = event.target.files;
    var audioPaths = [];

    for (var i = 0; i < files.length; i++) {
        // Lấy đường dẫn của từng file được chọn và thêm vào mảng imagePaths
        var audioPath = URL.createObjectURL(files[i]);
        audioPaths.push(audioPath);
    }

    // Gửi mảng imagePaths đến máy chủ hoặc thực hiện xử lý khác theo nhu cầu của bạn
    console.log(audioPaths);
});
