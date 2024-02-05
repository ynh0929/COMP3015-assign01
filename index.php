<?php
require_once 'src/ArticleRepository.php';
require_once 'src/Models/Article.php';

$articleRepository = new ArticleRepository('articles.json');
$articles = $articleRepository->getAllArticles();
?>

<!doctype html>
<html lang="en">


<?php require_once 'layout/header.php' ?>

<body>
    <?php require_once 'layout/navigation.php' ?>

    <div class="mx-auto max-w-5xl sm:px-6 lg:px-8">

        <h2 id="page-title" class="text-4xl text-center font-semibold text-indigo-700 mt-10">Articles</h2>
        <br>
        <div class="overflow-hidden">
            <ul role="list">

                <?php foreach ($articles as $article) : ?>
                    <!-- display your articles here -->
                    <li class="mb-4">
                        <div class="bg-white shadow overflow-hidden sm:rounded-md p-4">
                            <div class="flex items-center">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    <a href="<?php echo htmlspecialchars($article->getUrl()); ?>" target="_blank" class="text-indigo-500 hover:text-indigo-700"><?php echo $article->getTitle(); ?></a>
                                </h3>
                                <span class="ml-auto">
                                     <a href="update_article.php?id=<?php echo $article->getId(); ?>" class="text-yellow-500 ml-2">Edit</a>
                                    <button onclick="confirmDelete(<?php echo $article->getId(); ?>)" class="text-yellow-500 ml-2">Delete</button>
                                </span>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>

            </ul>
        </div>

    </div>


    <script>
        function confirmDelete(articleId) {
            var confirmDelete = confirm("Are you sure you want to delete this article?");
            if (confirmDelete) {
                window.location.href = "delete_article.php?id=" + articleId;
            } else {
            }
        }
    </script>

</body>

</html>