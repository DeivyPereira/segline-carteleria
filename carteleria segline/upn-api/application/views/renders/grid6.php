<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Render</title>
    <link rel="stylesheet" href="<?= BASE_URL; ?>assets/bootstrap.min.css" />

    <link rel="stylesheet" href="<?= BASE_URL; ?>assets/slick-theme.css" />
    <link rel="stylesheet" href="<?= BASE_URL; ?>assets/slick.css" />

    <style>
        .video {
            background: #000;
            min-width: auto;
            width: 100%;
            height: 60vh;
        }

        .video-slide {
            display: none;
        }

        .loader {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgb(40, 40, 40);
            z-index: 1000;
        }

        .lds-facebook {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
        }

        .lds-facebook div {
            display: inline-block;
            position: absolute;
            left: 8px;
            width: 16px;
            background: #fff;
            animation: lds-facebook 1.2s cubic-bezier(0, 0.5, 0.5, 1) infinite;
        }

        .lds-facebook div:nth-child(1) {
            left: 8px;
            animation-delay: -0.24s;
        }

        .lds-facebook div:nth-child(2) {
            left: 32px;
            animation-delay: -0.12s;
        }

        .lds-facebook div:nth-child(3) {
            left: 56px;
            animation-delay: 0;
        }

        @keyframes lds-facebook {
            0% {
                top: 8px;
                height: 64px;
            }

            50%,
            100% {
                top: 24px;
                height: 32px;
            }
        }

        .locate-middle {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .header {
            background: transparent;
            height: 10vh;
        }

        ul.timeline {
            list-style-type: none;
            position: relative;
        }

        ul.timeline:before {
            content: ' ';
            background: #d4d9df;
            display: inline-block;
            position: absolute;
            left: 29px;
            width: 2px;
            height: 100%;
            z-index: 400;
        }

        ul.timeline>li {
            margin: 20px 0;
            padding-left: 20px;
        }

        ul.timeline>li:before {
            content: ' ';
            background: white;
            display: inline-block;
            position: absolute;
            border-radius: 50%;
            border: 3px solid #22c0e8;
            left: 20px;
            width: 20px;
            height: 20px;
            z-index: 400;
        }

        .day {
            border-radius: 100%;
            background-color: #fdba30;
            width: 35px;
            height: 35px;
            padding: 5px;
            text-align: text-center;
            box-shadow: 1px 1px 5px lightgrey;
        }
    </style>
    <?php if ($border == 1) : ?>
        <style>
            body {
                background: #fdba30;
            }

            .content-top {
                background: #333;
                height: 60vh;
                width: 100%;
            }

            .content-bottom {
                height: 28vh;
                width: 100%;
            }

            .top {
                background: #fdba30;
                height: 60vh;
                padding: 1vh 5px;
            }

            .bottom {
                background: #fdba30;
                height: 28vh;
                padding: 1vh 5px;
            }
        </style>
    <?php endif; ?>
    <?php if ($border == 2) : ?>
        <style>
            body {
                background: #fdba30;
            }

            .content-top {
                background: #333;
                height: 60vh;
                width: 100%;
            }

            .content-bottom {
                height: 38vh;
                width: 100%;
            }

            .top {
                background: #fdba30;
                height: 60vh;
                padding: 1vh 5px;
            }

            .bottom {
                background: #fdba30;
                height: 38vh;
                padding: 1vh 5px;
            }
        </style>
    <?php endif; ?>
    <?php if ($border == 3) : ?>
        <style>
            body {
                background: #000;
            }

            .content-top {
                background: #000;
                height: 60vh;
                width: 100%;
            }

            .content-bottom {
                height: 40vh;
                width: 100%;
            }

            .top {
                background: #000;
                height: 60vh;
                padding: 0;
            }

            .bottom {
                background: #000;
                height: 40vh;
                padding: 0;
            }
        </style>
    <?php endif; ?>
</head>

<body>
    <div class="loader">
        <div class="lds-facebook locate-middle">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="row my-0">
            <?php if ($border == 1) : ?>
                <div class="col-12 header">
                    <img src="<?= BASE_URL; ?>/assets/upn-logo.png" width="180" style="margin-top: 15px;">
                </div>
            <?php endif; ?>
            <div class="col-8 top" style="overflow: hidden; position: relative" id="grid1"> <?php foreach ($drops as $item) : if ($item->grid == 1) : ?> <video class="video video-slide">
                            <source src=" <?= BASE_URL; ?>uploads/<?= $item->name; ?>" type="video/mp4" />
                        </video>
                <?php endif;
                                                                                            endforeach; ?>
            </div>
            <div class="col-4 top" style="overflow: hidden;">
                <div style="height: 7vh; padding: 10px; background: #333; color: #FFF;">
                    <h4 class="my-0">
                        Cronograma&nbsp;<?= $month; ?>
                    </h4>
                </div>
                <div class="row p-3 m-0" style="background: #FFF; height: 53vh; overflow: hidden" ref="timeline" id="timeScroll">
                    <div class="col-md-12 mx-auto">
                        <ul class="timeline">
                            <?php foreach ($schedule->tasks as $item) : ?>
                                <li>
                                    <strong><?= $item->title ?></strong>
                                    <span class="float-right day font-weight-bolder">&nbsp;<?= $item->date; ?></span>
                                    <p><?= $item->description; ?></p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-0">
            <div class="col-4 bottom" id="gridImage" ref="grid3">
                <?php foreach ($drops as $item) : if ($item->grid == 3) : ?>
                        <div class="content-bottom" style="background-image: url('<?= BASE_URL; ?>uploads/<?= $item->name; ?>'); background-size: 100% 100%;"></div>
                <?php endif;
                endforeach; ?>
            </div>
            <div class="col-4 bottom" id="gridImage" ref="grid4">
                <?php foreach ($drops as $item) : if ($item->grid == 4) : ?>
                        <div class="content-bottom" style="background-image: url('<?= BASE_URL; ?>uploads/<?= $item->name; ?>'); background-size: 100% 100%;"></div>
                <?php endif;
                endforeach; ?>
            </div>
            <div class="col-4 bottom" id="gridImage" ref="grid5">
                <?php foreach ($drops as $item) : if ($item->grid == 5) : ?>
                        <div class="content-bottom" style="background-image: url('<?= BASE_URL; ?>uploads/<?= $item->name; ?>'); background-size: 100% 100%;"></div>
                <?php endif;
                endforeach; ?>
            </div>
        </div>
    </div>

    <script src="<?= BASE_URL; ?>assets/jquery.min.js"></script>
    <script src="<?= BASE_URL; ?>assets/slick.min.js"></script>
    <script src="<?= BASE_URL; ?>assets/plyr.min.js"></script>
</body>

</html>

<input type="hidden" name="uuid" value="<?= $uuid; ?>">
<input type="hidden" name="url" value="<?= BASE_URL; ?>">

<script>
    $("[id='gridImage']").slick({
        autoplay: true,
        autoplaySpeed: 6000,
        arrows: false,
        fade: true
    });

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

    $(document).ready(function() {
        var slideIndex = 0;
        showSlides();

        function showSlides() {
            var i;
            var slides = document.getElementsByClassName("video-slide");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) {
                slideIndex = 1;
            }
            slides[slideIndex - 1].style.display = "block";
            $(".video-slide")
                .get(slideIndex - 1)
                .play();
            var vidDur = $(".video-slide").get(slideIndex - 1).duration * 1000;
            setTimeout(showSlides, vidDur); // Change image every 2 seconds
        }
    });

    $(window).on("load", function() {
        $(".loader").fadeOut("fast");

        $('[ref="timeline"]').animate({
            scrollTop: $('[ref="timeline"]')[0].scrollHeight
        }, 60000);

        $('[ref="timeline"]').on("scroll", function() {
            var div = document.getElementById("timeScroll");
            if (div.offsetHeight + div.scrollTop >= div.scrollHeight) {
                $('[ref="timeline"]').animate({
                    scrollTop: 0
                }, 2000);

                $('[ref="timeline"]').animate({
                    scrollTop: $('[ref="timeline"]')[0].scrollHeight
                }, 60000);
            }
        })
    });
</script>