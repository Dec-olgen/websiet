// Ask before deleting
function confirmDelete(name) {
    return confirm("Delete " + name + "? This cannot be undone.");
}
// Hide the success message after 3 seconds
setTimeout(function () {
    var msg = document.querySelector(".msg");
    if (msg) msg.style.display = "none";
}, 3000);
