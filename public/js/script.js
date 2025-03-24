// JavaScript để đóng mở sidebar
document.querySelector('.menu-toggle').addEventListener('click', function () {
    document.querySelector('.sidebar').classList.toggle('active');
});



// note:Delete User-------------------
function deleteUser(userId) {
    if (confirm("Bạn có chắc là muốn xóa?")) {
        fetch("index.php?controller=user&action=delete", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: "id=" + userId
        })
            .then(response => response.text())
            .then(data => {
                alert("Xóa thành công!");
                location.reload(); // Reload lại trang sau khi xóa thành công
            })
            .catch(error => console.error("Lỗi:", error));
    }
}

// note:Delete Movie-------------------

function deleteMovie(movieId) {
    if (confirm("Bạn có chắc là muốn xóa?")) {
        fetch("index.php?controller=movie&action=delete", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: "id=" + movieId
        })
            .then(response => response.text())
            .then(data => {
                alert("Xóa thành công!");
                location.reload(); // Reload lại trang sau khi xóa thành công
            })
            .catch(error => console.error("Lỗi:", error));
    }
}

// Note: Delete Theaters

function deleteTheater(theaterId) {
    if (confirm("Bạn có chắc là muốn xóa?")) {
        fetch("index.php?controller=theater&action=delete", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: "id=" + theaterId
        })
            .then(response => response.text())
            .then(data => {
                alert("Xóa thành công!");
                location.reload(); // Reload lại trang sau khi xóa thành công
            })
            .catch(error => console.error("Lỗi:", error));
    }
}

// Note: Delete Genres
function deleteGenres(genresId) {
    if (confirm("Bạn có chắc là muốn xóa?")) {
        fetch("index.php?controller=genres&action=delete", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: "id=" + genresId
        })
            .then(response => response.text())
            .then(data => {
                alert("Xóa thành công!");
                location.reload(); // Reload lại trang sau khi xóa thành công
            })
            .catch(error => console.error("Lỗi:", error));
    }
}