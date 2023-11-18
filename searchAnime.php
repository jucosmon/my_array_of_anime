<!DOCTYPE html>
<html>

<head>
    <title>Anime Search</title>
</head>

<body>
    <h1>Anime Search</h1>
    <form method="GET">
        <input type="text" name="title" placeholder="Enter anime title">
        <button type="submit">Search</button>
    </form>

    <h2>Search Results:</h2>
    <div id="results-container">
        <?php
        // Check if the form has been submitted
        if (isset($_GET['title'])) {
            $animeTitle = $_GET['title'];
            $animeListUrl = 'https://api.jikan.moe/v4/anime';
            $animeListResponse = file_get_contents($animeListUrl);
            $animeList = json_decode($animeListResponse, true);

            $filteredAnime = array_filter($animeList['data'], function ($anime) use ($animeTitle) {
                return isset($anime['title']) && stripos($anime['title'], $animeTitle) !== false;
            });

            if (empty($filteredAnime)) {
                echo '<p>No results found.</p>';
            } else {
                foreach ($filteredAnime as $anime) {
                    echo '<div>';
                    echo '<h3>' . $anime['title'] . '</h3>';
                    echo '<p>Episodes: ' . $anime['episodes'] . '</p>';
                    echo '<p>Rating: ' . $anime['rating'] . '</p>';
                    echo '<p>' . $anime['synopsis'] . '</p>';
                    if (isset($anime['genres']) && is_array($anime['genres'])) {
                        $genres = array_column($anime['genres'], 'name');
                        echo '<p>Genre: ' . implode(', ', $genres) . '</p>';
                    }

                }
            }
        }
        ?>
    </div>
</body>

</html>