<div>
  <!-- Display message -->
    <?php if (isset($_SESSION['message'])): ?>
        <div id="message" class="<?php echo strpos($_SESSION['message'], 'error') !== false ? 'message-error' : 'message-success' ?> text-center">
            <?php 
                echo $_SESSION['message']; 
                unset($_SESSION['message']);
            ?>
        </div>
    <?php endif; ?>
      <div style="text-align: right;">
        <!-- Create Post Button -->
        <a href="/admin/posts/create">Create New Post</a>
        <a href="/admin/categories/create">Create Categories</a>
    </div>

    <?php foreach ($posts as $post): ?>
        <div style="margin-bottom: 20px; margin-top: 20px;">
            <div>
                <h2><?php echo htmlspecialchars($post->title, ENT_QUOTES); ?></h2>
                <p><?php echo htmlspecialchars($post->content, ENT_QUOTES); ?></p>
                <a href="/admin/posts/show/<?php echo $post->id; ?>">View</a>
                <a href="/admin/posts/edit/<?php echo $post->id; ?>">Edit</a>
                <p><strong>Category:</strong> <?php echo $post->category_name ? htmlspecialchars($post->category_name, ENT_QUOTES) : 'No category'; ?></p>
                <!-- Delete Post -->
                <form action="/admin/posts/delete/<?php echo $post->id; ?>" method="POST" style="display: inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit">Delete</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
    <!-- Pagination Controls -->
    <nav aria-label="Page navigation">
        <ul style="list-style: none; padding: 0;">
            <!--we loop through each page number-->
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <!--Check if the loop's current page number ($i, e.g., 3) is the same as the current page ($currentPage, 3)-->
                <!--If yes, then this is the current page, so we could style it differently if needed-->
                <li style="<?php echo $i == $currentPage ? 'font-weight: bold;' : ''; ?>">
                    <!-- returns the page full URL e.g., http://admin/posts?page=2 -->
                    <a href="/admin/posts?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>

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
