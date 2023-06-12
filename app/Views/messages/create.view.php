<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <nav>
        <a href="/">HOME</a>
    </nav>
    <h1>Create</h1>


    <form method="POST" action="/messages/store">
        <div class="row">
            <div class="col">
                <label for="msg"></label>
                <textarea name="msg" id="msg" cols="30" rows="10"></textarea>
            </div>
        </div>
        <input type="submit">
    </form>

</body>
</html>