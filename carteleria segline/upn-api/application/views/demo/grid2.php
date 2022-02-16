<?php error_reporting(0); ?>

<link rel="stylesheet" href="<?= BASE_URL; ?>assets/bootstrap.min.css">
<script src="<?= BASE_URL; ?>assets/jquery.min.js"></script>

<?php
$type1 = substr($data['grid1'], -4);
$type2 = substr($data['grid2'], -4);
$type3 = substr($data['grid3'], -4);
?>


<?php if ($type1 == ".mp4") : ?>
    <div class="content">
        <video ref="video" class="video" loop muted autoplay id="video">
            <source src="<?= BASE_URL; ?>uploads/<?= $data['grid1']; ?>" type="video/mp4">
        </video>
    </div>
<?php else : ?>
    <div id="grid2" class="content" style="background-image: url('<?= BASE_URL; ?>uploads/<?= $data['grid1']; ?>'); background-size: cover; background-position: center; height:33.3vh;"></div>
<?php endif; ?>

<?php if ($type2 == ".mp4") : ?>
    <div class="content">
        <video ref="video" class="video" loop muted autoplay id="video">
            <source src="<?= BASE_URL; ?>uploads/<?= $data['grid2']; ?>" type="video/mp4">
        </video>
    </div>
<?php else : ?>
    <div id="grid2" class="content" style="background-image: url('<?= BASE_URL; ?>uploads/<?= $data['grid2']; ?>'); background-size: cover; background-position: center; height:33.3vh;"></div>
<?php endif; ?>

<?php if ($type3 == ".mp4") : ?>
    <div class="content" style="background: #000;">
        <video ref="video" class="video" loop muted autoplay id="video">
            <source src="<?= BASE_URL; ?>uploads/<?= $data['grid3']; ?>" type="video/mp4">
        </video>
    </div>
<?php else : ?>
    <div id="grid2" class="content" style="background-image: url('<?= BASE_URL; ?>uploads/<?= $data['grid3']; ?>'); background-size: cover; background-position: center; height:33.3vh;"></div>
<?php endif; ?>


<style>
    .content {
        width: 100%;
        height: 33.3vh;
        margin: 0;
        padding: 0;
        overflow: hidden;
    }

    .video {
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