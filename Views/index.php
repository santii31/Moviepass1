<main>
    <section id="now-playing">
        <div class="container">
            <h3 class="section-title">Now playing</h3>
            <hr>

            <br>
            <br>
            <br>

            <div class="glider-contain multiple">
                <button class="glider-prev">
                    <i class="icon ion-md-arrow-dropleft"></i>
                </button>

                <div class="glider">
                    <?php foreach ($movies as $movie): ?>
                    <figure>
                        <a href="<?= FRONT_ROOT ?>movie/showMovie/<?= $movie->getId(); ?>">
                            <img src="<?= IMG_PATH_TMDB . $movie->getPosterPath(); ?>" alt="Poster path">
                            <h2><?= $movie->getTitle(); ?></h2>
                        </a>
                    </figure>
                    <?php endforeach; ?>
                </div>

                <button class="glider-next">
                    <i class="icon ion-md-arrow-dropright"></i>
                </button>

                <div id="dots" class="glider-dots"></div>
            </div>

            <a class="more-movies" href="<?= FRONT_ROOT ?>movie/nowPlaying">
                <i class="icon ion-md-add"></i>
                Movies
            </a>

        </div>
    </section>

    <section id="coming-soon" class="s-2">
        <div class="container">
            <h3 class="section-title">Coming soon</h3>
            <hr>

            <br>
            <br>
            <br>

            <div class="glider-contain multiple">
                <button class="glider-prev glider2-prev">
                    <i class="icon ion-md-arrow-dropleft"></i>
                </button>

                <div class="glider2">
                    <?php foreach ($upcoming as $movie): ?>
                    <figure>
                        <a href="#">
                            <img src="<?= IMG_PATH_TMDB . $movie->getPosterPath(); ?>" alt="Poster Path">
                            <h2><?= $movie->getTitle(); ?></h2>
                        </a>
                    </figure>
                    <?php endforeach; ?>
                </div>

                <button class="glider-next glider2-next">
                    <i class="icon ion-md-arrow-dropright"></i>
                </button>

                <div id="dots2" class="glider-dots"></div>
            </div>

            <a class="more-movies" href="<?= FRONT_ROOT ?>movie/comingSoon">
                <i class="icon ion-md-add"></i>
                Movies
            </a>

        </div>
    </section>

    <div class="parallax-banner">
        <h4>
            <i class="icon ion-md-globe"></i>    
            Discover the best experiences in cinemas
        </h4>
    </div>

    <section>
        <div class="container">
            <h3 class="section-title">Search movies</h3>
            <hr>

            <div>
                <form action="<?= FRONT_ROOT ?>movie/searchMovie" method="post" class="search-container">
                    <label>
                        <input type="text" name="title" placeholder="Insert the name of the movie">
                    </label>
                    <button class="btn-l" type="submit">
                        <i class="icon ion-md-search"></i>
                    </button>
                </form>
            </div>

        </div>
    </section>
</main>
