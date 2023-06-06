
        <?php for ($car_map;!$car_map->dry();$car_map->next()): ?>
            <li><a href="/detail/<?= ($car_map['id']) ?>"><?= ($car_map['name']) ?></a></li>
        <?php endfor; ?>

    