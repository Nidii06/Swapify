<h2>My Skills</h2>

<?php foreach ($skills as $skill): ?>
    <div>
        <strong><?php echo htmlspecialchars($skill['title']); ?></strong>
        (<?php echo htmlspecialchars($skill['level']); ?>)
        <p><?php echo htmlspecialchars($skill['description']); ?></p>

        <a href="delete_skill.php?id=<?php echo $skill['id']; ?>">Delete</a>
    </div>
<?php endforeach; ?>
