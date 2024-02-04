// JavaScript Timeout functionality For Alert Messages
document.addEventListener('DOMContentLoaded', function() {
    // console.log("DOM fully loaded and parsed");
    setTimeout(function() {
        var messageElement = document.getElementById('message');
        console.log("Looking for message element", messageElement);
        if (messageElement) {
            messageElement.style.display = 'none';
        }
    }, 5000); // Hide the message after 5 seconds
});

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

// JavaScript delete functionality for comments
function deleteComment(commentId) {
    if (confirm("Are you sure you want to delete this comment?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "/admin/comments/delete/" + commentId, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (this.status === 200) {
                // Handle success - remove the comment from the page or reload
                location.reload();
            } else {
                alert("Error deleting comment.");
            }
        };
        xhr.send("id=" + commentId);
    }
}

// JavaScript delete functionality for categories 
function deleteCategory(categoryId) {
    if (confirm("Are you sure you want to delete this category?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "/admin/categories/delete/" + categoryId, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (this.status === 200) {
                // Handle success - remove the category from the page or reload
                location.reload();
            } else {
                alert("Error deleting category.");
            }
        };
        xhr.send("id=" + categoryId);
    }
}



