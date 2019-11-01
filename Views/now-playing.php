<main>
    <div class="container filter-container">
        <h4>Do you want to filter the list of movies?</h4>

        <form class="filter-form" action="" method="POST">
            <label>
                Category:
                <select name="category">
                <?php foreach ($genres as $genre): ?>
                    <option value="<?= $genre->getIdGenre(); ?>"><?= $genre->getName(); ?></option>
                <?php endforeach; ?>                
                </select>
            </label>
            <label>
                Date:
                <input type="date" name="date">
            </label>

            <button type="submit" class="btn-f">
                <i class="icon ion-md-search"></i>
                Filter
            </button>
        </form>
    </div>

    <?php foreach ($movies as $movie): ?>
    <div class="container movie-container">
        <div class="movie-img">
            <a href="<?= FRONT_ROOT ?>movie/showMovie/?id=<?= $movie->getId() ?>">
                <img src="<?= IMG_PATH_TMDB . $movie->getPosterPath() ?>" alt="">
            </a>
        </div>
        <div class="movie-info">
            <h3><?= $movie->getTitle() ?></h3>
            <p>
                <i class="icon ion-md-star"></i>
                <?= $movie->getVoteAverage() ?>
            </p>
            <p><?= $movie->getOverview() ?></p>
        </div>
        <div class="movie-cta">
            <a class="btn-l" href="<?= FRONT_ROOT ?>movie/showMovie/?id=<?= $movie->getId() ?>">  
                <i class="icon ion-md-add"></i>More info
            </a>
        </div>
    </div>
    <?php endforeach; ?>

</main>
