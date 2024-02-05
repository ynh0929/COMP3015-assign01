<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once 'src/ArticleRepository.php';
require_once 'src/Models/Article.php';

$articleRepository = new ArticleRepository('articles.json');

// Check if an article ID is provided in the query parameters, and it's a valid integer
$articleId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// Debugging statement to check the value of $articleId
var_dump($articleId);

if ($articleId !== false && $articleId !== null) {
    // Get the article by ID
    var_dump($articleId); // Debugging statement to check the value
    $article = $articleRepository->getArticleById($articleId);

    // Check if the article is found
    if ($article !== null) {
        // Delete the article by ID
        $articleRepository->deleteArticleById($articleId);

        // Redirect back to the index page with a success message
        $successMessage = "Article deleted";
        header("Location: index.php?success=" . urlencode($successMessage));
        exit();
    } else {
        $errorMessage = "Article not found";
        header("Location: index.php?error=" . urlencode($errorMessage));
        exit();
    }
} else {
    $errorMessage = "Invalid request";
    exit();
}
?>
