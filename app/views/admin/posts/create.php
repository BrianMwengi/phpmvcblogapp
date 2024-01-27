<!-- admin/posts/create.php -->
<div>
    <!-- View all Post Button -->
    <div style="text-align: right; margin-bottom: 20px;">
        <a href="/admin/posts/">View Posts</a>
    </div>

    <h1>Create Post</h1>
        <!-- Validation error messages -->
        <?php if (isset($_SESSION['form_errors'])): ?>
            <div class="alert alert-danger">
                <?php foreach ($_SESSION['form_errors'] as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
                <?php unset($_SESSION['form_errors']); ?>
            </div>
        <?php endif; ?>
    <form method="POST" action="/admin/posts/store" enctype="multipart/form-data">
        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title">
        </div>
        
        <div>
            <label for="content">Content:</label>
            <textarea id="content" name="content"></textarea>
        </div>
        
        <div>
            <label for="image">Image:</label>
            <input type="file" id="image" name="image">
        </div>

        <!-- Populate Categories in this view -->
        <div>
            <label for="category_id">Category:</label>
            <select id="category_id" name="category_id">
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>


        <button type="submit">Create Post</button>
    </form>
</div>
