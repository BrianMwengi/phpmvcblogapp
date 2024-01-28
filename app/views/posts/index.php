<?php foreach ($posts as $post): ?>
        <div style="margin-bottom: 20px; margin-top: 20px;">
            <div>
                <h2><?php echo htmlspecialchars($post->title, ENT_QUOTES); ?></h2>
                 <!-- Check if the post has an image and display it -->
                 <?php if ($post->image): ?>
                        <img src="/images/<?php echo htmlspecialchars($post->image, ENT_QUOTES); ?>" alt="Post Image">
                    <?php endif; ?>
                <p><?php echo htmlspecialchars($post->content, ENT_QUOTES); ?></p>
                <div>
                  <a href="/posts/show/<?php echo $post->id; ?>">View</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
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







