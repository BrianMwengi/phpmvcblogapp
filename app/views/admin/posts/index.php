<!--views/admin/posts/index.php-->
<?php
// Start output buffering
ob_start();
?>
<!-- Display message -->
<?php if (isset($_SESSION['message'])): ?>
        <div id="message" class="<?php echo strpos($_SESSION['message'], 'error') !== false ? 'message-error' : 'message-success' ?> text-center">
            <?php 
                echo $_SESSION['message']; 
                unset($_SESSION['message']);
            ?>
        </div>
    <?php endif; ?>

    <div class="container mt-4">
    <div class="row">
        <div class="col text-end">
            <!-- Create Post Button -->
            <a href="/admin/posts/create" class="btn btn-success me-2">Create New Post</a>
            <!-- Create Category Button -->
            <a href="/admin/categories/create" class="btn btn-success">Create Categories</a>
        </div>
    </div>

    <?php foreach ($posts as $post): ?>
        <div class="mb-3 mt-2 card">
            <div class="card-body">
                <h2 class="card-title"><?php echo htmlspecialchars($post->title, ENT_QUOTES); ?></h2>
                <p class="card-text"><?php echo htmlspecialchars($post->content, ENT_QUOTES); ?></p>
                <a href="/admin/posts/show/<?php echo $post->id; ?>" class="btn btn-info btn-sm">View</a>
                <a href="/admin/posts/edit/<?php echo $post->id; ?>" class="btn btn-warning btn-sm">Edit</a>
                <button type="button" onclick="deletePost(<?php echo $post->id; ?>)" class="btn btn-danger btn-sm">Delete</button>
                </div>
                </div>
                <?php endforeach; ?>
                <!-- Pagination Controls -->
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                    <!--we loop through each page number-->
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <!--Check if the loop's current page number ($i e.g 3) is the same as the current page ($currentPage 3)-->
                            <!--If yes, then this is the current page, so mark it as 'active'-->
                            <!--If no, then it's just a regular page-->
                            <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                            <!-- returns the page full url e.g http://admin/posts/posts?page=2 -->
                                <a class="page-link" href="/admin/posts?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
<?php
$content = ob_get_clean(); // Store buffered content in $content
// Include the layout
include BASE_DIR . '/public/Layouts/layout.php'; ?>

<style>
.message-success {
color: green;
/* other styling */
}

.message-error {
    color: red;
    background-color: #ffd6d6;
    padding: 10px;
    border: 1px solid red;
    margin-bottom: 20px;
}
</style>


<script>
// JavaScript Timeout functionality for admin posts
window.onload = function() {
    setTimeout(function() {
        var messageElement = document.getElementById('message');
        if (messageElement) {
            messageElement.style.display = 'none';
        }
    }, 5000); // 5000 milliseconds = 5 seconds
};
</script>