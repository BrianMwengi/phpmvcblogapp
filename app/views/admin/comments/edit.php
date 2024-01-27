<?php
if (!$comment) {
    echo "Comment not found";
    return;
}
?>
<form method="POST" action="/admin/comments/update/<?php echo $comment->id; ?>">
    <input type="hidden" name="id" value="<?php echo $comment->id; ?>">
    <input type="hidden" name="post_id" value="<?php echo $comment->post_id; ?>">

    <label for="content">Comment Content</label>
    <textarea id="content" name="content"><?php echo htmlspecialchars($comment->content, ENT_QUOTES); ?></textarea>
    
    <button type="submit">Update Comment</button>
</form>