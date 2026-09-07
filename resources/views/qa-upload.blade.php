<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>Apps QA upload</title></head>
<body>
    <form method="post" action="/qa/upload" enctype="multipart/form-data">
        @csrf
        <label>Upload <input type="file" name="file" required></label>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
