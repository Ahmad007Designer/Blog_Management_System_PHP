
<footer class="fixed-bottom border-top text-center py-2 text-white"
    style="background: rgba(0, 128, 128, 1); padding: 0.50rem 1rem; font-size: 1.25rem; font-weight: bold;">
    <small>
        &copy; <?= date('Y') ?> | Developed by Ahmad Husain 
        <span style="font-family: 'Segoe UI Emoji', sans-serif;">❣</span>
    </small>
</footer>



<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<link rel="stylesheet" href="<?= base_url('assets/bootstrap-icons/bootstrap-icons.css') ?>">


<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>

<script>
  window.addEventListener('DOMContentLoaded', () => {
    CKEDITOR.replace('content');
  });
</script>

</body>
</html>