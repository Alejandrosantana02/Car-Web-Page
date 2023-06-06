<ul>
    <?php foreach (($result?:[]) as $item): ?>
        <li><?= ($item['id']) ?> - <?= ($item['photo']) ?></li>
    <?php endforeach; ?>
    </ul>