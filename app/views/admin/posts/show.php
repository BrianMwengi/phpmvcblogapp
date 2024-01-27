<div>
    <!-- View all Post Button -->
    <div style="text-align: right; margin-bottom: 20px;">
        <a href="/admin/posts/">View Posts</a>
    </div>
    <h2><?php echo htmlspecialchars($post->title, ENT_QUOTES); ?></h2>
    <!-- Check if the post has an image and display it -->
    <?php if ($post->image): ?>
        <img src="/images/<?php echo htmlspecialchars($post->image, ENT_QUOTES); ?>" alt="Post Image" style="max-width: 200px;"> <!-- Small preview -->
    <?php endif; ?>
    <p><?php echo htmlspecialchars($post->content, ENT_QUOTES); ?></p>
    <?php if (!empty($comments)): ?>
    <h3>Comments</h3>
    <?php foreach ($comments as $comment): ?>
        <div class="mb-2">
            <p><?php echo htmlspecialchars($comment->content, ENT_QUOTES); ?></p>
            <a href="/admin/comments/edit/<?php echo $comment->id; ?>" class="btn btn-warning btn-sm">Edit</a>
            <form action="/admin/comments/delete/<?php echo $comment->id; ?>" method="POST" style="display: inline;">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit">Delete</button>
                </form>
        </div>
    <?php endforeach; ?>
    <?php else: ?>
        <p>No comments found in this post.</p>
    <?php endif; ?>
</div>
