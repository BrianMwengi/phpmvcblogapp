<?php 
// Generate the specific content for this page
ob_start(); // Start output buffering
foreach ($posts as $post):
    ?>
   <div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <h2 class="card-header"><?php echo htmlspecialchars($post->title, ENT_QUOTES); ?></h2>
                <div class="card-body">
                <!-- Check if the post has an image and display it -->
                    <?php if ($post->image): ?>
                        <img src="/images/<?php echo htmlspecialchars($post->image, ENT_QUOTES); ?>" alt="Post Image" class="img-fluid mb-3">
                    <?php endif; ?>
                    <p class="card-text"><?php echo htmlspecialchars($post->content, ENT_QUOTES); ?></p>
                    <!-- Check if category data is available -->
                    <p class="card-text"><strong>Category:</strong> <?php echo $post->category_name ? htmlspecialchars($post->category_name, ENT_QUOTES) : 'No category'; ?></p>
                    </div>
                    <div class="card-footer text-muted">
                        <a href="/posts/show/<?php echo $post->id; ?>" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        </div>
    <hr>
<?php endforeach ?>

<!-- Pagination Controls -->
<nav aria-label="Page navigation">
      <ul class="pagination">
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
              <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                  <a class="page-link" href="/posts?page=<?php echo $i; ?>"><?php echo $i; ?></a>
              </li>
          <?php endfor; ?>
      </ul>
   </nav>
<?php
$content = ob_get_clean(); // Store buffered content in $content

// Include the layout
include BASE_DIR . '/public/Layouts/layout.php'; ?>






