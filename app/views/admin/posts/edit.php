<div>
    <?php if ($post === null): ?>
        <div>Post not found</div>
        <?php return; ?>
        <?php endif; ?>
        <!-- Validation error messages -->
        <?php if (isset($_SESSION['form_errors'])): ?>
        <div class="alert alert-danger">
            <?php foreach ($_SESSION['form_errors'] as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
            <?php unset($_SESSION['form_errors']); ?>
        </div>
       <?php endif; ?>
      <form method="POST" action="/admin/posts/update/<?php echo $post->id ?>" enctype="multipart/form-data" style="margin-bottom: 20px;">
        <input type="hidden" name="id" value="<?php echo $post->id ?>">
        <div style="margin-bottom: 20px;">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post->title, ENT_QUOTES); ?>">
        </div>
        <div style="margin-bottom: 20px;">
            <label for="content">Content</label>
            <textarea id="content" name="content"><?php echo htmlspecialchars($post->content, ENT_QUOTES); ?></textarea>
        </div>

        <div>
            <label for="image">Image</label>
            <input type="file" id="image" name="image">
            <?php if (!empty($post->image)): ?>
            <img src="/images/<?php echo htmlspecialchars($post->image, ENT_QUOTES); ?>" alt="Post Image" style="max-width: 200px;">
            <?php endif; ?>
        </div>

        <!-- Populate Categories in this view -->
        <div>
            <label for="category_id">Category:</label>
            <select id="category_id" name="category_id">
            <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category->id; ?>" <?php echo $category->id == $post->category_id ? 'selected' : ''; ?>>
            <?php echo $category->name; ?>
            </option>
            <?php endforeach; ?>
            </select>
        </div>
        <button type="submit">Update Post</button>
    </form>
</div>
