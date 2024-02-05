<?php

require_once 'src/ArticleRepository.php';
require_once 'src/Models/Article.php';
require_once 'helpers/helpers.php';

$articleRepository = new ArticleRepository('articles.json');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and process form data
    $title = $_POST['title'] ?? '';
    $url = $_POST['link'] ?? '';

    // Validate form data
    if(empty($url) && empty($title)){
        header("Location: new_article.php?error=Title and URL cannot be empty");
        exit();
    }
    if (!validURL($url)){
        header("Location: new_article.php?url_error=Invalid url");
        exit();
    }
    if(!validTitle($title)){
        header("Location: new_article.php?title_error=Title should be at least 3 characters");
        exit();
    }

    // If there are no validation errors, proceed with saving the article
    if (!empty($title) && filter_var($url, FILTER_VALIDATE_URL)) {
        // Create a new article instance
        $newArticle = new Article(time());
        $newArticle->setTitle($title);
        $newArticle->setUrl($url);

        // Save the new article
        $articleRepository->saveArticle($newArticle);

        // Redirect to the index page after submission
        $successMessage = "Article submitted successfully!";
        header("Location: index.php?success=" . urlencode($successMessage));
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once 'layout/header.php' ?>
<body>
<?php require_once 'layout/navigation.php' ?>

<div class="mx-auto max-w-5xl sm:px-6 lg:px-8">

    <h2 id="page-title" class="text-3xl text-center font-semibold text-indigo-600 mt-10">New Article</h2>
    <br>
    <p>The new article page. Handle displaying the new article form and handling article submissions here.</p>
<br>
    <div class="overflow-hidden">
        <!-- New Article Form -->
        <form action="new_article.php" method="post">
            <div>
                <span class="error"><?= isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '' ?></span>
                <span class="error"><?= isset($_GET['title_error']) ? htmlspecialchars($_GET['title_error']) : '' ?></span>
                <label for="title" class="block text-xl font-semibold leading-6 text-white">Title</label>
                <div class="mt-2">
                    <input type="text" name="title" id="title" placeholder="Enter Title" class="block w-full rounded-md border-indigo-100 py-1.5 text-gray-800 shadow-sm ring-1 ring-inset ring-white placeholder:text-gray-800 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>
            <br>
            <div>
                <span class="error"><?= isset($_GET['url_error']) ? htmlspecialchars($_GET['url_error']) : '' ?></span>
                <label for="link" class="block text-xl font-semibold leading-6 text-white">Link</label>
                <div class="mt-2">
                    <input type="url" name="link" id="link" placeholder="Enter URL" class="block w-full rounded-md border-accent/10 py-1.5 text-gray-800 shadow-sm ring-1 ring-inset ring-white placeholder:text-gray-800 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>
            <br>
            <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">SUBMIT</button>
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
