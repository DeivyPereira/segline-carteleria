<?php error_reporting(0); ?>
<link rel="stylesheet" href="<?= BASE_URL; ?>assets/bootstrap.min.css">
<script src="<?= BASE_URL; ?>assets/jquery.min.js"></script>

<?php
$type1 = substr($data['grid1'], -4);
$type2 = substr($data['grid2'], -4);
?>

<div style="height: 100vh">
    <div class="row no-gutters">

        <?php if ($type1 == ".mp4") : ?>
            <div style="height: 100vh; background: #000">
                <video ref="video" class="video" loop muted autoplay id="video">
                    <source src="<?= BASE_URL; ?>uploads/<?= $data['grid1']; ?>" type="video/mp4">
                </video>
            </div>
            <div class="col-6"></div>
        <?php else : ?>
            <div class="col-6" id="grid2" style="background-image: url('<?= BASE_URL; ?>uploads/<?= $data['grid1']; ?>'); background-size: cover; background-position: center; height:100vh;"></div>
        <?php endif; ?>

        <?php if ($type2 == ".mp4") : ?>
            <div style="height: 100vh; background: #000;">
                <video ref="video" class="video1" loop muted autoplay id="video">
                    <source src="<?= BASE_URL; ?>uploads/<?= $data['grid2']; ?>" type="video/mp4">
                </video>
            </div>
        <?php else : ?>
            <div class="col-6" id="grid2" style="background-image: url('<?= BASE_URL; ?>uploads/<?= $data['grid2']; ?>'); background-size: cover; background-position: center; height:100vh;"></div>
        <?php endif; ?>

    </div>
</div>

<style>
    .video {
        min-width: 50%;
        min-height: 100vh;
        width: 50%;
        height: auto;
        position: fixed;
        top: 50%;
        left: 0;
        transform: translate(0, -50%);
    }

    .video1 {
        min-width: 50%;
        min-height: 100vh;
        width: 50%;
        height: auto;
        position: fixed;
        top: 50%;
        right: 0;
        transform: translate(0, -50%);
    }
</style>

<script>
    setTimeout(() => {
        $('[id="video"]').prop('muted', false);
    }, 500);
</script>