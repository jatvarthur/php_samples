<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Числа Фибоначчи</title>
    <style>
        table {
            border-collapse: collapse;
            border-spacing: 0;
            border-color: grey;
        }

        th {
            background-color: lightgray;
            padding: 0.4em 0.4em;
            min-width: 10em;
            text-align: center;
        }

        td {
            padding: 0.4em 0.4em;
            min-width: 10em;
            text-align: center;
        }

        tr.even {
            background-color: aquamarine;
        }

        tr.odd {

        }
    </style>
</head>
<body>
<h1>Числа Фибоначчи</h1>
<table border="1">
    <tr class="head">
        <th>Номер</th>
        <th>Число</th>
    </tr>
    <?php foreach($fibs as $index=>$F): ?>
        <tr class="<?= $index % 2 == 1 ? 'odd' : 'even' ?>">
            <td>F<sub><?php echo $index; ?></sub></td>
            <td><?php echo $F; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
