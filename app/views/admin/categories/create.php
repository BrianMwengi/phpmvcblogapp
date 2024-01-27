<div>
    <!-- View Category Button -->
    <div style="text-align: right; margin-bottom: 20px;">
        <a href="/admin/categories/">View Categories</a>
    </div>
    <form method="POST" action="/admin/categories/store" style="margin-bottom: 20px;">
        <div style="margin-bottom: 20px;">
            <label for="name">Category Name</label>
            <input type="text" id="name" name="name">
        </div>
        <button type="submit">Create Category</button>
    </form>
</div>
