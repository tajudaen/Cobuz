<?php require ROOT . DS . 'app' . DS . 'views' . DS . 'includes' . DS . 'header.php'; ?>
<ul>
    <?php foreach($data['users'] as $user): ?>
        <li><?php echo $user->username; ?></li>
    <?php endforeach; ?>
</ul>
<?php require ROOT . DS . 'app' . DS . 'views' . DS . 'includes' . DS . 'footer.php'; ?>