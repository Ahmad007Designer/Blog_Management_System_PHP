
<footer class="fixed-bottom border-top text-center py-2  text-white"
style="background: rgba(0, 128, 128, 1); color: white; padding: 0.50rem 1rem; font-size: 1.25rem; font-weight: bold;">
    <small>&copy; <?=date('Y')?> | Developed by Ahmad Husain ❣</small>
</footer>
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>

<script src="<?= base_url('assets/ckeditor5/build/ckeditor.js') ?>"></script>

<script>
  ClassicEditor
    .create(document.querySelector('#editor'), {
      ckfinder: {
        uploadUrl: "<?= base_url('index.php/upload/image') ?>"
      },

    })
    .then(editor => {
      window.editor = editor;
    })
    .catch(error => {
      console.error('Editor failed:', error);
    });
</script>





</body>
</html>