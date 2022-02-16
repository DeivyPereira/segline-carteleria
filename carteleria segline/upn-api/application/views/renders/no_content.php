<link rel="stylesheet" href="<?= BASE_URL; ?>assets/bootstrap.min.css">
<script src="<?= BASE_URL; ?>assets/jquery.min.js"></script>

<div style="width: 100%; height: 100vh; position: relative; background: #000">
    <div class="text-center text-white" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); width: 90%">
        <h1>¡No hay contenido para mostrar!</h1>
    </div>
</div>

<script>
    var myVar = setInterval(check, 300000);

    function check() {
        location.reload(true);
    }
</script>