// script.js

function openProductDetails(name, description, price) {
    alert("Tên sản phẩm: " + name + "\nMô tả: " + description + "\nGiá: " + price + "$");
}

document.getElementById("welcomeButton").addEventListener("click", function() {
    const firstName = document.getElementById("firstName").value.trim();
    if (firstName) {
        document.getElementById("userGreeting").innerText = "Chào mừng, " + firstName + "!";
    } else {
        alert("Vui lòng nhập tên của bạn.");
    }
});

document.getElementById("submitFeedback").addEventListener("click", function() {
    const feedback = document.getElementById("feedbackInput").value.trim();
    if (feedback) {
        alert("Cảm ơn bạn đã gửi phản hồi: " + feedback);
        document.getElementById("feedbackInput").value = ""; // Xóa nội dung sau khi gửi
    } else {
        alert("Vui lòng nhập phản hồi của bạn.");
    }
});