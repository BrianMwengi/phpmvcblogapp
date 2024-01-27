<!-- show.php -->
<div>
    <div>
        <div>
            <h2><?php echo htmlspecialchars($post->title, ENT_QUOTES); ?></h2>
        </div>
        
        <div>
            <?php if ($post->image): ?>
                <img src="/images/<?php echo htmlspecialchars($post->image, ENT_QUOTES); ?>" alt="Post Image" class="img-fluid mb-3">
            <?php endif; ?>
        </div>

        <div>
            <p><?php echo htmlspecialchars($post->content, ENT_QUOTES); ?></p>
        </div>

        <div>
            <h3>Comments</h3>
            <?php foreach ($comments as $comment): ?>
                <div style="margin-bottom: 20px;">
                    <p><?php echo htmlspecialchars($comment->content, ENT_QUOTES); ?></p>
                </div>
            <?php endforeach; ?>

            <form action="/comments/store" method="post" style="margin-top: 20px;">
                <div style="margin-bottom: 20px;">
                    <label for="content">Content:</label>
                    <textarea id="content" name="content"></textarea>
                </div>
                <input type="hidden" name="post_id" value="<?php echo $post->id; ?>">
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
</div>
