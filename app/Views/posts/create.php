<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Create Post</title>

  <!-- Load TinyMCE locally -->
  <script src="assets/tinymce/tinymce.min.js"></script>

  <style>
    body {
      font-family: Arial, sans-serif;
      background: #fff;
      padding: 40px;
    }
    .container {
      border: 1px solid #f99;
      padding: 20px;
      border-radius: 10px;
      max-width: 900px;
      margin: auto;
    }
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .title-input {
      width: 100%;
      padding: 10px;
      font-size: 1.2em;
      margin: 20px 0;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    .btn-group {
      text-align: right;
      margin-top: 15px;
    }
    .btn {
      padding: 8px 16px;
      border: none;
      border-radius: 5px;
      margin-left: 10px;
      cursor: pointer;
    }
    .save-btn { background-color: #ff3b30; color: #fff; }
    .delete-btn { background-color: #eee; color: #000; }
  </style>
</head>
<body>

  <div class="container">
    <div class="header">
      <h2>Postify</h2>
      <div>
        <button class="btn delete-btn">View Post</button>
        <button class="btn delete-btn">Delete</button>
        <button class="btn save-btn">Save Post</button>
      </div>
    </div>

    <input type="text" placeholder="Post Title" class="title-input" />

    <textarea id="editor" placeholder="Type or paste your content here!"></textarea>
  </div>

  <script>
    tinymce.init({
      selector: '#editor',
      height: 300,
      menubar: true,
      plugins: 'lists link image table code help wordcount',
      toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table | code',
    });
  </script>

</body>
</html>
