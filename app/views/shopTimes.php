<?php  include BASE_PATH . 'app/controllers/shopTimesController.php' ?>

<head>
    <link rel="stylesheet" href="style.css">
</head>

<?php if($days) : ?>
    <div class="shop-times">
        <div class="shop-times__inner">
            <h2 class="shop-times__header">Opening Times</h2>
            <div class="shop-times__days">
                <?php foreach($days as $day) : ?>
                    <div class="shop-times__day <?= ($dayOpen == $day['name']) ? 'open' : ''?>">
                            <span class="shop-times__day-text"><?= $day['name'] ?></span>
                        <?php if($day['boolIsClosed'] != 1) : ?>
                            <span class="shop-times__time-start"><?= $day['startTime'] ?></span>-
                            <span class="shop-times__time-end"><?= $day['endTime'] ?></span>
                        <?php else : ?>
                            <span class="shop-times__day-closed">Closed</span>
                        <?php endif ?>
                    </div>
                <?php endforeach ?>
            </div>
            <?php if($nextOpening) : ?>
                <h3 class="shop-times__small-header">Next Opening:&nbsp;
                    <?= $nextOpening['name'] ?> -
                    <?= $nextOpening['startTime'] ?>
                </h3>
            <?php endif ?>
            <div class="shop-times__times">
                <p class="shop-times__office-time">Office Time: (<?= $officeTime ?>) <?= $officeTimezone ?></p>
                <p class="shop-times__local-time">Local Time:  (<?= $localTime ?>) <?= $localTimezone ?></p>
            </div>
        </div>
    </div>
<?php endif ?>

