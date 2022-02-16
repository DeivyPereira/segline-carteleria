<?php error_reporting(0); ?>

<link rel="stylesheet" href="<?= BASE_URL; ?>assets/bootstrap.min.css">
<script src="<?= BASE_URL; ?>assets/jquery.min.js"></script>

<?php
$type1 = substr($data['grid1'], -4);
$type2 = substr($data['grid2'], -4);
$type3 = substr($data['grid3'], -4);
?>


<div class="row no-gutters">
    <?php if ($type1 == ".mp4") : ?>
        <div>
            <video ref="videoLeft" class="videoLeft" loop muted autoplay id="video">
                <source src="<?= BASE_URL; ?>uploads/<?= $data['grid1']; ?>" type="video/mp4">
            </video>
        </div>
        <div class="col-6" style="height: 50vh"></div>
    <?php else : ?>
        <div class="col-6" id="grid2" style="background-image: url('<?= BASE_URL; ?>uploads/<?= $data['grid1']; ?>'); background-size: cover; background-position: center; height:50vh;"></div>
    <?php endif; ?>

    <?php if ($type2 == ".mp4") : ?>
        <div>
            <video ref="video" class="videoRight" loop muted autoplay id="video">
                <source src="<?= BASE_URL; ?>uploads/<?= $data['grid2']; ?>" type="video/mp4">
            </video>
        </div>
        <div class="col-6" style="height: 50vh"></div>
    <?php else : ?>
        <div class="col-6" id="grid2" style="background-image: url('<?= BASE_URL; ?>uploads/<?= $data['grid2']; ?>'); background-size: cover; background-position: center; height:50vh;"></div>
    <?php endif; ?>

    <?php if ($type3 == ".mp4") : ?>
        <div class="video-content">
            <video ref="video" class="videoBottom" loop muted autoplay id="video">
                <source src="<?= BASE_URL; ?>uploads/<?= $data['grid3']; ?>" type="video/mp4">
            </video>
        </div>
    <?php else : ?>
        <div class="col-12" id="grid2" style="background-image: url('<?= BASE_URL; ?>uploads/<?= $data['grid3']; ?>'); background-size: cover; background-position: center; height:50vh;"></div>
    <?php endif; ?>
</div>


<style>
    .video-content {
        overflow: hidden;
        position: absolute;
        top: 50%;
        left: 0;
        transform: translate(0, 0);
        width: 100%;
        height: 50vh;
    }

    .videoLeft {
        background: #000;
        min-width: 50%;
        min-height: 50vh;
        width: 50%;
        height: auto;
        position: fixed;
        top: 0;
        left: 0;
        transform: translate(0, 0);
    }

    .videoRight {
        background: #000;
        min-width: 50%;
        min-height: 50vh;
        width: 50%;
        height: auto;
        position: fixed;
        top: 0;
        right: 0;
        transform: translate(0, 0);
    }

    .videoBottom {
        width: 100%;
        position: relative;
        top: 50%;
        left: 0;
        transform: translate(0, -50%);
    }
</style>

<script>
    setTimeout(() => {
        $('[id="video"]').prop('muted', false);
    }, 500);
</script>