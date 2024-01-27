<div>
    <form method="POST" action="/admin/categories/update/<?php echo $category->id; ?>" style="margin-bottom: 20px;">
        <input type="hidden" name="id" value="<?php echo $category->id; ?>">
        <div style="margin-bottom: 20px;">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($category->name, ENT_QUOTES); ?>">
        </div>
        <!-- Add more input fields for other category properties... -->
        <button type="submit">Update</button>
    </form>
</div>
