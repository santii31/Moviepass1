<main>
    <div class="container filter-container">
        <h4>Do you want to filter the list of movies?</h4>

        <form class="filter-form" action="<?= FRONT_ROOT ?>movie/filterMovies" method="POST">
            <label>
                Genre:
                <select name="category">
                <option value="" selected>All</option>
                <?php foreach ($genres as $genre): ?>
                    <option value="<?= $genre->getIdGenre(); ?>">
                        <?= $genre->getName(); ?>
                    </option>
                <?php endforeach; ?>                
                </select>
            </label>
            <label>
                Date of show:
                <input type="date" name="date">
            </label>

            <button type="submit" class="btn-f">
                <i class="icon ion-md-search" style="font-size:2rem;"></i>                
            </button>
        </form>
    </div>

    <?php if ($alert != null): ?>
    <div class="container">
        <h3 class="info">
            <?= $alert; ?>
            <i class="icon ion-md-sad"></i>
        </h3>
    </div>
    <?php endif; ?>

    <?php foreach ($movies as $movie): ?>
    <div class="container movie-container">
        <div class="movie-img">
            <a href="<?= FRONT_ROOT ?>movie/showMovie/<?= $movie->getId(); ?>">
                <img src="<?= IMG_PATH_TMDB . $movie->getPosterPath(); ?>" alt="">
            </a>
        </div>
        <div class="movie-info">
            <h3><?= $movie->getTitle(); ?></h3>
            <p>
                <i class="icon ion-md-star"></i>
                <?= $movie->getVoteAverage(); ?>
            </p>
            <p class="overview-text"><?= $movie->getOverview(); ?></p>
        </div>
        <div class="movie-cta">
            <a class="btn-l" href="<?= FRONT_ROOT ?>movie/showMovie/<?= $movie->getId(); ?>">  
                <i class="icon ion-md-add"></i>More info
            </a>
        </div>
    </div>
    <?php endforeach; ?>

</main>
