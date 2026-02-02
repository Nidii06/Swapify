<?php
// Quick debug to see if search_skills.php is working
require_once '../app/controllers/SkillController.php';

try {
    $controller = new SkillController();
    $skills = $controller->search(null, null, null);
    
    echo "<h2>Debug: Skills Found: " . count($skills) . "</h2>";
    
    if (count($skills) > 0) {
        echo "<p style='color: green;'><strong>✓ Skills are in database and being retrieved!</strong></p>";
        echo "<h3>First Skill Example:</h3>";
        echo "<pre>";
        print_r($skills[0]);
        echo "</pre>";
    } else {
        echo "<p style='color: red;'><strong>✗ No skills found in database</strong></p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'><strong>Error: " . $e->getMessage() . "</strong></p>";
}
?>
<a href="browse_skills.php">← Back to Browse Skills</a>
