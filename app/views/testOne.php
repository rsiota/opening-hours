<?php  include BASE_PATH . 'app/controllers/testOneController.php' ?>
<head>
    <link rel="stylesheet" href="style.css">
</head>

<?php if($days) : ?>
    <div class="test-one">
        <div class="test-one__inner">
            <h2 class="test-one__header">Opening Times</h2>
            <?php foreach($days as $day) : ?>
            <div class="test-one__day <?= ($dayOpen == $day['name']) ? 'open' : ''?>">
                    <span class="test-one__day-text"><?= $day['name'] ?></span>
                    <span class="test-one__time-start"><?= $day['startTime'] ?></span>-
                    <span class="test-one__time-end"><?= $day['endTime'] ?></span>
                </div>
            <?php endforeach ?>
        </div>
    </div>
<?php endif ?>

