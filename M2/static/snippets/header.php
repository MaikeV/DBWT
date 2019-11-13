<header class="sticky-top w-100">
    <div class="container-fluid bg-primary mw-100 ">
        <div class="row align-items-end justify-content-center p-2">
            <div class="col-2 text-left">
                <h1 class="text-warning">e-Mensa</h1>
            </div>
            <div class="col-2 text-center border-right border-white">
                <?php if (basename($_SERVER['PHP_SELF']) == 'Start.php') : ?>
                    <a class="text-dark font-weight-bolder">Start</a>
                <?php else : ?>
                    <a href="Start.php" class="text-white font-weight-bolder">Start</a>
                <?php endif; ?>
            </div>
            <div class="col-2 text-center border-right border-white">
                <?php if (basename($_SERVER['PHP_SELF']) == 'Mahlzeiten.php') : ?>
                    <a class="text-dark font-weight-bolder">Mahlzeiten</a>
                <?php else : ?>
                    <a href="Mahlzeiten.php" class="text-white font-weight-bolder">Mahlzeiten</a>
                <?php endif; ?>
            </div>
            <div class="col-2 text-center border-right border-white">
                <?php if (basename($_SERVER['PHP_SELF']) == 'Bestellungen.php') : ?>
                    <a class="text-dark font-weight-bolder">Bestellungen</a>
                <?php else : ?>
                    <a href="Bestellungen.php" class="text-white font-weight-bolder">Bestellungen</a>
                <?php endif; ?>
            </div>
            <div class="col-2 text-center">
                <a target="_blank"  href="https://www.fh-aachen.de/" rel="noopener" class="text-white font-weight-bolder">FH-Aachen</a>
            </div>
            <div class="col-2 text-center">
                <form action="http://www.google.de/search" method="get" target="_blank">
                    <input type="search" id="searchBar" name="q" class="rounded-pill" placeholder="Suchen...">
                    <input type="hidden" name="as_sitesearch" value="www.fh-aachen.de">
                </form>
            </div>
        </div>
    </div>
    <hr>
</header>