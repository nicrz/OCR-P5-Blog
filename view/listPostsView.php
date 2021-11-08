 <?php require('base.php'); ?>
        <header class="masthead" style="background-image: url('assets/img/home-bg.jpg')">
            <div class="container position-relative px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <div class="site-heading">
                            <h1>Blog</h1>
                            <span class="subheading">Tous les articles rédigés par moi-même sur cette page</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main Content-->
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">

                    <?php
                        while ($data = $posts->fetch())
                        {
                    ?>
                    <!-- Post preview-->
                    <div class="post-preview">
                        <a href="#">
                            <h2 class="post-title"><?= htmlspecialchars($data['titre']) ?></h2>
                            <h3 class="post-subtitle"><?= htmlspecialchars($data['chapo']) ?></h3>
                        </a>
                        <p class="post-meta">
                            Posté par
                            <a href="#"><?= $data['prenom'] ?> <?= $data['nom'] ?></a>
                            le <?= $data['maj'] ?>
                        </p>
                    </div>
                    <!-- Divider-->
                    <hr class="my-4" />

                    <?php
                    }
                    $posts->closeCursor();
                    ?>
                  
                </div>
            </div>
        </div>
<?php require('footer.php'); ?>