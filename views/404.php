<?php
    header("HTTP/1.1 404 Not Found");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/default.css">
    <title>catalog-site</title>
</head>

<body>

    <div class="b-header">
        <div class="header__wrapper">
            <div class="header__title">
                CATALOG-SITE
            </div>
        </div>
    </div>

    <div class="b-error">
        <div class="error__wrapper">
            <div class="error__title">
                Упс, произошла ошибка
            </div>
            <div class="error__msg">
                Похоже, что запрашиваемая страница не существует...
            </div>
            <div class="error__code">
                Код ошибки: 404
            </div>
        </div>
    </div>

</body>

</html>