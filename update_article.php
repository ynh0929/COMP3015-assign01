<?php

require_once 'src/ArticleRepository.php';
require_once 'src/Models/Article.php';
require_once 'helpers/helpers.php';

$articleRepository = new ArticleRepository('articles.json');

// Check if an article ID is provided in the query parameters and it's a valid integer
$articleId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($articleId !== false) {
    // Get the article by ID
    $article = $articleRepository->getArticleById($articleId);

    // Check if the article exists before deletion
    if ($article !== null) {
        // Check if it's a POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and process form data
            $title = $_POST['title'] ?? '';
            $url = $_POST['link'] ?? '';

            // Validate form data
            if(empty($url) && empty($title)){
                header("Location: update_article.php?id=$articleId&error=Title and URL cannot be empty");
                exit();
            }
            if (!validURL($url)){
                header("Location: update_article.php?id=$articleId&url_error=Invalid url");

                exit();
            }
            if(!validTitle($title)){
                header("Location: update_article.php?id=$articleId&title_error=Title should be at least 3 characters");
                exit();
            }

            // If there are no validation errors, proceed with saving the article
            if (!empty($title) && filter_var($url, FILTER_VALIDATE_URL)) {
                // Update the article details
                $article->setTitle($title);
                $article->setUrl($url);

                // Save the updated article
                $articleRepository->updateArticle($articleId, $article);

                // Redirect to the index page after update
                $successMessage = "Article edited successfully!";
                header("Location: index.php?success=" . urlencode($successMessage));
                exit();
            }
        }
        // Display the form with pre-populated values
        renderEditForm($article);
    }
}
function renderEditForm(Article $article): void
{
    // HTML form with pre-populated values
    // You can use $article->getTitle() and $article->getUrl() to populate the input fields
    ?>
    <!DOCTYPE html>
    <html lang="en">
     <?php require_once 'layout/header.php' ?>
     <body>
         <?php require_once 'layout/navigation.php' ?>

         <div class="mx-auto max-w-5xl sm:px-6 lg:px-8">
             <h2 id="page-title" class="text-3xl text-center font-semibold text-indigo-600 mt-10">Edit Article</h2>
            <br>
             <div class="overflow-hidden">
                 <form action="update_article.php?id=<?php echo $article->getId(); ?>" method="post">
                     <input type="hidden" name="id" value="<?php echo $article->getId(); ?>">
                     <div>
                         <span class="error"><?= isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '' ?></span>
                         <span class="error"><?= isset($_GET['title_error']) ? htmlspecialchars($_GET['title_error']) : '' ?></span>
                        <label for="title" class="block text-xl font-semibold leading-6 text-white">Title</label>
                        <div class="mt-2">
                            <input type="text" name="title" id="title" class="block w-full rounded-md border-0 py-1.5 text-gray-800 shadow-sm ring-1 ring-inset ring-white placeholder:text-gray-800 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" value="<?php echo htmlspecialchars($article->getTitle()); ?>">
                        </div>
                    </div>
                    <br>
                    <div>
                        <span class="error"><?= isset($_GET['url_error']) ? htmlspecialchars($_GET['url_error']) : '' ?></span>
                        <label for="link" class="block text-xl font-semibold leading-6 text-white">Link</label>

                        <div class="mt-2">
                            <input type="url" name="link" id="link" class="block w-full rounded-md border-0 py-1.5 text-gray-800 shadow-sm ring-1 ring-inset ring-white placeholder:text-gray-800 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" value="<?php echo htmlspecialchars($article->getUrl()); ?>">
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="text-indigo-500 font-medium border border-indigo-500 px-4 py-2 rounded-md">UPDATE</button>
                 </form>
            </div>
        </div>
     </body>
    </html>
    <style>
        span.error {
            color: red;
        }
    </style>
    <?php
}
?>
