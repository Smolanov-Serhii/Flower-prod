<?php
/**
 * Template Name: Parse
 */

if (!current_user_can('administrator')) {
    status_header(404);
    die;
}

$terms = new WP_Term_Query(array(
    'taxonomy' => array('type'), //ur taxonomy
    'hide_empty' => false,
));

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Спарсить csv</title>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        .info {
            background-color: #e7f3fe;
            border-left: 6px solid #2196F3;
        }
    </style>
</head>
<body>

<h1>Parse products from .csv file</h1>

<div class="info">
    <p><strong>Инфо!</strong> Выберите файл, который надо спарсить, выберите соответствующие категории и нажмите кнопку
        "Загрузить". Разбейте файлы на куски(желательно <= 500 товаров в файле). Файл должен соответствовать вашему
        шаблону, который вы скинули. Картинки должны быть залиты перед созданием продуктов и должны иметь название
        продукта</p>
</div>

<form action="<?= ADMIN_AJAX; ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="parse_csv">
    <?php if (!empty($terms) && !empty($terms->terms)): ?>
        <label for="tags">Выберите категорию (вы можете выбрать несколько, для этого зажмите "ctrl")</label>
        <select id="tags" name="categories[]" multiple required>
            <?php foreach ($terms->terms as $term): ?>
                <option value="<?= $term->term_id; ?>"><?= $term->name; ?></option>
            <?php endforeach; ?>
        </select>
    <?php endif; ?>
    <label for="file">Выберите файл (расширение .csv)</label>
    <input id="file" type="file" accept=".csv" name="file" required/>
    <button type="submit">Загрузить</button>
</form>
</body>
</html>
