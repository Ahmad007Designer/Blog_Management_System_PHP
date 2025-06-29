  </main>

  <footer class="border-top text-center py-2 text-white"
          style="background: rgba(0, 128, 128, 1); font-size: 1.1rem; font-weight: bold;">
    <small>
      &copy; <?= date('Y') ?> | Developed by Ahmad Husain
      <span style="font-family: 'Segoe UI Emoji', sans-serif;">❣</span>
    </small>
  </footer>

  <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
  <script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>


  <script>
    window.addEventListener('DOMContentLoaded', () => {
      if (document.getElementById('content')) {
        CKEDITOR.replace('content');
      }
    });
  </script>

  <script>
  document.addEventListener('DOMContentLoaded', function () {
    const userBtn = document.getElementById('userBtn');
    const userPanel = document.getElementById('userPanel');

    userBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      userPanel.style.display = (userPanel.style.display === 'none' || userPanel.style.display === '') ? 'block' : 'none';
    });

    document.addEventListener('click', function (e) {
      if (!userPanel.contains(e.target) && e.target !== userBtn) {
        userPanel.style.display = 'none';
      }
    });
  });
</script>
</body>
</html>
