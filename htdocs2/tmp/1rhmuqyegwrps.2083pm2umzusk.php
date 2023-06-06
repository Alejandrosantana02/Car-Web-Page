<style>
    label {
        display: inline-block;
        width: 5em;
        text-align: right;
    }
</style>

<pre>
    <?php print_r($fields) ?>
</pre>

<form method="post">
<input type="hidden" name="id" value="<?= ($item['id']) ?>">
<label for="name" class="form-label">Brand and Model:</label>
<input type="text" name="name" value="<?= ($item['name']) ?>" class="form-control"><br>
<label for="time">0-60MPH:</label>
<input type="text" name="time" value="<?= ($item['time']) ?>" class="form-control"><br>
<label for="horsepower">Horsepower:</label>
<input type="text" name="horsepower" value="<?= ($item['horsepower']) ?>" class="form-control"><br>
<label for="year">Year:</label>
<input type="text" name="year" value="<?= ($item['year']) ?>" class="form-control"><br>
<label for="price">Price:</label>
<input type="price" name="price" value="<?= ($item['price']) ?>" class="form-control"><br>
<label for="description">Description:</label>
<input type="description" name="description" value="<?= ($item['description']) ?>" class="form-control"><br>

<input type="submit" value="Save" name="action" class="btn btn-primary">
<input type="submit" value="Delete" name="action" class="btn btn-primary">
</form>
<p><a href="/edit/new">New Item Form</a></p>
<?php if ($item['id']): ?>
<p><a href="/detail/<?= ($item['id']) ?>">Back to Detail</a></p>
<?php endif; ?>


