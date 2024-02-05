<?php

class ArticleRepository
{

	private string $filename;

	public function __construct(string $theFilename)
	{
		$this->filename = $theFilename;
	}

	/**
	 * @return Article[]
	 */
	public function getAllArticles(): array
	{
		if (!file_exists($this->filename)) {
			return [];
		}
		$fileContents = file_get_contents($this->filename);
		if (!$fileContents) {
			return [];
		}
		$decodedArticles = json_decode($fileContents, true);
		if (json_last_error() !== JSON_ERROR_NONE) {
			return [];
		}
		$articles = [];
		foreach ($decodedArticles as $decodedArticle) {
			$articleId = time();
			$articles[] = (new Article($articleId))->fill($decodedArticle);
		}
		return $articles;
	}

	/**
	 *
	 */
    public function getArticleById(int $id): Article|null
    {
        $articles = $this->getAllArticles();
        foreach ($articles as $article) {
            if ($article->getId() === $id) {
                return $article;
            }
        }
        return null;
    }

	/**
	 * @param int $id
	 */
	public function deleteArticleById(int $id): void
	{
		// Get all articles
        $articles = $this->getAllArticles();

        // Find the article by Id
        foreach($articles as $key => $article){
            if($article->getId() === $id){
                // Remove the article from the array
                unset($articles[$key]);

                // Encode and save to the file
                $encodedArticles = json_encode(array_values($articles), JSON_PRETTY_PRINT);
                file_put_contents($this->filename, $encodedArticles);

                return;
            }
        }
	}

	/**
	 * @param Article $article
	 */
	public function saveArticle(Article $article): void
	{
		// Get existing articles
        $articles = $this->getAllArticles();

        // Check if the article already exists based on Id
        foreach($articles as $key => $existingArticle){
            if($existingArticle->getId() === $article->getId()){
                // Update the existing article with the new details
                $articles[$key] = $article;

                // Encode and save to file
                $encodedArticles = json_encode(array_values($articles), JSON_PRETTY_PRINT);
                file_put_contents($this->filename, $encodedArticles);

                return;
            }
        }

        // If the article doesn't exist, add it to the array
        $articles[] = $article;

        // Encode and save to file
        $encodedArticles = json_encode(array_values($articles), JSON_PRETTY_PRINT);
        file_put_contents($this->filename, $encodedArticles);
	}

	/**
	 * @param int $id
	 * @param Article $updatedArticle
	 */
	public function updateArticle(int $id, Article $updatedArticle): void
	{
		// Get all articles
        $articles = $this->getAllArticles();

        // Find the article by Id
        foreach($articles as $key => $article){
            if($article->getId() === $id){
                // Update the article in the array
                $articles[$key] = $updatedArticle;

                // Encode and save to file
                $encodedArticles = json_encode(array_values($articles));
                file_put_contents($this->filename, $encodedArticles);

                return;
            }
        }

	}
}
