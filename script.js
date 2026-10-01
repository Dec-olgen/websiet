// Ask before deleting
function confirmDelete(name) {
    return confirm("Delete " + name + "? This cannot be undone.");
}

// Hide the success message after 3 seconds
setTimeout(function () {
    var msg = document.querySelector(".msg");
    if (msg) msg.style.display = "none";
}, 3000);

// Highlight the nav tab for the page you are on
(function () {
    var page = location.pathname.split("/").pop() || "index.php";
    document.querySelectorAll("header nav a").forEach(function (a) {
        if (a.getAttribute("href") === page) a.classList.add("active");
    });
})();
