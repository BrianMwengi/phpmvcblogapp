
 // JavaScript delete functionality for admin posts
 function deletePost(postId) {
    if (confirm("Are you sure you want to delete this post?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "/admin/posts/delete/" + postId, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (this.status === 200) {
                // Handle success
                location.reload(); // Reloads the current page
            } else {
                // Handle error
                alert("Error deleting post.");
            }
        };
        xhr.send("id=" + postId);
    }
}