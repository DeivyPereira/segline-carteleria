<?php error_reporting(0); ?>

<link rel="stylesheet" href="<?= BASE_URL; ?>assets/bootstrap.min.css">
<script src="<?= BASE_URL; ?>assets/jquery.min.js"></script>

<?php
$type1 = substr($grid1, -4);
$type2 = substr($grid2, -4);
$type3 = substr($grid3, -4);
?>


<?php if ($type1 == ".mp4") : ?>
    <div class="content">
        <video ref="video" class="video" loop muted autoplay id="video">
            <source src="<?= BASE_URL; ?>uploads/<?= $grid1; ?>" type="video/mp4">
        </video>
    </div>
<?php else : ?>
    <div id="grid2" class="content" style="background-image: url('<?= BASE_URL; ?>uploads/<?= $grid1; ?>'); background-size: cover; background-position: center; height:33.3vh;"></div>
<?php endif; ?>

<?php if ($type2 == ".mp4") : ?>
    <div class="content">
        <video ref="video" class="video" loop muted autoplay id="video">
            <source src="<?= BASE_URL; ?>uploads/<?= $grid2; ?>" type="video/mp4">
        </video>
    </div>
<?php else : ?>
    <div id="grid2" class="content" style="background-image: url('<?= BASE_URL; ?>uploads/<?= $grid2; ?>'); background-size: cover; background-position: center; height:33.3vh;"></div>
<?php endif; ?>

<?php if ($type3 == ".mp4") : ?>
    <div class="content" style="background: #000;">
        <video ref="video" class="video" loop muted autoplay id="video">
            <source src="<?= BASE_URL; ?>uploads/<?= $grid3; ?>" type="video/mp4">
        </video>
    </div>
<?php else : ?>
    <div id="grid2" class="content" style="background-image: url('<?= BASE_URL; ?>uploads/<?= $grid3; ?>'); background-size: cover; background-position: center; height:33.3vh;"></div>
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

<input type="hidden" name="uuid" value="<?= $uuid; ?>">
<input type="hidden" name="url" value="<?= BASE_URL; ?>">
<script>
    setTimeout(() => {
        $('[id="video"]').prop('muted', false);
    }, 500);

    var sec = 900000;

    var myVar = setInterval(check, 300000);

    var url = $('[name="url"]').val() + "check-public";

    function check() {
        $.ajax({
            url: url,
            data: {
                uuid: $('[name="uuid"]').val()
            },
            method: "post",
            dataType: "json",
            success(response) {
                if (response.expire) {
                    location.reload(true);
                }
            }
        })
    }
</script>